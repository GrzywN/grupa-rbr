import { array, number, object, string, type InferType } from 'yup';

export const taskSchema = object().shape({
    id: number().integer().required(),
    title: string().required(),
    description: string().required(),
    priority: string().required(),
    status: string().required(),
    deadline: string().required(),
});

export const tasksSchema = array().of(taskSchema);

export type Task = InferType<typeof taskSchema>;
