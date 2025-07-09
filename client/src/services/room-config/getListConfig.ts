import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { format } from 'date-fns';
import { getClientSideCookie } from '@/utils/cookie';

export interface IRoomConfig {
	id: number;
	name: string;
	name_id: number;
	price_min: number;
	quantity: number;
	price_standard: number;
	price_max: number;
	allow_extra_guests: boolean;
	standard_guests: number;
	max_extra_adults: number;
	max_extra_children: number;
	max_capacity: number;
	type_id: number;
	availability: {
		date: string;
		quantity: number;
		status: 'close' | 'open';
		prices: {
			price_type_id: number;
			price_type_name: string;
			price: number;
		}[];
	}[];
	room_price_types: {
		id: number;
		room_id: number;
		price: number;
		price_type_name: string;
		price_type_id: number;
		price_type?: { id: number } | null;
	}[];
	price_settings: {
		price_type_id: number;
		room_id: number;
		capacity: number;
		price: number;
		status: 'active' | 'inactive';
	}[];
}

export const getListConfig = async (date: {
	from: Date;
	to: Date;
}): Promise<IRoomConfig[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.ROOM_LIST}`, {
			params: {
				hotel_id,
				limit: 9999,
				page: 1,
				start_date: format(date.from, 'yyyy-MM-dd'),
				end_date: format(date.to, 'yyyy-MM-dd'),
			},
		});
		if (!data) {
			return null;
		}
		return data?.data || [];
	} catch (error) {
		console.error('getListConfig', error);
		return null;
	}
};
