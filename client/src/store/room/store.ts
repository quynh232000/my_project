import { create } from 'zustand/react';

import {
	getRoomPriceHistory,
	TPriceHistoryAPI,
} from '@/services/room-config/getRoomPriceHistory';
import { getRoomList } from '@/services/room/getRoomList';
import { RoomStore } from '@/store/room/type';

export const useRoomStore = create<RoomStore>((set, get) => ({
	roomList: undefined,
	needFetch: false,
	priceHistoryList: [] as TPriceHistoryAPI[],
	fetchRoomList: async (force = false) => {
		if (!get().roomList || force || get().needFetch) {
			const roomList = await getRoomList();
			return set({ roomList: roomList || undefined, needFetch: false });
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
	setNeedFetch: (needFetch) => set({ needFetch }),
	setPriceHistoryList: (list) => set({ priceHistoryList: list }),
	setRoomList: (list) => set({ roomList: list }),

	allColumns: [],
	setAllColumns: (columns) => set({allColumns: columns}),
	visibleFields: ['id', 'name', 'max_capacity', 'area', 'quantity', 'status'],
	setVisibleFields: (fields) => set({ visibleFields: fields }),
}));
