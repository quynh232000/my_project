import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { ROBB } from '@/lib/schemas/policy/validationChildPolicy';
import { getClientSideCookie } from '@/utils/cookie';

export interface IPolicyChildren {
	id?: number;
	hotel_id?: number;
	age_from: number;
	age_to: number;
	fee_type: 'free' | 'charged' | 'limit';
	quantity_child?: number;
	fee?: number;
	meal_type: ROBB;
}

export const getPolicyChildren = async (): Promise<
	IPolicyChildren[] | null
> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.POLICY_CHILDREN}`, {
			params: {
				hotel_id,
			},
		});
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getPolicyChildren', error);
		return null;
	}
};
