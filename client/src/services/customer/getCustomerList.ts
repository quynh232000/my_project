import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
export enum ECustomerStatus {
	active = 'active',
	inactive = 'inactive',
}
export interface ICustomerItem {
	id: number;
	email: string;
	full_name: string;
	status: ECustomerStatus;
	created_by: {
		id: number;
		full_name: string;
	};
	added_by: {
		id: number;
		full_name: string;
	};
	hotel_customers: [
		{
			id: number;
			hotel_id: number;
			customer_id: number;
			role: string;
		},
	];
}

export const getCustomerList = async (): Promise<ICustomerItem[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.CUSTOMER}`, {
			params: {
				hotel_id,
			},
		});
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getCustomerList', error);
		return null;
	}
};
