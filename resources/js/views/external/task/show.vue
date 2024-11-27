<script setup lang="ts">
import TaskPreview from '@features/tasks/components/task-preview.vue';
import { type Task } from '@features/tasks/schemas/task.schema';
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@shared/layouts/guest-layout.vue';

export type ShowPageProps = {
    task: Task;
};

defineProps<ShowPageProps>();
</script>

<template>
    <Head title="Task preview" />

    <GuestLayout>
        <div class="flex flex-col gap-4 py-12">
            <div class="mx-auto w-full max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <TaskPreview :task="task" />
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
