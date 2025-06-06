import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IStatusType, parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

interface updateRoomPriceBody {
	start_date: string;
	end_date: string;
	is_overwrite: boolean;
	room_ids: number[];
	day_of_week: { [key: string]: number };
	price_type: number[];
}

export const updateRoomPrice = async (
	body: updateRoomPriceBody
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');

		const { data } = await CallAPI().post(`${AppEndpoint.ROOM_PRICE}`, {
			hotel_id,
			...body,
		});
		if (!data) {
			return {
				status: false,
				message: 'Có lỗi xảy ra, vui lòng thử lại!',
			};
		}
		return parseErrorStatus(data);
	} catch (error) {
		console.error('updateRoomQuantity', error);
		return parseErrorStatus(
			(error as AxiosError)?.response?.data as IStatusType
		);
	}
};
