import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

interface props {
	type?: string;
	point_id: number;
}

export interface IAlbumItem {
	id: number;
	hotel_id: number;
	point_id: number;
	label_id: number;
	image_url: string;
	priority: number | null;
}

export const getAlbumList = async ({
	type = 'room_type',
	point_id,
}: props): Promise<IAlbumItem[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		
		const { data } = await CallAPI().get(`${AppEndpoint.ALBUM}`, {
			params: {
				type,
				point_id,
				hotel_id
			},
		});
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getAlbumList', error);
		return null;
	}
};
