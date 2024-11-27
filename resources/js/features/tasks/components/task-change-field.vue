<script setup lang="ts">
export type TaskChangeFieldProps = {
    title: string;
    isChanged: boolean;
};

defineProps<TaskChangeFieldProps>();
</script>

<template>
    <article class="mt-4" :class="{ 'text-green-500': isChanged }">
        <h3 class="text-lg font-semibold">{{ title }}</h3>
        <slot />
    </article>
</template>
