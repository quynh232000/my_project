import { create } from 'zustand/react';
import { RoomDetailActions, RoomDetailState } from '@/store/room-detail/type';
import { getHotelServices } from '@/services/accommodation/getHotelServices';
import { getAlbumList } from '@/services/album/getAlbum';

export const initialState: RoomDetailState = {
	album: undefined,
	services: undefined,
	roomDetail: {
		id: 0,
		name: '',
		name_id: 0,
		name_custom: '',
		status: '',
		type_id: 0,
		direction_id: 0,
		area: 0,
		quantity: 0,
		smoking: 0,
		breakfast: 0,
		price_min: 0,
		price_standard: 0,
		price_max: 0,
		bed_type_id: 0,
		bed_quantity: 0,
		sub_bed_type_id: 0,
		sub_bed_quantity: 0,
		allow_extra_guests: 0,
		standard_guests: 0,
		max_extra_adults: 0,
		max_extra_children: 0,
		max_capacity: 0,
		extra_beds: [],
	},
};

export const useRoomDetailStore = create<RoomDetailState & RoomDetailActions>(
	(set, get) => ({
		...initialState,
		setRoomDetailState: (roomDetail) =>
			set(() => ({
				roomDetail,
			})),
		fetchServices: async () => {
			const roomDetail = get().roomDetail;
			const services = get().services;
			if (!!roomDetail.id && !services) {
				const data = await getHotelServices({ type: 'room', point_id: roomDetail.id });
				set({ services: data });
			}
		},
		setServices: async (list) => {
			set({ services: list });
		},
		fetchAlbum: async (force = false) => {
			const roomDetail = get().roomDetail;
			const album = get().album;
			if (!!roomDetail.id && (force || !album)) {
				const data = await getAlbumList({ point_id: roomDetail.id });
				set({
					album:
						data?.map((item) => ({
							...item,
							priority: item.priority ? item.priority : 0,
						})) ?? [],
				});
			}
		},
		setAlbum: (list) => {
			set({ album: list });
		},
	})
);
