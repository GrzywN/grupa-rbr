import taskService from '@features/tasks/services/task.service';
import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { taskSchema, type Task } from '../schemas/task.schema';
import { type UpdateTaskForm } from '../schemas/update-task-form.schema';
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

            const previousTasks = queryClient.getQueryData([TASKS_QUERY_KEY]);
            queryClient.setQueryData([TASKS_QUERY_KEY], (old: Task[]) =>
                old.map((task: Task) =>
                    task.id === taskId
                        ? taskSchema.validate({ ...task, ...data })
                        : task,
                ),
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
