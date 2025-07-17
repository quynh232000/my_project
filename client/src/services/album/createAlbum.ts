import { CallAPI } from '@/configs/axios/axios';
import { API_URL, AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
export interface IImage {
	image: File;
	label_id: string;
	priority: string;
}
export interface CreateAlbumRequestBody {
	slug: string;
	room_id?: string;
	images: IImage[];
	list_all?: boolean;
}

export interface IResponse<T> {
	status: boolean;
	message: string;
	finishAt: Date;
	data: T;
}

export const createAlbum = async <T>(
	body: CreateAlbumRequestBody
): Promise<IResponse<T> | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const formData = new FormData();
		formData.append('hotel_id', `${hotel_id}`);
		formData.append('slug', body.slug);
		formData.append('type', body.room_id ? 'room_type' : 'hotel');
		body.room_id && formData.append('room_id', String(body.room_id));
		body.list_all && formData.append('list-all', String(body.list_all));
		body.images?.forEach((img: IImage, idx) => {
			formData.append(`images[${idx}][image]`, img.image);
			formData.append(`images[${idx}][label_id]`, img.label_id);
			formData.append(`images[${idx}][priority]`, img.priority);
		});

		const res = await CallAPI(API_URL, true, 'multipart/form-data').post(
			`${AppEndpoint.ALBUM}`,
			formData
		);
		if (!res.data) {
			return null;
		}
		return {
			...res.data,
			finishAt: Date.now(),
		};
	} catch (error) {
		console.error('createAlbum', error);
		return null;
	}
};
