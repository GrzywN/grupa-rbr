<script setup lang="ts">
import TaskList from '@features/tasks/components/task-list.vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@shared/layouts/authenticated-layout.vue';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="flex flex-col gap-4 py-12">
            <div class="mx-auto w-full max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <TaskList />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
