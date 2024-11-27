import { DateTime } from 'luxon';

export const dateFormat = (
    date: Date | string,
    format: string = 'dd LLL yyyy',
): string => {
    if (typeof date === 'string') {
        date = DateTime.fromISO(date).toJSDate();
    }

    return DateTime.fromJSDate(date).toFormat(format);
};

export const datetimeFormat = (
    date: Date | string,
    format: string = 'dd LLL yyyy HH:mm',
): string => {
    if (typeof date === 'string') {
        date = DateTime.fromISO(date).toJSDate();
    }

    return DateTime.fromJSDate(date).toFormat(format);
};
