import { AuthRouters } from '@/constants/routers';
import { refreshToken } from '@/services/auth/refreshToken';
import { API_URL } from '@/services/type';
import {
	clearAllCookies,
	getClientSideCookie,
	setClientSideCookie
} from '@/utils/cookie';
import axios, {
	AxiosError,
	AxiosInstance,
	AxiosRequestConfig,
	AxiosResponse,
	InternalAxiosRequestConfig,
} from 'axios';

const TIMEOUT = 30000; // 30 seconds
export const TOKEN_EXPIRED_MESSAGE = 'token_expired';

//client only
interface CustomAxiosRequestConfig extends AxiosRequestConfig {
	_retry?: boolean;
}
let isRefreshing: boolean = false;
let failedQueue: Array<{
	resolve: (token: string) => void;
	reject: (error: unknown) => void;
}> = [];
const processQueue = (error: unknown, token: string | null = null): void => {
	failedQueue.forEach((prom) => {
		if (error) {
			prom.reject(error);
		} else if (token) {
			prom.resolve(token);
		}
	});
	failedQueue = [];
};

export const CallAPI = (
	customUrl: string = '',
	auth = true,
	contentType = 'application/json'
): AxiosInstance => {
	const axiosInstance = axios.create({
		baseURL: customUrl || API_URL,
		timeout: TIMEOUT,
		headers: {
			'Content-Type': contentType,
			Accept: '*/*',
		},
	});

	axiosInstance.interceptors.request.use(
		async (config: InternalAxiosRequestConfig) => {
			if (auth) {
				const isServer = typeof window === 'undefined';
				let token: string | undefined = '';

				try {
					if (isServer) {
						const { cookies } = await import('next/headers');
						const store = await cookies();
						token = store.get('access_token')?.value;
					} else {
						token = getClientSideCookie('access_token');
					}
					if (token && config.headers) {
						config.headers['Authorization'] = `Bearer ${token}`;
					}
				} catch (error) {
					console.error('Error getting auth token:', error);
				}
			}

			return config;
		},
		(error: AxiosError) => {
			console.error('Request error:', error);
			return Promise.reject(error);
		}
	);

	axiosInstance.interceptors.response.use(
		(response: AxiosResponse) => {
			return response;
		},
		async (error: AxiosError) => {
			const originalRequest: CustomAxiosRequestConfig | undefined =
				error.config;
			const status = error.response?.status;
			const msg = (error?.response?.data as { message: string })?.message;
			if (status === 401 || status === 403) {
				const isServer = typeof window === 'undefined';
				if (!isServer) {
					const refresh_token = getClientSideCookie('refresh_token');
					if (
						refresh_token &&
						msg === TOKEN_EXPIRED_MESSAGE &&
						originalRequest &&
						!originalRequest?._retry
					) {
						if (isRefreshing) {
							return new Promise((resolve, reject) => {
								failedQueue.push({ resolve, reject });
							})
								.then((token) => {
									originalRequest.headers = originalRequest.headers || {};
									originalRequest.headers.Authorization = `Bearer ${token}`;
									return axiosInstance(originalRequest);
								})
								.catch((err) => Promise.reject(err));
						}
						originalRequest._retry = true;
						isRefreshing = true;
						try {
							const response = await refreshToken(refresh_token);
							const {
								meta: {
									access_token: newAccessToken,
									refresh_token: newRefreshToken,
									expires_in,
								},
							} = response;
							setClientSideCookie({
								name: 'access_token',
								value: newAccessToken,
								options: { expires: expires_in },
							});
							setClientSideCookie({
								name: 'refresh_token',
								value: newRefreshToken ?? '',
								options: { expires: expires_in },
							});

							isRefreshing = false;
							processQueue(null, newAccessToken);

							originalRequest.headers = originalRequest.headers || {};
							originalRequest.headers.Authorization = `Bearer ${newAccessToken}`;
							return axiosInstance(originalRequest);
						} catch (refreshError) {
							isRefreshing = false;
							processQueue(refreshError, null);
							clearAllCookies();
							window.location.href = AuthRouters.signIn;
							return Promise.reject(refreshError);
						}
					} else {
						clearAllCookies();
						if (window.location.pathname !== AuthRouters.signIn) {
							window.location.href = AuthRouters.signIn;
						}
					}
				} else {
				}
			}
			return Promise.reject(error);
		}
	);

	return axiosInstance;
};
