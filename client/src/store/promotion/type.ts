import { IPromotionItem } from '@/services/promotion/getPromotionList';

export interface PromotionStore {
	promotionList: IPromotionItem[];
	fetchPromotionList: (force?: boolean) => Promise<void>;
	reset: () => void;
	setPromotionList: (list: IPromotionItem[] | undefined) => void;
}
