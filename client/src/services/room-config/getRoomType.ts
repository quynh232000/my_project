import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export type IRoomNameItem = {
	id: string;
	name: string;
	room_type_id: number;
};

export type IRoomType = {
	id: string;
	name: string;
	slug: string;
	room_names: IRoomNameItem[];
};

export const getRoomType = async ({with_name = false}:{with_name?: boolean}): Promise<IRoomType[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.ROOM_TYPE}`, {
			params: {
				hotel_id,
				with_name
			},
		});
		if (!data) {
			return null;
		}
		return data?.data || [];
	} catch (error) {
		console.error('getRoomType', error);
		return null;
	}
};
