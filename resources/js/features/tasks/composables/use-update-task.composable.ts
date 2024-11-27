import taskService from '@features/tasks/services/task.service';
import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { taskSchema, type Task } from '../schemas/task.schema';
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
        onMutate: async ({
            taskId,
            data,
        }: {
            taskId: number;
            data: UpdateTaskForm;
        }) => {
            await queryClient.cancelQueries({ queryKey: [TASKS_QUERY_KEY] });
            await queryClient.cancelQueries({
                queryKey: [TASK_QUERY_KEY, taskId],
            });
            await queryClient.cancelQueries({
                queryKey: [TASK_HISTORY_QUERY_KEY, taskId],
            });

            const previousTasks = queryClient.getQueryData([TASKS_QUERY_KEY]);
            const previousTask = queryClient.getQueryData([
                TASK_QUERY_KEY,
                taskId,
            ]);

            queryClient.setQueryData([TASKS_QUERY_KEY], (old: Task[]) =>
                old.map((task: Task) =>
                    task.id === taskId
                        ? taskSchema.validate({ ...task, ...data })
                        : task,
                ),
            );

            queryClient.setQueryData([TASK_QUERY_KEY, taskId], (old: Task) =>
                taskSchema.validate({ ...old, ...data }),
            );

            return { previousTasks, previousTask };
        },
        onError: (_err, variables, context) => {
            queryClient.setQueryData([TASKS_QUERY_KEY], context!.previousTasks);
            queryClient.setQueryData(
                [TASK_QUERY_KEY, variables.taskId],
                context!.previousTask,
            );
        },
        onSettled: (task) => {
            queryClient.invalidateQueries({ queryKey: [TASKS_QUERY_KEY] });
            queryClient.invalidateQueries({
                queryKey: [TASK_QUERY_KEY, task!.id],
            });
            queryClient.invalidateQueries({
                queryKey: [TASK_HISTORY_QUERY_KEY],
            });
        },
    });
};
