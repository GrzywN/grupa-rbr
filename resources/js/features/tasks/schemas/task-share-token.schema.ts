import { array, number, object, string, type InferType } from 'yup';

export const taskShareTokenSchema = object().shape({
    task_id: number().integer().required(),
    token: string().required(),
    created_by: number().integer().required(),
    expires_at: string().nullable(),
    last_accessed_at: string().nullable(),
    created_at: string().required(),
});

export const taskShareTokensSchema = array().of(taskShareTokenSchema);

export type TaskShareToken = InferType<typeof taskShareTokenSchema>;
