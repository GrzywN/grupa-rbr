import {
    type Task,
    taskSchema,
    tasksSchema,
} from '@features/tasks/schemas/task.schema';
import { httpClient } from '@shared/api/http-client';
import { AxiosError } from 'axios';
import { CreateTaskForm } from '../schemas/create-task-form.schema';
import { UpdateTaskForm } from '../schemas/update-task-form.schema';

class TaskService {
    public async getTasks(): Promise<Task[]> {
        const response = await httpClient.get(route('tasks.index'));
        const tasks = await tasksSchema.validate(response, { strict: true });

        return tasks ?? [];
    }

    public async getTask(taskId: number): Promise<Task> {
        const response = await httpClient.get(route('tasks.show', taskId));
        return await taskSchema.validate(response, { strict: true });
    }

    public async createTask(data: CreateTaskForm): Promise<Task> {
        const response = await httpClient.post(route('tasks.store'), data);
        return await taskSchema.validate(response, { strict: true });
    }

    public async updateTask(
        taskId: number,
        data: UpdateTaskForm,
    ): Promise<Task> {
        const response = await httpClient.put(
            route('tasks.update', taskId),
            data,
        );
        return await taskSchema.validate(response, { strict: true });
    }

    public async deleteTask(taskId: number): Promise<void> {
        try {
            await httpClient.delete(route('tasks.destroy', taskId));
        } catch (error) {
            if (
                error instanceof AxiosError &&
                error?.response?.status === 404
            ) {
                return;
            }
        }
    }
}

const taskService = new TaskService();

export default taskService;
