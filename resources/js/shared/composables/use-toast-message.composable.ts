import { useToast } from 'primevue/usetoast';

const TOAST_LIFE = 5000;

export const useToastMessage = () => {
    const toast = useToast();

    const success = (
        title: string,
        description: string,
        life: number = TOAST_LIFE,
    ) => {
        toast.add({
            severity: 'success',
            summary: title,
            detail: description,
            life,
        });
    };

    const info = (
        title: string,
        description: string,
        life: number = TOAST_LIFE,
    ) => {
        toast.add({
            severity: 'info',
            summary: title,
            detail: description,
            life,
        });
    };

    const warn = (
        title: string,
        description: string,
        life: number = TOAST_LIFE,
    ) => {
        toast.add({
            severity: 'warn',
            summary: title,
            detail: description,
            life,
        });
    };

    const error = (
        title: string,
        description: string,
        life: number = TOAST_LIFE,
    ) => {
        toast.add({
            severity: 'error',
            summary: title,
            detail: description,
            life,
        });
    };

    return {
        success,
        info,
        warn,
        error,
    };
};
