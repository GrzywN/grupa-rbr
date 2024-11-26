import { httpClient } from '@shared/api/http-client';
import {
    taskPrioritiesSchema,
    type TaskPriority,
} from '../schemas/task-priority.schema';

class TaskPriorityService {
    public async getTaskPriorities(): Promise<TaskPriority[]> {
        const response = await httpClient.get(route('task-priorities.index'));
        const tasks = await taskPrioritiesSchema.validate(response, {
            strict: true,
        });

        return tasks ?? [];
    }
}

const taskPriorityService = new TaskPriorityService();

export default taskPriorityService;
