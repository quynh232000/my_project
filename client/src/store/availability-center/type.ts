import { DateRange } from 'react-day-picker';
import { IRoomConfig } from '@/services/room-config/getListConfig';

export interface IAvailabilityParams {
	room: number | 'all';
	filterDate: DateRange | undefined;
	filterPrice: boolean;
}

export interface AvailabilityState {
	isParsedParams: boolean;
	params: IAvailabilityParams;
	list: IRoomConfig[];
}

export interface AvailabilityActions {
	setParams: (params: Partial<IAvailabilityParams>) => void;
	setIsParsedParams: (val: boolean) => void;
	fetchListConfig: () => Promise<void>;
	reset: () => void;
}
