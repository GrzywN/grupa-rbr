<script setup lang="ts">
import { ref } from 'vue';
import { useGetTask } from '../composables/use-get-task.composable';
import TaskPreview from './task-preview.vue';

export type ReadTaskButtonProps = {
    taskId: number;
};

const props = defineProps<ReadTaskButtonProps>();

const { data: task, refetch } = useGetTask(props.taskId);

const isReadTaskDialogVisible = ref(false);

const handleReadTask = async () => {
    await refetch();
    isReadTaskDialogVisible.value = true;
};

const handleSuccess = () => {
    isReadTaskDialogVisible.value = false;
};
</script>

<template>
    <Button
        icon="ph-light ph-eye"
        rounded
        severity="success"
        aria-label="Show"
        @click="handleReadTask"
    />
    <Dialog
        v-model:visible="isReadTaskDialogVisible"
        modal
        header="Task Details"
        :style="{ width: '25rem' }"
        :draggable="false"
    >
        <span class="text-surface-500 dark:text-surface-400 block">
            Review all information and progress related to this task.
        </span>

        <TaskPreview v-if="task" :task="task" />

        <Button
            class="mt-4 w-full"
            type="button"
            label="Close"
            @click="handleSuccess"
        />
    </Dialog>
</template>
