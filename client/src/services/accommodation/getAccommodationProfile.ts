import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { IAccommodationProfileAPI } from '@/store/accommodation-profile/type';

export const getAccommodationProfile = async (
	hotel_id: number
): Promise<IAccommodationProfileAPI | null> => {
	try {
		const { data } = await CallAPI().get(AppEndpoint.GET_HOTEL_DETAIL, {
			params: {
				hotel_id,
			},
		});
		if (!data || !data.data) return null;
		return data.data;
	} catch (error) {
		console.error('getHotelDetail', error);
		return null;
	}
};
