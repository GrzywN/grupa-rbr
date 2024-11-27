<script setup lang="ts">
import UpdateTaskForm from '@features/tasks/components/update-task-form.vue';
import { ref } from 'vue';
import { useGetTask } from '../composables/use-get-task.composable';

export type UpdateTaskButtonProps = {
    taskId: number;
};

const props = defineProps<UpdateTaskButtonProps>();

const { data: task, refetch } = useGetTask(props.taskId);

const isUpdateTaskDialogVisible = ref(false);

const handleUpdateTask = async () => {
    await refetch();
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
        <UpdateTaskForm v-if="task" :task="task" @success="handleSuccess" />
    </Dialog>
</template>
