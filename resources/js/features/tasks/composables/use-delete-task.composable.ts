import taskService from '@features/tasks/services/task.service';
import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { Task } from '../schemas/task.schema';
import { TASKS_QUERY_KEY } from './use-get-tasks.composable';

// https://tanstack.com/query/v4/docs/framework/vue/guides/optimistic-updates
export const useDeleteTask = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: taskService.deleteTask,
        onMutate: async (taskId: number) => {
            await queryClient.cancelQueries({ queryKey: [TASKS_QUERY_KEY] });

            const previousTasks = queryClient.getQueryData([TASKS_QUERY_KEY]);
            queryClient.setQueryData([TASKS_QUERY_KEY], (old: Task[]) =>
                old.filter((task) => task.id !== taskId),
            );

            return { previousTasks };
        },
        onError: (_err, _newTask, context) => {
            queryClient.setQueryData([TASKS_QUERY_KEY], context!.previousTasks);
        },
        onSettled: () => {
            queryClient.invalidateQueries({ queryKey: [TASKS_QUERY_KEY] });
        },
    });
};
