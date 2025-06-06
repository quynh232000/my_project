import { IRoomItem } from '@/services/room/getRoomList';
import { TPriceHistoryAPI } from '@/services/room-config/getRoomPriceHistory';

export interface RoomStore {
	roomList: IRoomItem[] | undefined;
	priceHistoryList: TPriceHistoryAPI[];
	fetchRoomList: (force?: boolean) => Promise<void>;
	reset: () => void;
	fetchPriceHistory: () => Promise<void>;
	setPriceHistoryList: (list: TPriceHistoryAPI[]) => void;
	setRoomList: (list: IRoomItem[]) => void;
}
