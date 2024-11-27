import { httpClient } from '@shared/api/http-client';
import {
    TaskShareToken,
    taskShareTokenSchema,
    taskShareTokensSchema,
} from '../schemas/task-share-token.schema';

class TaskSharingService {
    public async getShareTokens(taskId: number): Promise<TaskShareToken[]> {
        const response = await httpClient.get(
            route('tasks.shares.index', taskId),
        );
        const taskShareTokens = await taskShareTokensSchema.validate(response, {
            strict: true,
        });

        return taskShareTokens ?? [];
    }

    public async createExternalUrl(taskId: number): Promise<string> {
        const taskShareToken = await this.createShareToken(taskId);

        return route('tasks.shared', taskShareToken.token);
    }

    private async createShareToken(taskId: number): Promise<TaskShareToken> {
        const response = await httpClient.post(
            route('tasks.shares.store', taskId),
            {},
        );
        const taskShareToken = await taskShareTokenSchema.validate(response, {
            strict: true,
        });

        return taskShareToken;
    }

    public async deleteShareToken(
        taskId: number,
        token: string,
    ): Promise<void> {
        await httpClient.delete(route('tasks.shares.destroy', [taskId, token]));
    }
}

const taskSharingService = new TaskSharingService();

export default taskSharingService;
