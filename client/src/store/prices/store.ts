import { create } from 'zustand/react';
import { PricesState, PricesStateActions } from '@/store/prices/type';
import { getListPrice } from '@/services/prices/getListPrice';

export const usePricesStore = create<PricesState & PricesStateActions>(
	(set, get) => ({
		data: null,
		fetchPrices: async () => {
			if (!get().data) {
				const data = await getListPrice();
				set({ data: data });
			}
		},
		addUpdatePrice: (item) => {
			const data = get().data;
			const itemIndex = data?.findIndex((i) => i.id === item.id) ?? -1;
			data?.splice(itemIndex, itemIndex >= 0 ? 1 : 0, item);
			set({
				data: data ? data?.sort((a, b) => (b.id ?? 0) - (a.id ?? 0)) : [item],
			});
		},
		deletePrice: (id) => {
			set({
				data: get().data?.filter((item) => item.id !== id) ?? [],
			});
		},
		reset: () => set({ data: null }),
	})
);
