import { array, object, string, type InferType } from 'yup';

export const taskHistoryEventSchema = object().shape({
    value: string().required(),
    label: string().required(),
    severity: string().required().oneOf(['success', 'info', 'warn', 'danger']),
});

export const taskHistoryEventsSchema = array().of(taskHistoryEventSchema);

export type TaskHistoryEvent = InferType<typeof taskHistoryEventSchema>;
