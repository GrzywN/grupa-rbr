import { number, object, type InferType } from 'yup';

const EXPIRES_IN_DAYS_MIN = 1 as const;
const EXPIRES_IN_DAYS_MAX = 30 as const;

const EXPIRES_IN_DAYS_MIN_MESSAGE =
    'Task expiration must be at least 1 day.' as const;
const EXPIRES_IN_DAYS_MAX_MESSAGE =
    'Task expiration must be at most 30 days.' as const;

export const shareTaskFormSchema = object().shape({
    expires_in_days: number()
        .nullable()
        .min(EXPIRES_IN_DAYS_MIN, EXPIRES_IN_DAYS_MIN_MESSAGE)
        .max(EXPIRES_IN_DAYS_MAX, EXPIRES_IN_DAYS_MAX_MESSAGE),
});

export type ShareTaskForm = InferType<typeof shareTaskFormSchema>;
