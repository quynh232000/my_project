import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '../type';
import { AxiosError } from 'axios';
import { handleAPIError } from '@/utils/errors/apiError';

export interface IVerifyPass {
	status: boolean;
	message: string;
}

export interface VerifyPasswordBody {
	email: string;
	code: string;
}

export const verifyPassword = async ({
	email,
	code,
}: VerifyPasswordBody): Promise<IVerifyPass> => {
	try {
		const response = await CallAPI().post(
			`${AppEndpoint.VERIFY_RESET_CODE}`,
			{
				email,
				code,
			}
		);
		return response.data;
	} catch (err: unknown) {
		throw handleAPIError(err as AxiosError);
	}
};
