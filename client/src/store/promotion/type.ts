import {
	IPromotionItem,
	IPromotionResponse,
} from '@/services/promotion/getPromotionList';
export type TQueryParams = {
	limit?: number;
	page?: number;
	status?: string;
	search?: string;
}

export interface PromotionStore {
	promotionList: IPromotionItem[] | undefined;
	pagination: IPromotionResponse['meta'];
	fetchPromotionList: ({
		force,
		query,
	}: {
		force?: boolean;
		query?: TQueryParams;
	}) => Promise<void>;
	reset: () => void;
	setPromotionList: (list: IPromotionItem[]) => void;
	setPagination: (pagination: IPromotionResponse['meta'] | undefined) => void;
}
