import { useQuery } from '@tanstack/vue-query';
import taskHistoryService from '../services/task-history.service';

export const TASK_HISTORY_QUERY_KEY = 'task-history';

export const useGetTaskHistory = (taskId: number) =>
    useQuery({
        queryKey: [TASK_HISTORY_QUERY_KEY, taskId],
        queryFn: () => taskHistoryService.getTaskHistory(taskId),
        staleTime: 0,
    });
