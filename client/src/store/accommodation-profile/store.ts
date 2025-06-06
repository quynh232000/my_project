import { AccommodationInfo } from '@/lib/schemas/property-profile/general-information';
import { getAccommodationProfile } from '@/services/accommodation/getAccommodationProfile';
import { getHotelServices } from '@/services/accommodation/getHotelServices';
import { getPaymentInformation } from '@/services/paymentInfo/getPaymentInformation';
import {
	AccommodationProfileActions,
	AccommodationProfileState,
} from '@/store/accommodation-profile/type';
import { create } from 'zustand/react';

export const useAccommodationProfileStore = create<
	AccommodationProfileState & AccommodationProfileActions
>((set, get) => ({
	profile: undefined,
	services: undefined,
	paymentInfo: undefined,
	idHotel: undefined,
	fetchProfile: async (hotel_id) => {
		if (!get().profile) {
			const data = await getAccommodationProfile(hotel_id);
			if (data) {
				const profile: AccommodationInfo = {
					id: data.id,
					generalInfo: {
						name: data.name ?? '',
						avg_price: data.avg_price ?? NaN,
						accommodation_id: data.accommodation_id ?? NaN,
						stars: data.stars ? +data.stars : 0,
						chain_id: data.chain_id ?? null,
						room_number: data.room_number ?? NaN,
						time_checkin: data.time_checkin
							? data.time_checkin.slice(0, 5)
							: '12:00',
						time_checkout: data.time_checkout
							? data.time_checkout.slice(0, 5)
							: '12:00',
						image: data.image ?? '',
					},
					address: {
						country_id: data.country_id || NaN,
						city_id: data.city_id || NaN,
						district_id: data.district_id || NaN,
						ward_id: data.ward_id || NaN,
						address: data.address ?? '',
						latitude: data.latitude ?? 0,
						longitude: data.longitude ?? 0,
					},
					introduction: {
						construction_year: data.construction_year ?? NaN,
						bar_count: data.bar_count ?? NaN,
						restaurant_count: data.restaurant_count ?? NaN,
						floor_count: data.floor_count ?? NaN,
						language: data.language ?? '',
						description: data.description ?? '<p></p>',
					},
					faq: Array.from({ length: 5 }).map((_, i) => ({
						question: data?.faqs?.[i]?.question ?? '',
						reply: data?.faqs?.[i]?.reply ?? '',
					})),
				};
				set({ profile: profile });
			}
		}
	},
	setProfile: (profile) => set({ profile }),
	fetchServices: async () => {
		if (!get().services) {
			const data = await getHotelServices({ type: 'hotel' });
			set({ services: data ?? [] });
		}
	},
	setServices: async (list) => {
		set({ services: list });
	},
	fetchPaymentInfo: async (force = false) => {
		if (!get().paymentInfo || force) {
			const data = await getPaymentInformation();
			if (data) {
				set({ paymentInfo: data });
			}
		}
	},
	reset: () => {
		set({
			profile: undefined,
			services: undefined,
			paymentInfo: undefined,
		});
	},
}));
