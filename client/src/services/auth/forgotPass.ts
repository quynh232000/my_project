import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '../type';
import { AxiosError } from 'axios';
import { handleAPIError } from '@/utils/errors/apiError';

export interface IForgotPass {
	status: boolean;
	message: string;
}

export interface ForgotPassBody {
	email: string;
}

export const forgotPass = async ({
	email,
}: ForgotPassBody): Promise<IForgotPass> => {
	try {
		const response = await CallAPI().post(
			`${AppEndpoint.FORGOT_PASSWORD}`,
			{
				email,
			}
		);
		return response.data;
	} catch (err: unknown) {
		throw handleAPIError(err as AxiosError);
	}
};
