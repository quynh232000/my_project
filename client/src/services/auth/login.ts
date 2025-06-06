import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { handleAPIError } from '@/utils/errors/apiError';
import { AxiosError } from 'axios';

export interface ILogin {
	status: boolean;
	message: string;
	meta: { access_token: string; token_type: string; expires_in: number, refresh_token?: string };
	data: {
		id: number;
		register_id: number;
		username: string;
		full_name: string;
		email: string;
		phone: string;
		image: string;
		ip: string;
		status: string;
		created_at: string;
		created_by: number;
		updated_at: string;
		updated_by: number;
	};
}

export interface LoginBodyType {
	email: string;
	password: string;
	remember?: boolean;
}

export const login = async ({
	email,
	password,
	remember = false,
}: LoginBodyType): Promise<ILogin> => {
	try {
		const res = await CallAPI().post(`${AppEndpoint.AUTH_LOGIN}`, {
			email,
			password,
			remember,
		});
		return res.data;
	} catch (err: unknown) {
		throw handleAPIError(err as AxiosError);
	}
};
