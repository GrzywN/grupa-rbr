import taskPriorityService from '@features/tasks/services/task-priority.service';
import { useQuery } from '@tanstack/vue-query';

export const TASK_PRIORITIES_QUERY_KEY = 'task-priorities';

export const useGetTaskPriorities = () =>
    useQuery({
        queryKey: [TASK_PRIORITIES_QUERY_KEY],
        queryFn: taskPriorityService.getTaskPriorities,
        staleTime: Infinity,
    });
