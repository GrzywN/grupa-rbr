import { useQuery } from '@tanstack/vue-query';
import taskStatusService from '../services/task-status.service';

export const TASK_STATUSES_QUERY_KEY = 'task-statuses';

export const useGetTaskStatuses = () =>
    useQuery({
        queryKey: [TASK_STATUSES_QUERY_KEY],
        queryFn: taskStatusService.getTaskStatuses,
        staleTime: Infinity,
    });
