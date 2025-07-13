import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '../type';
import { AxiosError } from 'axios';
import { handleAPIError } from '@/utils/errors/apiError';

export interface IResetPassword {
	status: boolean;
	message: string;
}

export interface ResetPasswordBody {
	email: string;
	password: string;
	password_confirmation: string;
}

export const resetPassword = async ({
	email,
	password,
	password_confirmation,
}: ResetPasswordBody): Promise<IResetPassword> => {
	try {
		const response = await CallAPI().post(`${AppEndpoint.RESET_PASSWORD}`, {
			email,
			password,
			password_confirmation,
		});
		return response.data;
	} catch (err: unknown) {
		throw handleAPIError(err as AxiosError);
	}
};
