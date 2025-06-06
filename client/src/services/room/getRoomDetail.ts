import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';

export interface IRoomDetail {
	id: number;
	name_id: number;
	name_custom: string;
	name: string;
	status: string;
	type_id: number;
	direction_id: number;
	area: number;
	quantity: number;
	smoking: number;
	breakfast: number;
	price_min: number;
	price_standard: number;
	price_max: number;
	bed_type_id: number;
	bed_quantity: number;
	sub_bed_type_id: number | null;
	sub_bed_quantity: number | null;
	allow_extra_guests: number;
	standard_guests: number;
	max_extra_adults: number;
	max_extra_children: number;
	max_capacity: number | null;
	extra_beds: {
		age_from: number;
		age_to: number | null;
		type: string;
		price: number;
		id: number;
		room_id: number;
	}[];
}

export const getRoomDetail = async ({
	id,
	hotel_id,
}: {
	id: number;
	hotel_id: number;
}): Promise<IRoomDetail | null> => {
	try {
		const { data } = await CallAPI().get(`${AppEndpoint.ROOM}/${id}`, {
			params: {
				hotel_id,
			},
		});
		if (data?.data) {
			return Promise.resolve(data.data);
		}
		return Promise.reject(null);
	} catch (error) {
		return Promise.reject(error);
	}
};
