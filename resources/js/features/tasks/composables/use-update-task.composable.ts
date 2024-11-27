import taskService from '@features/tasks/services/task.service';
import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { type UpdateTaskForm } from '../schemas/update-task-form.schema';
import { TASK_HISTORY_QUERY_KEY } from './use-get-task-history.composable';
import { TASK_QUERY_KEY } from './use-get-task.composable';
import { TASKS_QUERY_KEY } from './use-get-tasks.composable';

// https://tanstack.com/query/v4/docs/framework/vue/guides/optimistic-updates
export const useUpdateTask = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: ({
            taskId,
            data,
        }: {
            taskId: number;
            data: UpdateTaskForm;
        }) => taskService.updateTask(taskId, data),
        onSettled: (task) => {
            queryClient.invalidateQueries({ queryKey: [TASKS_QUERY_KEY] });
            queryClient.invalidateQueries({
                queryKey: [TASK_QUERY_KEY, task!.id],
            });
            queryClient.invalidateQueries({
                queryKey: [TASK_HISTORY_QUERY_KEY, task!.id],
            });
        },
    });
};
