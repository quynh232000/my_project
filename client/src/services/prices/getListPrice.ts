import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { TPriceType } from '@/lib/schemas/type-price/standard-price';
import { getClientSideCookie } from '@/utils/cookie';

export const getListPrice = async (): Promise<TPriceType[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.PRICE_TYPE}`, {
			params: {
				limit: 9999,
				page: 1,
				hotel_id,
			},
		});
		if (!data) {
			return null;
		}
		const list: TPriceType[] = data?.data;
		return list ? list?.sort((a, b) => (b.id ?? 0) - (a.id ?? 0)) : [];
	} catch (error) {
		console.error('getListPrice', error);
		return null;
	}
};
