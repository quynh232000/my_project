import { create } from 'zustand/react';
import {
	CancelPolicyActions,
	CancelPolicyState,
} from '@/store/cancel-policy/type';
import { getCancelPolicy } from '@/services/policy/cancel/getCancelPolicy';

export const useCancelPolicyStore = create<
	CancelPolicyState & CancelPolicyActions
>((set, get) => ({
	global: null,
	local: null,
	forceFetch: true,
	fetchCancelPolicy: async (force = false) => {
		if ((!get().global && !get().local) || get().forceFetch || force) {
			const data = await getCancelPolicy();
			if (data) {
				set({
					global: data.global ?? undefined,
					local: data.local ?? [],
					forceFetch: false,
				});
			}
		}
	},
	setGlobalPolicy: (global) => set({ global }),
	addLocalPolicy: (item) => {
		const current = get().local ?? [];
		set({ local: [...current, item] });
	},
	updateLocalPolicy: (item) => {
		const current = get().local ?? [];
		const index = current.findIndex((policy) => item.id === policy.id);
		if (index >= 0) {
			current.splice(index, 1, item);
			set({ local: current });
		}
	},
	deleteLocalPolicy: (id) => {
		const current = get().local ?? [];
		const index = current.findIndex((policy) => id === policy.id);
		if (index >= 0) {
			current.splice(index, 1);
			set({ local: current });
		}
	},
	setForceFetch: (forceFetch) => set({ forceFetch }),
	reset: () => set({ global: null, local: null }),
}));
