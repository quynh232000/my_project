import { create } from 'zustand/react';
import { AlbumHotelActions, AlbumHotelState } from '@/store/album/type';
import { getAlbumHotel } from '@/services/album/getAlbumHotel';

export const initialState: AlbumHotelState = {
	albumHotel: undefined,
	deletedAlbumIds: [],
	needFetch: false,
	selectedTab: 'general',
};

export const useAlbumHotelStore = create<AlbumHotelState & AlbumHotelActions>(
	(set, get) => ({
		...initialState,
		setAlbumHotel: (albumHotel) =>
			set(() => ({
				albumHotel,
			})),
		fetchAlbumHotel: async (force = false) => {
			if (!get().albumHotel || force || get().needFetch) {
				const data = await getAlbumHotel();
				set({ albumHotel: data });
			}
		},
		setDeletedAlbumIds: (deletedAlbumIds) =>
			set(() => ({
				deletedAlbumIds,
			})),
		setNeedFetch: (needFetch) =>
			set(() => ({
				needFetch,
			})),
		reset: () =>
			set(() => ({
				albumHotel: undefined,
				deletedAlbumIds: [],
				needFetch: false,
			})),
		setSelectedTab: (selectedTab: string) =>
			set(() => ({
				selectedTab,
			})),
	})
);
