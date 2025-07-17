import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IResponseStatus } from '@/services/type';
import { parseErrorStatus, IStatusType } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

export const updatePolicyOther = async <T>(
	body: T
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const res = await CallAPI().post(`${AppEndpoint.POLICY_OTHER}`, {
			...body,
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
