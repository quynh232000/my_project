import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '../type';
import { getClientSideCookie } from '@/utils/cookie';

export interface IBankBranch {
	id: number;
	bank_id: number;
	name: string;
}

export const getBankBranch = async (): Promise<IBankBranch[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');

		const { data } = await CallAPI().get(`${AppEndpoint.GET_BANK_BRANCH}`, {
			params: {
				hotel_id,
			},
		});
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (err) {
		console.error('getBankBranch', err);
		return null;
	}
};
