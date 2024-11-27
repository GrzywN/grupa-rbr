import taskService from '@features/tasks/services/task.service';
import { useQuery } from '@tanstack/vue-query';

export const TASKS_QUERY_KEY = 'tasks';

export const useGetTasks = () =>
    useQuery({
        queryKey: [TASKS_QUERY_KEY],
        queryFn: taskService.getTasks,
        staleTime: 0,
    });
