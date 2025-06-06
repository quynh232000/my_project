import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { UserInformationType } from '@/lib/schemas/user/user';
import { parseErrorStatus } from '@/utils/errors/parseErrorStatus';

export const updateCustomerDetail = async (
	payload: UserInformationType & { id?: number }
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const res = await CallAPI().post(`${AppEndpoint.CUSTOMER}`, {
			...payload,
			hotel_id
		});
		return parseErrorStatus(res.data);
	} catch (error) {
		console.error('updateCustomerDetail', error);
		return {
			status: false,
			message: 'Có lỗi xảy ra, vui lòng thử lại!'
		};
	}
};
