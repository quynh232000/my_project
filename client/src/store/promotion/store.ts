import { create } from 'zustand/react';
import { PromotionStore } from '@/store/promotion/type';
import {
	getPromotionList,
	IPromotionResponse,
} from '@/services/promotion/getPromotionList';

export const usePromotionStore = create<PromotionStore>((set, get) => ({
	promotionList: undefined,
	pagination: {} as IPromotionResponse['meta'],
	fetchPromotionList: async ({ force = false, query }) => {
		if (!get().promotionList || force) {
			const promotionList = await getPromotionList({ query });
			if (promotionList) {
				return set({
					promotionList: promotionList.data.items,
					pagination: promotionList.meta,
				});
			} else {
				set({ promotionList: [], pagination: undefined });
			}
		}
	},
	reset: () => set({ promotionList: [] }),
	setPromotionList: (promotionList) => set({ promotionList }),
	setPagination: (pagination) => set({ pagination }),
}));
