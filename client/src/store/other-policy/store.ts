import { getPolicyOther } from '@/services/policy/other/getPolicyOther';
import {
	OtherPolicyActions,
	OtherPolicyState,
} from '@/store/other-policy/type';
import { create } from 'zustand/react';

const initialState: OtherPolicyState = {
	otherPolicy: [],
	data: {
		extraBed: false,
		deposit: undefined,
		age: {
			age: NaN,
			adult_require: [],
			duccument_require: [],
			accompanying_adult_proof: false,
		},
		breakfast: undefined,
	},
};

export const useOtherPolicyStore = create<
	OtherPolicyState & OtherPolicyActions
>((set, get) => ({
	...initialState,
	setOtherPolicy: (val) => set(() => ({ otherPolicy: val })),
	fetchOtherPolicy: async () => {
		if (get().otherPolicy && get().otherPolicy.length === 0) {
			const otherPolicy = await getPolicyOther();
			if (otherPolicy && otherPolicy.length > 0) {
				return set({ otherPolicy });
			} else {
				set({ otherPolicy: [] });
			}
		}
	},
	reset: () => set(initialState),
}));
