import { useQuery } from '@tanstack/vue-query';
import taskHistoryEventService from '../services/task-history-event.service';

export const TASK_HISTORY_EVENTS = 'task-history-events';

export const useGetTaskHistoryEvents = () =>
    useQuery({
        queryKey: [TASK_HISTORY_EVENTS],
        queryFn: taskHistoryEventService.getTaskHistoryEvents,
        staleTime: Infinity,
    });
