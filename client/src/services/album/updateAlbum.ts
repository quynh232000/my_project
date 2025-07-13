import { CallAPI } from '@/configs/axios/axios';
import { API_URL, AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IResponse } from '@/services/album/createAlbum';

export interface IAlbumUpdate {
	priority?: string;
	label_id?: string;
	image_id: string;
}
export interface UpdateAlbumRequestBody {
	id?: string;
	list_all?: boolean;
	images?: IAlbumUpdate[];
	idsDeleteArr?: number[];
}

export const updateAlbum = async <T>(
	body: UpdateAlbumRequestBody
): Promise<IResponse<T> | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const formData = new FormData();
		formData.append('hotel_id', `${hotel_id}`);
		formData.append('id', `${body.id}`);
		formData.append('type', body.id ? 'room_type' : 'hotel');
		body.list_all && formData.append('list-all', `${body.list_all}`);
		body.idsDeleteArr &&
			body.idsDeleteArr.forEach((id) =>
				formData.append(`delete_images[]`, String(id))
			);
		body.images &&
			body.images?.forEach((img) => {
				img.label_id &&
					formData.append(
						`update[${img.image_id}][label_id]`,
						img.label_id
					);
				img.priority &&
					formData.append(
						`update[${img.image_id}][priority]`,
						img.priority
					);
			});

		const res = await CallAPI(API_URL, true, 'multipart/form-data').post(
			`${AppEndpoint.ALBUM}/edit`,
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
		console.error('updateAlbum', error);
		return null;
	}
};
