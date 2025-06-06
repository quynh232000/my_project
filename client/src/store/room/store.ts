import { create } from 'zustand/react';

import { getRoomPriceHistory, TPriceHistoryAPI } from '@/services/room-config/getRoomPriceHistory';
import {
	getRoomList
} from '@/services/room/getRoomList';
import { RoomStore } from '@/store/room/type';

export const useRoomStore = create<RoomStore>((set, get) => ({
	roomList: undefined,
	priceHistoryList: [] as TPriceHistoryAPI[],
	fetchRoomList: async (force = false) => {
		if (!get().roomList || force) {
			const roomList = await getRoomList();
			return set({ roomList: roomList || undefined });
		}
	},
	reset: () => set({ roomList: undefined }),
	fetchPriceHistory: async () => {
		if (get().priceHistoryList.length === 0) {
			const priceHistoryList = await getRoomPriceHistory();
			if (priceHistoryList && priceHistoryList.length > 0) {
				return set({ priceHistoryList });
			} else {
				set({ priceHistoryList: [] });
			}
		}
	},
	setPriceHistoryList: (list) => set({ priceHistoryList: list }),
	setRoomList: (list) => set({ roomList: list })
}));
