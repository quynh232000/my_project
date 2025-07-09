import { IRoomItem } from '@/services/room/getRoomList';
import { TPriceHistoryAPI } from '@/services/room-config/getRoomPriceHistory';
import { ColumnDef } from '@/components/shared/DashboardTable';

export interface RoomStore {
	roomList: IRoomItem[] | undefined;
	priceHistoryList: TPriceHistoryAPI[];
	fetchRoomList: (force?: boolean) => Promise<void>;
	needFetch: boolean;
	setNeedFetch: (needFetch: boolean) => void;
	reset: () => void;
	fetchPriceHistory: () => Promise<void>;
	setPriceHistoryList: (list: TPriceHistoryAPI[]) => void;
	setRoomList: (list: IRoomItem[]) => void;

	allColumns: ColumnDef<IRoomItem>[];
	setAllColumns: (columns: ColumnDef<IRoomItem>[]) => void;
	visibleFields: (keyof IRoomItem)[];
	setVisibleFields: (
		fields: (keyof IRoomItem)[]
	) => void;
}
