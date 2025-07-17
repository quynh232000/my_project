import { CallAPI } from '@/configs/axios/axios';
import { IPromotionItem } from '@/services/promotion/getPromotionList';
import { AppEndpoint } from '@/services/type';

export const getPromotionDetail = async ({
	id,
	hotel_id,
}: {
	id: number;
	hotel_id: number;
}): Promise<IPromotionItem | null> => {
	try {
		const { data } = await CallAPI().get(`${AppEndpoint.PROMOTION}/${id}`, {
			params: {
				hotel_id,
			},
		});
		if (!data || !data?.data) {
			return Promise.reject(null);
		}
		return Promise.resolve(data.data ?? null);
	} catch (error) {
		console.error('getPromotionDetail', error);
		return Promise.reject(error);
	}
};
