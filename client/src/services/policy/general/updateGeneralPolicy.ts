import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { IGeneralPolicy } from '@/services/policy/general/getGeneralPolicy';
import { getClientSideCookie } from '@/utils/cookie';

export const updateGeneralPolicy = async (
	body: IGeneralPolicy[]
): Promise<boolean> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().post(`${AppEndpoint.GENERAL_POLICY}`, {
			policies: body.map((policy) => policy.policy_general),
			hotel_id,
		});
		if (!data) {
			return false;
		}
		return data.status ?? false;
	} catch (error) {
		console.error('getGeneralPolicy', error);
		return false;
	}
};
