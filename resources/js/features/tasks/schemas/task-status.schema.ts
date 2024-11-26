import { array, object, string, type InferType } from 'yup';

export const taskStatusSchema = object().shape({
    value: string().required(),
    label: string().required(),
    severity: string().required().oneOf(['success', 'info', 'warn', 'danger']),
});

export const taskStatusesSchema = array().of(taskStatusSchema);

export type TaskStatus = InferType<typeof taskStatusSchema>;
