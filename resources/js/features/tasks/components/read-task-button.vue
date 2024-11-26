<script setup lang="ts">
import { dateFormat } from '@shared/utils/date-format.util';
import { ref } from 'vue';
import { type Task } from '../schemas/task.schema';

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
        <article class="mt-4">
            <h3 class="text-lg font-semibold">Title</h3>
            <p>{{ task.title }}</p>
        </article>
        <article class="mt-4">
            <h3 class="text-lg font-semibold">Description</h3>
            <p>{{ task.description }}</p>
        </article>
        <article class="mt-4">
            <h3 class="text-lg font-semibold">Priority</h3>
            <p>{{ task.priority }}</p>
        </article>
        <article class="mt-4">
            <h3 class="text-lg font-semibold">Status</h3>
            <p>{{ task.status }}</p>
        </article>
        <article class="mt-4">
            <h3 class="text-lg font-semibold">Deadline</h3>
            <p>{{ dateFormat(task.deadline) }}</p>
        </article>
        <Button
            class="mt-4 w-full"
            type="button"
            label="Close"
            @click="handleSuccess"
        />
    </Dialog>
</template>
