import { create } from 'zustand/react';
import { PromotionStore } from '@/store/promotion/type';
import {
	getPromotionList,
	IPromotionItem,
} from '@/services/promotion/getPromotionList';

export const usePromotionStore = create<PromotionStore>((set, get) => ({
	promotionList: [] as IPromotionItem[],
	fetchPromotionList: async (force = false) => {
		if ((get().promotionList && get().promotionList.length === 0) || force) {
			const promotionList = await getPromotionList();
			if (promotionList && promotionList.items.length > 0) {
				return set({ promotionList: promotionList.items });
			} else {
				set({ promotionList: [] });
			}
		}
	},
	reset: () => set({ promotionList: [] }),
	setPromotionList: (promotionList) => set({ promotionList }),
}));
