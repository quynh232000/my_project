import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { handleAPIError } from '@/utils/errors/apiError';
import { AxiosError } from 'axios';

export const logout = async () => {
	try {
		const res = await CallAPI().post(`${AppEndpoint.AUTH_LOGOUT}`);
		return res.data;
	} catch (err: unknown) {
		throw handleAPIError(err as AxiosError);
	}
};
