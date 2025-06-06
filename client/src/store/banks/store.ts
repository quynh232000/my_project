import { getBankList, IBank } from '@/services/bank/getBankList';
import { BankListStore } from '@/store/banks/type';
import { create } from 'zustand/react';

export const useBankListStore = create<BankListStore>((set, get) => ({
	bankList: [] as IBank[],
	fetchBankList: async () => {
		if (get().bankList && get().bankList.length === 0) {
			const bankList = await getBankList();
			if (bankList && bankList.length > 0) {
				return set({ bankList });
			} else {
				set({ bankList: [] });
			}
		}
	},
}));
