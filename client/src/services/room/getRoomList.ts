import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export enum ERoomStatus {
	active = 'active',
	inactive = 'inactive',
}

export interface IRoomItem {
	id: number;
	area: number;
	name_id: number;
	name_custom: string;
	name: string;
	max_extra_adults: number;
	max_extra_children: number;
	max_capacity: number;
	quantity: number;
	price_max: number;
	price_min: number;
	price_standard: number;
	status: ERoomStatus;
	price_types: {
		id: number;
		name: string;
	}[];
}

export const getRoomList = async (): Promise<IRoomItem[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.ROOM}`, {
			params: {
				hotel_id,
			},
		});
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getRoomList', error);
		return null;
	}
};
