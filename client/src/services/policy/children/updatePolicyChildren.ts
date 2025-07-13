import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { IPolicyChildren } from '@/services/policy/children/getPolicyChildren';
import { getClientSideCookie } from '@/utils/cookie';
import { parseErrorStatus, IStatusType } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

interface props {
	policies: (Omit<
		IPolicyChildren,
		'hotel_id' | 'id' | 'quantity_child' | 'fee'
	> & { id?: number; quantity_child?: number; fee?: number })[];
}

export const updatePolicyChildren = async ({
	policies,
}: props): Promise<IResponseStatus> => {
	const hotel_id = getClientSideCookie('hotel_id');
	try {
		const res = await CallAPI().post(`${AppEndpoint.POLICY_CHILDREN}`, {
			policies,
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
