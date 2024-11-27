<script setup lang="ts">
export type TaskChangeComparisonProps = {
    values: string[];
};

defineProps<TaskChangeComparisonProps>();
</script>

<template>
    <p class="flex items-center gap-2">
        <span>{{ values[0] }}</span>
        <i v-if="values.length === 2" class="ph-light ph-arrow-right" />
        <span v-if="values.length === 2">{{ values[1] }}</span>
    </p>
</template>
