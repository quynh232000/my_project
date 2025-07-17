import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export const deletePolicyChildren = async (
	id: number
): Promise<IResponseStatus | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const res = await CallAPI().delete(
			`${AppEndpoint.POLICY_CHILDREN}/${id}`,
			{
				params: {
					hotel_id,
				},
			}
		);
		if (!res) {
			return null;
		}
		return res.data;
	} catch (error) {
		console.error('deletePolicyChildren', error);
		return null;
	}
};
