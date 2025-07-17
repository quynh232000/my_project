import { CallAPI } from '@/configs/axios/axios';
import { ServiceType } from '@/services/service/getServices';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

interface props {
	ids: number[];
	type: ServiceType;
	point_id?: string;
}

export const updateHotelServices = async ({
	type,
	ids,
	point_id,
}: props): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const res = await CallAPI().post(`${AppEndpoint.HOTEL_SERVICES}`, {
			type,
			ids,
			point_id,
			hotel_id,
		});
		if (!res.data) {
			return {
				status: false,
				message: 'Có lỗi xảy ra, vui lòng thử lại!',
			};
		}
		return res.data ?? [];
	} catch (error) {
		console.error('updateHotelServices', error);
		return {
			status: false,
			message: 'Có lỗi xảy ra, vui lòng thử lại!',
		};
	}
};
