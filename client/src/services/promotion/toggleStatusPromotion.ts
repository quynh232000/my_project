import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IStatusType } from '@/utils/errors/parseErrorStatus';
import { parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

export const toggleStatusPromotion = async (
	id: string
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const res = await CallAPI().put(
			`${AppEndpoint.PROMOTION}/toggle-status/${id}`,
			{
				hotel_id
			}
		);

		if (!res.data) {
			return {
				status: false,
				message: 'Có lỗi xảy ra, vui lòng thử lại!'
			};
		}
		return parseErrorStatus(res.data);
	} catch (error) {
		return parseErrorStatus(
			(error as AxiosError)?.response?.data as IStatusType
		);
	}
};
