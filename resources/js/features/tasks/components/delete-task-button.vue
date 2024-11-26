<script setup lang="ts">
import { useConfirm } from 'primevue/useconfirm';
import { useDeleteTask } from '../composables/use-delete-task.composable';

export type DeleteTaskButtonProps = {
    taskId: number;
};

defineProps<DeleteTaskButtonProps>();

const confirm = useConfirm();
const deleteTask = useDeleteTask();

const handleDeleteTask = async (taskId: number) => {
    confirm.require({
        message: 'Are you sure you want to delete this task?',
        icon: 'ph-light ph-exclamation-mark',
        accept: async () => {
            await deleteTask.mutateAsync(taskId);
        },
    });
};
</script>

<template>
    <Button
        icon="ph-light ph-trash"
        rounded
        severity="danger"
        aria-label="Delete"
        @click="handleDeleteTask(taskId)"
    />
    <ConfirmPopup />
</template>
