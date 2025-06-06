import { create } from 'zustand/react';
import { getServices, IService } from '@/services/service/getServices';
import { ServiceStore } from '@/store/services/type';

export const useServiceStore = create<ServiceStore>((set, get) => ({
	hotelServiceList: [] as IService[],
	roomServiceList: [] as IService[],
	fetchRoomServiceList: async () => {
		if (get().roomServiceList && get().roomServiceList.length === 0) {
			const roomServiceList = await getServices({ type: 'room' });
			if (roomServiceList && roomServiceList.length > 0) {
				return set({ roomServiceList });
			} else {
				set({ roomServiceList: [] });
			}
		}
	},
	fetchHotelServiceList: async () => {
		if (get().hotelServiceList && get().hotelServiceList.length === 0) {
			const hotelServiceList = await getServices({ type: 'hotel' });
			if (hotelServiceList && hotelServiceList.length > 0) {
				return set({ hotelServiceList });
			} else {
				set({ hotelServiceList: [] });
			}
		}
	},
}));
