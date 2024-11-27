import taskService from '@features/tasks/services/task.service';
import { useQuery } from '@tanstack/vue-query';

export const TASK_QUERY_KEY = 'task';

export const useGetTask = (taskId: number) =>
    useQuery({
        queryKey: [TASK_QUERY_KEY, taskId],
        queryFn: () => taskService.getTask(taskId),
        staleTime: 0,
    });
