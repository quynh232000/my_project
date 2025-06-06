import { CallAPI } from '@/configs/axios/axios';
import {
	ICancelPolicy,
	ICancelRule,
} from '@/services/policy/cancel/getCancelPolicy';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IStatusType, parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

export const updateCancelPolicy = async (
	body: Partial<ICancelPolicy> & { policy_rules: ICancelRule[] }
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().post(
			`${AppEndpoint.CANCEL_POLICY}`,
			{ ...body, hotel_id }
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
