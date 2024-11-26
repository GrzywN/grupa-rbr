<script setup lang="ts">
import { TaskPriority } from '@features/tasks/schemas/task-priority.schema';
import { TaskStatus } from '@features/tasks/schemas/task-status.schema';
import { computed } from 'vue';

export type StatusBadgeProps = {
    value: string;
    options: (TaskPriority | TaskStatus)[];
    isLoading?: boolean;
};

const props = defineProps<StatusBadgeProps>();

const option = computed(() => {
    return props.options.find((option) => option.value === props.value);
});

const severity = computed(() => {
    return option.value?.severity || 'secondary';
});

const description = computed(() => {
    return option.value?.label || 'Unknown';
});
</script>

<template>
    <Skeleton v-if="props.isLoading" class="h-6 w-20" />
    <Tag v-else :severity="severity" :value="description" />
</template>
