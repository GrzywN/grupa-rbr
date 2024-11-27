import { object, string, type InferType } from 'yup';

export const taskHistoryDiffSchema = object().shape({
    title: string().nullable(),
    description: string().nullable(),
    priority: string().nullable(),
    status: string().nullable(),
    deadline: string().nullable(),
});

export type TaskHistoryDiff = InferType<typeof taskHistoryDiffSchema>;
