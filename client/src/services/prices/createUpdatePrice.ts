import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { TPriceType } from '@/lib/schemas/type-price/standard-price';
import { AxiosError } from 'axios';
import { IStatusType, parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { getClientSideCookie } from '@/utils/cookie';

export const createUpdatePrice = async (
	body: TPriceType
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().post(
			`${AppEndpoint.PRICE_TYPE}`,
			{
				...(body.id ? { id: body.id } : {}),
				hotel_id: hotel_id,
				name: body.name,
				rate_type: body.rate_type,
				room_ids: body.room_ids,
				policy_cancel_id: !!body.cancellationPolicy.policy_cancel_id
					? body.cancellationPolicy.policy_cancel_id
					: null,
				policy_children: body?.policy?.rows ?? [],
				date_min: body.date_min,
				date_max: body.date_max,
				night_min: body.night_min,
				night_max: body.night_max,
			}
		);
		if (!data) {
			return {
				status: false,
				message: 'Có lỗi xảy ra, vui lòng thử lại!',
			};
		}
		return parseErrorStatus(data);
	} catch (error) {
		console.error('createUpdatePrice', error);
		return parseErrorStatus(
			(error as AxiosError)?.response?.data as IStatusType
		);
	}
};
