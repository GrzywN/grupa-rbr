import { useToastMessage } from '@shared/composables/use-toast-message.composable';
import { copyToClipboard } from '@shared/utils/clipboard.util';
import { useMutation } from '@tanstack/vue-query';
import taskSharingService from '../services/task-sharing.service';

export const useShareTask = () => {
    const { success, error } = useToastMessage();

    return useMutation({
        mutationFn: async (taskId: number) => {
            const sharedUrl =
                await taskSharingService.createExternalUrl(taskId);
            const copied = await copyToClipboard(sharedUrl);

            return { sharedUrl, copied };
        },
        onError: (err) => {
            const errorMessage =
                err instanceof Error ? err.message : 'Unknown error occurred';

            error(
                'Failed to share task',
                `Unable to share task: ${errorMessage}. Please verify your permissions and try again.`,
            );
        },
        onSuccess: ({ sharedUrl, copied }) => {
            const successMessage = copied
                ? 'Task shared successfully. Link copied to clipboard.'
                : 'Task shared successfully. Please copy the link manually: ' +
                  sharedUrl;

            success('Task Shared', successMessage);
        },
    });
};
