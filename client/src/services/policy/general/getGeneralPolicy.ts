import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export interface IGeneralPolicy {
	id: number;
	name: string;
	policy_general: {
		is_allow: boolean;
		policy_setting_id: number;
	} | null;
}

export const getGeneralPolicy = async (): Promise<IGeneralPolicy[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.GENERAL_POLICY}`, {
			params: {
				hotel_id,
			},
		});
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getGeneralPolicy', error);
		return null;
	}
};
