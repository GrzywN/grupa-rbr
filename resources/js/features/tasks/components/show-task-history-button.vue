<script setup lang="ts">
import { ref } from 'vue';
import { type Task } from '../schemas/task.schema';
import TaskHistory from './task-history.vue';

export type ReadTaskButtonProps = {
    task: Task;
};

defineProps<ReadTaskButtonProps>();

const isReadTaskDialogVisible = ref(false);

const handleReadTask = () => {
    isReadTaskDialogVisible.value = true;
};

const handleSuccess = () => {
    isReadTaskDialogVisible.value = false;
};
</script>

<template>
    <Button
        icon="ph-light ph-list-magnifying-glass"
        rounded
        severity="success"
        aria-label="Show history"
        @click="handleReadTask"
    />
    <Dialog
        v-model:visible="isReadTaskDialogVisible"
        modal
        header="Task History"
        :style="{ width: '25rem' }"
        :draggable="false"
    >
        <span class="text-surface-500 dark:text-surface-400 block">
            Track all changes and updates made to this task over time.
        </span>

        <TaskHistory :task="task" />

        <Button
            class="mt-4 w-full"
            type="button"
            label="Close"
            @click="handleSuccess"
        />
    </Dialog>
</template>
