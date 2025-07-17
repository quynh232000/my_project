import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { TQueryParams } from '@/store/promotion/type';

export interface IPromotionItem {
	id: number;
	hotel_id: number;
	name: string;
	type: string;
	value: number | { day_of_week: number; value: number }[];
	start_date: string;
	end_date: string;
	is_stackable: number;
	status: string;
	price_types: {
		id: number;
		name: string;
	}[];
	rooms: {
		id: number;
		name_id: number;
		name: string;
	}[];
}

export interface IPromotionResponse {
	status: boolean;
	message: string;
	data: {
		roomCount: number;
		priceTypeCount: number;
		items: IPromotionItem[];
	};
	meta: {
		per_page: number;
		current_page: number;
		total_page: number;
		total_item: number;
	};
}

export const getPromotionList = async ({
	query,
}: {
	query?: TQueryParams;
}): Promise<IPromotionResponse | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.PROMOTION}`, {
			params: {
				hotel_id,
				...query,
			},
		});
		if (!data) {
			return null;
		}
		return data ?? [];
	} catch (error) {
		console.error('getPromotionList', error);
		return null;
	}
};
