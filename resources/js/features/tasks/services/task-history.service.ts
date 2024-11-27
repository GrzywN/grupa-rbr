import { httpClient } from '@shared/api/http-client';
import {
    taskHistoriesSchema,
    type TaskHistory,
} from '../schemas/task-history.schema';

class TaskHistoryService {
    public async getTaskHistory(taskId: number): Promise<TaskHistory[]> {
        const response = await httpClient.get(
            route('task-history.index', taskId),
        );
        const taskHistories = await taskHistoriesSchema.validate(response, {
            strict: true,
        });

        return taskHistories ?? [];
    }
}

const taskHistoryService = new TaskHistoryService();

export default taskHistoryService;
