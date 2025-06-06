import { IRoomDetail } from '@/services/room/getRoomDetail';
import { IService } from '@/services/service/getServices';
import { IAlbumItem } from '@/services/album/getAlbum';

export interface RoomDetailState {
	roomDetail: IRoomDetail;
	services: IService[] | undefined;
	album: IAlbumItem[] | undefined;
}

export interface RoomDetailActions {
	setRoomDetailState: (info: IRoomDetail) => void;
	fetchServices: () => Promise<void>;
	setServices: (list: IService[] | undefined) => void;
	fetchAlbum: (force?: boolean) => Promise<void>;
	setAlbum: (list: IAlbumItem[] | undefined) => void;
}
