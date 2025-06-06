import { CallAPI } from '@/configs/axios/axios';
import { handleAPIError } from '@/utils/errors/apiError';
import { AxiosError } from 'axios';
import { AppEndpoint } from '../type';
import { ILogin } from './login';

export const refreshToken = async (refresh_token: string): Promise<ILogin> => {
	try {
		const response = await CallAPI().post(
			`${AppEndpoint.REFRESH_TOKEN}`,
			{
				refresh_token
			}
		);
		return response.data;
	} catch (err: unknown) {
		throw handleAPIError(err as AxiosError);
	}
};
