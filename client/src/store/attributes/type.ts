import {
	IAttributeItem,
	IChainItem,
} from '@/services/attributes/getAttributes';
import { IRoomType } from '@/services/room-config/getRoomType';
import { TImageTagList } from '@/services/attributes/getAttributeImageType';

export interface AttributeStore {
	accommodationTypeList: IAttributeItem[] | undefined;
	bedTypeList: IAttributeItem[] | undefined;
	directionList: IAttributeItem[] | undefined;
	imageTypeList: TImageTagList | undefined;
	roomTypeList: IRoomType[] | undefined;
	servingTypeList: IAttributeItem[] | undefined;
	breakFastTypeList: IAttributeItem[] | undefined;
	adultRequireList: IAttributeItem[] | undefined;
	duccumentRequireList: IAttributeItem[] | undefined;
	methodDepositList: IAttributeItem[] | undefined;
	imageTypeParentList: IAttributeItem[] | undefined;
	imageRoomList: IAttributeItem[] | undefined;
	chainList: IChainItem[] | undefined;

	fetchAccommodationTypeList: (force?: boolean) => Promise<void>;
	fetchBedTypeList: (force?: boolean) => Promise<void>;
	fetchDirectionList: (force?: boolean) => Promise<void>;
	fetchImageTypeList: (force?: boolean) => Promise<void>;
	fetchRoomTypeList: (force?: boolean) => Promise<void>;
	fetchServingTypeList: (force?: boolean) => Promise<void>;
	fetchBreakFastTypeList: (force?: boolean) => Promise<void>;
	fetchAdultRequireList: (force?: boolean) => Promise<void>;
	fetchDuccumentRequireList: (force?: boolean) => Promise<void>;
	fetchMethodDepositList: (force?: boolean) => Promise<void>;
	fetchImageTypeParentList: (force?: boolean) => Promise<void>;
	fetchImageRoomList: (force?: boolean) => Promise<void>;
	fetchChainList: (force?: boolean) => Promise<void>;
}
