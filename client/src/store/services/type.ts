import { IService } from '@/services/service/getServices';

export interface ServiceStore {
	hotelServiceList: IService[];
	roomServiceList: IService[];
	fetchHotelServiceList: () => Promise<void>;
	fetchRoomServiceList: () => Promise<void>;
}
