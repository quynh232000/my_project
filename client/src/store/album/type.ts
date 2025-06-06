import { HotelRoomsResponse } from '@/services/album/getAlbumHotel';

export type TDeletedAlbumIds = {
	id: string;
	room_id: string | undefined;
}[]
export interface AlbumHotelState {
	albumHotel: HotelRoomsResponse | undefined;
	deletedAlbumIds:TDeletedAlbumIds;
	needFetch: boolean;
	selectedTab: string;
}

export interface AlbumHotelActions {
	fetchAlbumHotel: (force?: boolean) => Promise<void>;
	setAlbumHotel: (list: HotelRoomsResponse | undefined) => void;
	setDeletedAlbumIds: (list: TDeletedAlbumIds) => void;
	setNeedFetch: (needFetch: boolean) => void;
	reset: () => void;
	setSelectedTab: (selectedTab: string) => void;
}
