import taskService from '@features/tasks/services/task.service';
import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { TASKS_QUERY_KEY } from './use-get-tasks.composable';

export const useDeleteTask = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: taskService.deleteTask,
        onSettled: () => {
            queryClient.invalidateQueries({ queryKey: [TASKS_QUERY_KEY] });
        },
    });
};
