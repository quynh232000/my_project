import { create } from 'zustand/react';
import { CustomerStore } from '@/store/customer/type';
import {
	getCustomerList,
	ICustomerItem,
} from '@/services/customer/getCustomerList';

export const useCustomerStore = create<CustomerStore>((set, get) => ({
	customerList: [] as ICustomerItem[],
	fetchCustomerList: async (force = false) => {
		if ((get().customerList && get().customerList.length === 0) || force) {
			const customerList = await getCustomerList();
			if (customerList && customerList.length > 0) {
				return set({ customerList });
			} else {
				set({ customerList: [] });
			}
		}
	},
	reset: () => set({ customerList: [] }),
}));
