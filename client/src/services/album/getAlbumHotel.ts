import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export interface RoomImageLabelParent {
	id: number;
	name: string;
	slug: string;
}

export interface RoomImageLabel {
	id: number;
	name: string;
	slug: string;
	parent_id: number;
	parents: RoomImageLabelParent;
}

export interface RoomInfo {
	id: number;
	name_id: number;
	name_custom: string | null;
	name: string;
}

export interface RoomImage {
	id: number;
	image: string;
	label_id: number;
	hotel_id: number;
	type: string;
	point_id: number;
	priority: number;
	image_url: string;
	label: RoomImageLabel | null;
	room?: RoomInfo; // Optional vì `hotel` images không có field `room`
}

export interface RoomItem {
	room: RoomInfo;
	images: RoomImage[];
}

export interface RoomsMap {
	[key: string]: RoomItem;
}

export interface HotelRoomsResponse {
	rooms: RoomsMap;
	hotel: RoomImage[];
}

export const getAlbumHotel = async (): Promise<HotelRoomsResponse> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		
		const { data } = await CallAPI().get(`${AppEndpoint.ALBUM}/list`, {
			params: {
				hotel_id
			},
		});
		return data.data;
	} catch (error) {
		console.error('getAlbumHotel', error);
		throw error;
	}
};
