<script setup lang="ts">
import StatusBadge from '@shared/ui/status-badge.vue';
import { dateFormat } from '@shared/utils/date-format.util';
import { useGetTaskPriorities } from '../composables/use-get-task-priorities.composable';
import { useGetTaskStatuses } from '../composables/use-get-task-statuses.composable';
import { useGetTasks } from '../composables/use-get-tasks.composable';
import CreateTaskButton from './create-task-button.vue';
import DeleteTaskButton from './delete-task-button.vue';
import ReadTaskButton from './read-task-button.vue';
import UpdateTaskButton from './update-task-button.vue';

const { data: tasks } = useGetTasks();
const { data: priorityOptions, isLoading: arePrioritiesLoading } =
    useGetTaskPriorities();
const { data: statusOptions, isLoading: areStatusesLoading } =
    useGetTaskStatuses();
</script>

<template>
    <div>
        <DataTable v-if="tasks" :value="tasks" sortMode="multiple">
            <template #header>
                <div class="flex items-center justify-between">
                    <h2
                        class="text-xl font-semibold leading-tight text-gray-800"
                    >
                        Tasks
                    </h2>
                    <CreateTaskButton />
                </div>
            </template>

            <!-- TODO: extract this to a separate component -->
            <template #empty>
                <div class="p-4 text-center">
                    <span class="p-text-secondary">No tasks found.</span>
                </div>
            </template>
            <Column field="title" header="Title" sortable>
                <template #body="{ data }">
                    <span class="inline-flex max-w-[16ch] truncate">{{
                        data.title
                    }}</span>
                    {{ data.title.length > 16 ? '...' : '' }}
                </template>
            </Column>
            <Column field="priority" header="Priority" sortable>
                <template #body="{ data }">
                    <StatusBadge
                        :value="data.priority"
                        :options="priorityOptions ?? []"
                        :is-loading="arePrioritiesLoading"
                    />
                </template>
            </Column>
            <Column field="status" header="Status" sortable>
                <template #body="{ data }">
                    <StatusBadge
                        :value="data.status"
                        :options="statusOptions ?? []"
                        :is-loading="areStatusesLoading"
                    />
                </template>
            </Column>
            <Column field="deadline" header="Deadline" sortable>
                <template #body="{ data }">
                    <span>{{ dateFormat(data.deadline) }}</span>
                </template>
            </Column>
            <Column header="Actions">
                <template #body="{ data }">
                    <div class="inline-flex space-x-2">
                        <ReadTaskButton :task="data" />
                        <UpdateTaskButton :task="data" />
                        <DeleteTaskButton :task-id="data.id" />
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
