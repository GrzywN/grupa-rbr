import { array, object, string, type InferType } from 'yup';

export const taskPrioritySchema = object().shape({
    value: string().required(),
    label: string().required(),
    severity: string().required().oneOf(['success', 'info', 'warn', 'danger']),
});

export const taskPrioritiesSchema = array().of(taskPrioritySchema);

export type TaskPriority = InferType<typeof taskPrioritySchema>;
