<script setup lang="ts">
import { useShareTask } from '../composables/use-share-task.composable';

export type ShareTaskButtonProps = {
    taskId: number;
};

defineProps<ShareTaskButtonProps>();

const { mutateAsync } = useShareTask();

const handleShareTask = async (taskId: number) => {
    await mutateAsync(taskId);
};
</script>

<template>
    <Button
        icon="ph-light ph-share"
        rounded
        severity="info"
        aria-label="Share"
        @click="handleShareTask(taskId)"
    />
</template>
