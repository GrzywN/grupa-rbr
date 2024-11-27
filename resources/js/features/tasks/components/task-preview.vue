<script setup lang="ts">
import TaskChangeComparison from '@features/tasks/components/task-change-comparison.vue';
import TaskChangeField from '@features/tasks/components/task-change-field.vue';
import TaskStatusComparison from '@features/tasks/components/task-status-comparison.vue';
import { dateFormat } from '@shared/utils/date-format.util';
import { useGetTaskPriorities } from '../composables/use-get-task-priorities.composable';
import { useGetTaskStatuses } from '../composables/use-get-task-statuses.composable';
import { type TaskHistoryDiff } from '../schemas/task-history-diff.schema';
import { type Task } from '../schemas/task.schema';

export type TaskPreviewProps = {
    task: Task;
    previousTask?: Task | undefined | null;
    diff?: TaskHistoryDiff | undefined | null;
};

const props = defineProps<TaskPreviewProps>();

const { data: priorityOptions, isLoading: arePrioritiesLoading } =
    useGetTaskPriorities();
const { data: statusOptions, isLoading: areStatusesLoading } =
    useGetTaskStatuses();

const hasChanged = (field: keyof TaskHistoryDiff) =>
    props?.diff?.[field] != null;

const getFields = (
    field: keyof TaskHistoryDiff,
    formatter = (e: string) => e,
) => {
    if (hasChanged(field) && props.previousTask != null) {
        return [
            formatter(props.previousTask[field]),
            formatter(props.task[field]),
        ];
    }
    return [formatter(props.task[field])];
};

const titleFields = getFields('title');
const descriptionFields = getFields('description');
const priorityFields = getFields('priority');
const statusFields = getFields('status');
const deadlineFields = getFields('deadline', dateFormat);
</script>

<template>
    <TaskChangeField title="Title" :is-changed="hasChanged('title')">
        <TaskChangeComparison :values="titleFields" />
    </TaskChangeField>

    <TaskChangeField
        title="Description"
        :is-changed="hasChanged('description')"
    >
        <TaskChangeComparison :values="descriptionFields" />
    </TaskChangeField>

    <TaskChangeField title="Priority" :is-changed="hasChanged('priority')">
        <TaskStatusComparison
            :values="priorityFields"
            :options="priorityOptions ?? []"
            :is-loading="arePrioritiesLoading"
        />
    </TaskChangeField>

    <TaskChangeField title="Status" :is-changed="hasChanged('status')">
        <TaskStatusComparison
            :values="statusFields"
            :options="statusOptions ?? []"
            :is-loading="areStatusesLoading"
        />
    </TaskChangeField>

    <TaskChangeField title="Deadline" :is-changed="hasChanged('deadline')">
        <TaskChangeComparison :values="deadlineFields" />
    </TaskChangeField>
</template>
