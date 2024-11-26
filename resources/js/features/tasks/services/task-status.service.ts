import { httpClient } from '@shared/api/http-client';
import {
    taskStatusesSchema,
    type TaskStatus,
} from '../schemas/task-status.schema';

class TaskStatusService {
    public async getTaskStatuses(): Promise<TaskStatus[]> {
        const response = await httpClient.get(route('task-statuses.index'));
        const tasks = await taskStatusesSchema.validate(response, {
            strict: true,
        });

        return tasks ?? [];
    }
}

const taskStatusService = new TaskStatusService();

export default taskStatusService;
