import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { parseErrorStatus, IStatusType } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

export interface IPromotionRequestBody {
	id: number;
	name: string;
	price_type_ids: number[];
	room_ids: number[];
	type: string;
	start_date: string;
	end_date: string | null;
	value: number | { day_of_week: number; value: number }[];
	is_stackable: boolean;
	status: string;
}

export const createPromotion = async (
	payload: Partial<IPromotionRequestBody>
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const res = await CallAPI().post(`${AppEndpoint.PROMOTION}`, {
			...payload,
			hotel_id,
		});
		if (!res.data) {
			return {
				status: false,
				message: 'Có lỗi xảy ra, vui lòng thử lại!',
			};
		}
		return parseErrorStatus(res.data);
	} catch (error) {
		return parseErrorStatus(
			(error as AxiosError)?.response?.data as IStatusType
		);
	}
};
