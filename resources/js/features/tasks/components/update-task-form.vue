<script setup lang="ts">
import FormField from '@shared/components/form/form-field.vue';
import { useToastMessage } from '@shared/composables/use-toast-message.composable';
import DatePicker from 'primevue/datepicker';
import Dropdown from 'primevue/dropdown';
import Textarea from 'primevue/textarea';
import { useForm } from 'vee-validate';
import { useGetTaskPriorities } from '../composables/use-get-task-priorities.composable';
import { useGetTaskStatuses } from '../composables/use-get-task-statuses.composable';
import { useUpdateTask } from '../composables/use-update-task.composable';
import { type Task } from '../schemas/task.schema';
import {
    UpdateTaskForm,
    updateTaskFormSchema,
} from '../schemas/update-task-form.schema';

export type UpdateTaskFormProps = {
    task: Task;
};

const { task } = defineProps<UpdateTaskFormProps>();

const emit = defineEmits<{
    success: [];
}>();

const { error } = useToastMessage();

const { data: priorityOptions, isLoading: arePrioritiesLoading } =
    useGetTaskPriorities();
const { data: statusOptions, isLoading: areStatusesLoading } =
    useGetTaskStatuses();

const { handleSubmit } = useForm<UpdateTaskForm>({
    initialValues: {
        title: task.title,
        description: task.description,
        priority: task.priority,
        status: task.status,
        deadline: new Date(task.deadline),
    },
    validationSchema: updateTaskFormSchema,
});

const { mutateAsync } = useUpdateTask();

const onSubmit = handleSubmit(async (values: UpdateTaskForm) => {
    await mutateAsync(
        { taskId: task.id, data: values },
        {
            onSuccess: () => {
                emit('success');
            },
            onError: () => {
                error(
                    'Something went wrong.',
                    'Failed to edit task. Please try again or contact support.',
                );
            },
        },
    );
});
</script>

<template>
    <form class="grid grid-cols-1 gap-2 py-4">
        <FormField name="title" label="Title" :isRequired="true" />
        <FormField
            :component="Textarea"
            name="description"
            label="Description"
            :isRequired="false"
        />
        <FormField
            :component="Dropdown"
            name="priority"
            label="Priority"
            :options="priorityOptions"
            option-label="label"
            option-value="value"
            :is-required="true"
            :is-loading="arePrioritiesLoading"
        >
            <template #skeleton>
                <Skeleton width="100%" height="2.875rem" />
            </template>
        </FormField>
        <FormField
            :component="Dropdown"
            name="status"
            label="Status"
            :options="statusOptions"
            option-label="label"
            option-value="value"
            :is-required="true"
            :is-loading="areStatusesLoading"
        >
            <template #skeleton>
                <Skeleton width="100%" height="2.875rem" />
            </template>
        </FormField>
        <FormField
            :component="DatePicker"
            name="deadline"
            label="Deadline"
            :isRequired="true"
        />

        <Button class="mt-4" type="submit" label="Save" @click="onSubmit" />
    </form>
</template>
