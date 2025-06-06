import { create } from 'zustand/react';
import {
	ChildrenPolicyActions,
	ChildrenPolicyState,
} from '@/store/child-policy/type';
import { getPolicyChildren } from '@/services/policy/children/getPolicyChildren';

export const useChildrenPolicyStore = create<
	ChildrenPolicyState & ChildrenPolicyActions
>((set, get) => ({
	data: null,
	fetchChildrenPolicy: async () => {
		if (!get().data) {
			const data = await getPolicyChildren();
			set({ data: data });
		}
	},
	setChildrenPolicy: (data) => set({ data }),
}));
