import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IStatusType, parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

export const deleteCancelPolicy = async (
	id: number
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().delete(
			`${AppEndpoint.CANCEL_POLICY}/${id}`,
			{
				params: {
					hotel_id,
				},
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
		return parseErrorStatus(
			(error as AxiosError)?.response?.data as IStatusType
		);
	}
};
