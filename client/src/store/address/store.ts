import { create } from 'zustand/react';
import { AddressActions, AddressState } from '@/store/address/type';
import { getAddress } from '@/services/address/getAddress';

export const useAddressStore = create<AddressState & AddressActions>(
	(set, get) => ({
		listCountry: [],
		listProvince: {
			upperId: NaN,
			list: [],
		},
		listDistrict: {
			upperId: NaN,
			list: [],
		},
		listWard: {
			upperId: NaN,
			list: [],
		},
		getAddress: async (type, upperId) => {
			if (type === 'listCountry') {
				if (get().listCountry.length <= 0) {
					const data = await getAddress({ type: 'country_id' });
					set({ listCountry: data ?? [] });
				}
			}
			if (type === 'listProvince') {
				if (
					get().listProvince.list.length <= 0 ||
					get().listProvince.upperId !== upperId
				) {
					const data = await getAddress({
						type: 'country_id',
						id: upperId,
					});
					set({
						listProvince: {
							upperId: upperId ?? NaN,
							list: data ?? [],
						},
					});
				}
			}
			if (type === 'listDistrict') {
				if (
					get().listDistrict.list.length <= 0 ||
					get().listDistrict.upperId !== upperId
				) {
					const data = await getAddress({
						type: 'city_id',
						id: upperId,
					});
					set({
						listDistrict: {
							upperId: upperId ?? NaN,
							list: data ?? [],
						},
					});
				}
			}
			if (type === 'listWard') {
				if (
					get().listWard.list.length <= 0 ||
					get().listWard.upperId !== upperId
				) {
					const data = await getAddress({
						type: 'district_id',
						id: upperId,
					});
					set({
						listWard: { upperId: upperId ?? NaN, list: data ?? [] },
					});
				}
			}
		},
	})
);
