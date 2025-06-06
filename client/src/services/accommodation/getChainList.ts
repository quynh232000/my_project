import { CallAPI } from '@/configs/axios/axios';
import { IChainItem } from '@/services/attributes/getAttributes';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export const getChainList = async (): Promise<IChainItem[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(AppEndpoint.GET_CHAIN_LIST, {
			params: {
				hotel_id,
			},
		});
		if (!data || !data.data) return null;
		return data.data;
	} catch (error) {
		console.error('getChainList', error);
		return null;
	}
};
