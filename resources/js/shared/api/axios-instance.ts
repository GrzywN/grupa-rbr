import { HttpStatusCode } from 'axios';

const axiosInstance = window.axios;

axiosInstance.interceptors.request.use(
    (config) => {
        const token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            config.headers['X-CSRF-TOKEN'] = token.getAttribute('content');
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    },
);

axiosInstance.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 419) {
            window.location.reload();
            return;
        }

        if (error.response?.status === HttpStatusCode.Unauthorized) {
            window.location.href = '/login';
            return;
        }

        return Promise.reject(error);
    },
);

export default axiosInstance;
