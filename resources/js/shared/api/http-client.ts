import { AxiosRequestConfig } from 'axios';
import axios from './axios-instance';

export const httpClient = {
    get: async <T>(path: string, config?: AxiosRequestConfig): Promise<T> => {
        const response = await axios.get<T>(path, config);
        return response.data;
    },
    post: async <T>(
        path: string,
        data?: unknown,
        config?: AxiosRequestConfig,
    ): Promise<T> => {
        const response = await axios.post<T>(path, data, config);
        return response.data;
    },
    put: async <T>(
        path: string,
        data?: unknown,
        config?: AxiosRequestConfig,
    ): Promise<T> => {
        const response = await axios.put<T>(path, data, config);
        return response.data;
    },
    patch: async <T>(
        path: string,
        data?: unknown,
        config?: AxiosRequestConfig,
    ): Promise<T> => {
        const response = await axios.patch<T>(path, data, config);
        return response.data;
    },
    delete: async <T>(
        path: string,
        config?: AxiosRequestConfig,
    ): Promise<T> => {
        const response = await axios.delete<T>(path, config);
        return response.data;
    },
};
