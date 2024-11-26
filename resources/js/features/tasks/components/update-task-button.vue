<script setup lang="ts">
import UpdateTaskForm from '@features/tasks/components/update-task-form.vue';
import { ref } from 'vue';
import { type Task } from '../schemas/task.schema';

export type UpdateTaskButtonProps = {
    task: Task;
};

defineProps<UpdateTaskButtonProps>();

const isUpdateTaskDialogVisible = ref(false);

const handleUpdateTask = () => {
    isUpdateTaskDialogVisible.value = true;
};

const handleSuccess = () => {
    isUpdateTaskDialogVisible.value = false;
};
</script>

<template>
    <Button
        icon="ph-light ph-pencil"
        rounded
        severity="warning"
        aria-label="Edit"
        @click="handleUpdateTask"
    />
    <Dialog
        v-model:visible="isUpdateTaskDialogVisible"
        modal
        header="Edit Task"
        :style="{ width: '25rem' }"
        :draggable="false"
    >
        <span class="text-surface-500 dark:text-surface-400 block">
            Update task details to keep your information accurate and
            up-to-date.
        </span>
        <UpdateTaskForm :task="task" @success="handleSuccess" />
    </Dialog>
</template>
