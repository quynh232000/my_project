import { getListConfig } from '@/services/room-config/getListConfig';
import {
	AvailabilityActions,
	AvailabilityState,
} from '@/store/availability-center/type';
import { create } from 'zustand/react';

const initialState: AvailabilityState = {
	isParsedParams: false,
	params: {
		room: 'all',
		filterDate: undefined,
		filterPrice: true,
	},
	list: [],
};

export const useAvailabilityCenterStore = create<
	AvailabilityState & AvailabilityActions
>((set, get) => ({
	...initialState,
	setParams: (params) => {
		const prev = get().params;
		set({ params: { ...prev, ...params } });
	},
	fetchListConfig: async () => {
		const params = get().params;
		if (!!params.filterDate?.from && !!params.filterDate?.to) {
			const res = await getListConfig({
				from: params.filterDate.from,
				to: params.filterDate.to,
			});

			if (res) {
				set({
					list: res?.map((rate) => {
						const standardRate = rate.room_price_types?.find(
							(type) => type.price_type_id === 0
						);
						return {
							...rate,
							room_price_types: standardRate
								? rate.room_price_types?.sort(
										(a, b) =>
											a.price_type_id - b.price_type_id
									)
								: [
										{
											id: 0,
											room_id: rate.id,
											price: NaN,
											price_type_name: 'Giá tiêu chuẩn',
											price_type_id: 0,
											price_type: { id: 0 },
										},
										...rate.room_price_types,
									],
						};
					}),
				});
			}
		}
	},
	setIsParsedParams: (isParsedParams) => set({ isParsedParams }),
	reset: () => set(initialState),
}));
