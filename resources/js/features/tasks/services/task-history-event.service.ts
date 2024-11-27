import { httpClient } from '@shared/api/http-client';
import {
    taskHistoryEventsSchema,
    type TaskHistoryEvent,
} from '../schemas/task-history-event.schema';

class TaskHistoryEventService {
    public async getTaskHistoryEvents(): Promise<TaskHistoryEvent[]> {
        const response = await httpClient.get(
            route('task-history-events.index'),
        );
        const taskHistoryEvents = await taskHistoryEventsSchema.validate(
            response,
            {
                strict: true,
            },
        );

        return taskHistoryEvents ?? [];
    }
}

const taskHistoryEventService = new TaskHistoryEventService();

export default taskHistoryEventService;
