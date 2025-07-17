import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

type TPolicyOtherDetail<T> = {
	is_active: boolean;
	id: number;
	hotel_id: number;
	policy_setting_id: number;
	settings: T; // ← đây là generic
	policy: {
		id: number;
		name: string;
		slug: string;
	};
};

export const getPolicyOtherDetail = async <T>({
	slug,
}: {
	slug: string;
}): Promise<TPolicyOtherDetail<T> | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(
			`${AppEndpoint.POLICY_OTHER}/${slug}`,
			{
				params: {
					hotel_id,
				},
			}
		);
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getPolicyOtherDetail', error);
		return null;
	}
};
