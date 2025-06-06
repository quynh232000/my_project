import { create } from 'zustand/react';
import {
	GeneralPolicyActions,
	GeneralPolicyState,
} from '@/store/general-policy/type';
import { getGeneralPolicy } from '@/services/policy/general/getGeneralPolicy';

export const useGeneralPolicyStore = create<
	GeneralPolicyState & GeneralPolicyActions
>((set, get) => ({
	data: null,
	fetchGeneralPolicy: async () => {
		if (!get().data) {
			const data = await getGeneralPolicy();
			set({ data: data });
		}
	},
	setGeneralPolicy: (data) => set({ data }),
}));
