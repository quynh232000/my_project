import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export type TPriceHistoryAPI = {
	id: number;
	room_id: number;
	start_date: string;
	end_date: string;
	day_of_week: number;
	price: number;
	price_type_id: number;
	is_active: number;
	type: string;
	created_at: string;
	created_by: {
		id: number;
		full_name: string;
	};
	price_type: {
		id: number;
		name: string;
	} | null;
	room: {
		id: number;
		name_custom: string | null;
		name_id: number;
		name: string;
	};
};

export const getRoomPriceHistory = async (): Promise<TPriceHistoryAPI[]> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(
			`${AppEndpoint.ROOM_PRICE}/history`,
			{
				params: {
					hotel_id,
				},
			}
		);

		return data?.data;
	} catch (error) {
		console.error('getRoomPriceHistory', error);
		throw error;
	}
};
