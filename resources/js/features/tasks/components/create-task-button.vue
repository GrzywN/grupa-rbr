<script setup lang="ts">
import CreateTaskForm from '@features/tasks/components/create-task-form.vue';
import { ref } from 'vue';

const isCreateNewTaskDialogVisible = ref(false);

const handleCreateTask = () => {
    isCreateNewTaskDialogVisible.value = true;
};

const handleSuccess = () => {
    isCreateNewTaskDialogVisible.value = false;
};
</script>

<template>
    <Button
        icon="ph-light ph-plus"
        rounded
        severity="primary"
        aria-label="Create new task"
        @click="handleCreateTask"
    />
    <Dialog
        v-model:visible="isCreateNewTaskDialogVisible"
        modal
        header="Create New Task"
        :style="{ width: '25rem' }"
        :draggable="false"
    >
        <span class="text-surface-500 dark:text-surface-400 block">
            Start tracking your work by adding details about what needs to be
            done.
        </span>
        <CreateTaskForm @success="handleSuccess" />
    </Dialog>
</template>
