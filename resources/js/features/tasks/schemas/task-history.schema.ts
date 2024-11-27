import { array, number, object, string, type InferType } from 'yup';
import { taskHistoryDiffSchema } from './task-history-diff.schema';

export const taskHistorySchema = object().shape({
    id: number().integer().required(),
    title: string().required(),
    description: string().required(),
    priority: string().required(),
    status: string().required(),
    deadline: string().required(),
    event: string().required(),
    diff: taskHistoryDiffSchema.nullable(),
    created_at: string().required(),
});

export const taskHistoriesSchema = array().of(taskHistorySchema);

export type TaskHistory = InferType<typeof taskHistorySchema>;
