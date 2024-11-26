import { date, object, string, type InferType } from 'yup';

const TITLE_MAX_LENGTH = 255 as const;
const DESCRIPTION_MAX_LENGTH = 4000 as const;

const TITLE_REQUIRED =
    'Title is required. Name your task to easily identify it later.' as const;
const TITLE_TOO_LONG =
    'Title is too long. Keep it short and simple below 255 characters.' as const;
const DESCRIPTION_TOO_LONG =
    'Description is too long. Keep it below 4000 characters.' as const;
const PRIORITY_REQUIRED =
    'Priority is required. Set the importance level of this task.' as const;
const STATUS_REQUIRED =
    'Status is required. Define the current state of this task.' as const;
const DEADLINE_REQUIRED =
    'Deadline is required. Choose when this task needs to be completed.' as const;

export const createTaskFormSchema = object().shape({
    title: string()
        .required(TITLE_REQUIRED)
        .min(1, TITLE_REQUIRED)
        .max(TITLE_MAX_LENGTH, TITLE_TOO_LONG),
    description: string()
        .nullable()
        .max(DESCRIPTION_MAX_LENGTH, DESCRIPTION_TOO_LONG),
    priority: string().required(PRIORITY_REQUIRED),
    status: string().required(STATUS_REQUIRED),
    deadline: date().required(DEADLINE_REQUIRED),
});

export type CreateTaskForm = InferType<typeof createTaskFormSchema>;
