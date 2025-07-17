import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { ICustomerItem } from '@/services/customer/getCustomerList';

export const getCustomerDetail = async (
	id: string
): Promise<ICustomerItem | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.CUSTOMER}/${id}`, {
			params: {
				hotel_id,
				id,
			},
		});
		if (!data) {
			return null;
		}
		return data.data ?? null;
	} catch (error) {
		console.error('getCustomerDetail', error);
		return null;
	}
};
