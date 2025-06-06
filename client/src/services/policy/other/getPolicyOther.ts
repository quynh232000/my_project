import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export interface IPolicyOtherItem {
	id: number;
	name: string;
	slug: string;
	is_active: boolean;
}

export const getPolicyOther = async (): Promise<IPolicyOtherItem[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(
			`${AppEndpoint.POLICY_OTHER}`,
			{
				params: {
					hotel_id,
				},
			}
		);
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getPolicyOther', error);
		return null;
	}
};
