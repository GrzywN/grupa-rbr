import taskService from '@features/tasks/services/task.service';
import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { CreateTaskForm } from '../schemas/create-task-form.schema';
import { Task } from '../schemas/task.schema';
import { TASKS_QUERY_KEY } from './use-get-tasks.composable';

const predictNewTaskId = (tasks: Task[]): number => {
    return (
        tasks.reduce((acc: number, task: Task) => Math.max(acc, task.id), 0) + 1
    );
};

// https://tanstack.com/query/v4/docs/framework/vue/guides/optimistic-updates
export const useCreateTask = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: taskService.createTask,
        onMutate: async (data: CreateTaskForm) => {
            await queryClient.cancelQueries({ queryKey: [TASKS_QUERY_KEY] });

            const previousTasks = queryClient.getQueryData([TASKS_QUERY_KEY]);
            queryClient.setQueryData([TASKS_QUERY_KEY], (old: Task[]) => [
                ...old,
                { ...data, id: predictNewTaskId(old) },
            ]);

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
