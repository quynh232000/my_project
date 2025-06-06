import { CallAPI } from '@/configs/axios/axios';
import { UserInformation } from '@/store/user-information/type';
import { AppEndpoint } from '../type';
import { handleAPIError } from '@/utils/errors/apiError';
import { AxiosError } from 'axios';

export const getUser = async (): Promise<UserInformation | null> => {
	try {
		const { data } = await CallAPI().get(`${AppEndpoint.GET_ME}`);
		if (!data) {
			return null;
		}
		return {
			id: 0,
			register_id: 0,
			ip: '',
			status: '',
			created_at: '',
			created_by: 0,
			updated_at: '',
			updated_by: 0,
			...data.data,
		};
	} catch (err) {
		throw handleAPIError(err as AxiosError);

	}
};
