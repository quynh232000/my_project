import { CallAPI } from '@/configs/axios/axios';
import { DialogPricingSettingType } from '@/lib/schemas/type-price/dialog-pricing-setting';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IStatusType, parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

export const updateRoomOccupancyPrice = async (
	body: DialogPricingSettingType
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');

		const { data } = await CallAPI().post(`${AppEndpoint.PRICE_SETTING}`, {
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
