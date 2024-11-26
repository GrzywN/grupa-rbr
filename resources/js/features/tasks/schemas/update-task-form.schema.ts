import { type InferType } from 'yup';
import { createTaskFormSchema } from './create-task-form.schema';

export const updateTaskFormSchema = createTaskFormSchema;

export type UpdateTaskForm = InferType<typeof updateTaskFormSchema>;
