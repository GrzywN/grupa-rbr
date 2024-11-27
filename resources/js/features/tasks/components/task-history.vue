<script setup lang="ts">
import StatusBadge from '@shared/ui/status-badge.vue';
import { datetimeFormat } from '@shared/utils/date-format.util';
import { AccordionContent } from 'primevue';
import { useGetTaskHistoryEvents } from '../composables/use-get-task-history-events.composable';
import { useGetTaskHistory } from '../composables/use-get-task-history.composable';
import { Task } from '../schemas/task.schema';
import TaskPreview from './task-preview.vue';

export type TaskHistoryProps = {
    task: Task;
};

const props = defineProps<TaskHistoryProps>();

const { data: taskHistory } = useGetTaskHistory(props.task.id);
const {
    data: taskHistoryEventOptions,
    isLoading: areTaskHistoryEventsLoading,
} = useGetTaskHistoryEvents();
</script>

<template>
    <div class="card mt-4">
        <Accordion value="0">
            <AccordionPanel
                v-for="(history, index) in taskHistory"
                :key="history.id.toString()"
                :value="history.id.toString()"
            >
                <AccordionHeader>
                    <StatusBadge
                        :value="history.event"
                        :options="taskHistoryEventOptions ?? []"
                        :is-loading="areTaskHistoryEventsLoading"
                    />
                    <span class="ml-2">
                        {{ datetimeFormat(history.created_at) }}
                    </span>
                </AccordionHeader>
                <AccordionContent>
                    <TaskPreview
                        v-if="taskHistory"
                        :task="history"
                        :previous-task="
                            taskHistory.length > index + 1
                                ? taskHistory[index + 1]
                                : null
                        "
                        :diff="history.diff"
                    />
                </AccordionContent>
            </AccordionPanel>
        </Accordion>
    </div>
</template>
