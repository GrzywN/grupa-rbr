<script setup lang="ts">
import { type TaskPriority } from '@features/tasks/schemas/task-priority.schema';
import { type TaskStatus } from '@features/tasks/schemas/task-status.schema';
import StatusBadge from '@shared/ui/status-badge.vue';

export type TaskStatusComparisonProps = {
    values: string[];
    options: (TaskPriority | TaskStatus)[];
    isLoading: boolean;
};

defineProps<TaskStatusComparisonProps>();
</script>

<template>
    <p class="flex items-center gap-2">
        <StatusBadge
            class="flex-shrink-0"
            :value="values[0]"
            :options="options"
            :is-loading="isLoading"
        />
        <i v-if="values.length === 2" class="ph-light ph-arrow-right" />
        <StatusBadge
            v-if="values.length === 2"
            :value="values[1]"
            :options="options"
            :is-loading="isLoading"
        />
    </p>
</template>
