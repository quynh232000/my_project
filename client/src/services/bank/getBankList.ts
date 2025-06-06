import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export interface IBank {
	id: number;
	name: string;
	code: string;
	short_name: string;
}

export const getBankList = async (): Promise<IBank[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.GET_BANKS}`, {
			params: {
				hotel_id,
			},
		});
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getBankList', error);
		return null;
	}
};
