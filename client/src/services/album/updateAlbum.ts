import { CallAPI } from '@/configs/axios/axios';
import { API_URL, AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IResponse } from '@/services/album/createAlbum';

export const updateAlbum = async <T>(
	formData: FormData
): Promise<IResponse<T> | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		formData.append('hotel_id', `${hotel_id}`);
		const res = await CallAPI(API_URL, true, "multipart/form-data").post(
			`${AppEndpoint.ALBUM}/edit`,
			formData,
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
