import { create } from 'zustand/react';
import { AttributeStore } from '@/store/attributes/type';
import {
	getAttributes,
} from '@/services/attributes/getAttributes';
import { getRoomType } from '@/services/room-config/getRoomType';
import { getAttributeImageType } from '@/services/attributes/getAttributeImageType';
import { getChainList } from '@/services/accommodation/getChainList';

export const useAttributeStore = create<AttributeStore>((set, get) => ({
	roomTypeList: undefined,
	imageTypeList: undefined,
	accommodationTypeList: undefined,
	directionList: undefined,
	bedTypeList: undefined,
	servingTypeList: undefined,
	breakFastTypeList: undefined,
	adultRequireList: undefined,
	duccumentRequireList: undefined,
	methodDepositList: undefined,
	imageTypeParentList: undefined,
	imageRoomList: undefined,
	chainList: undefined,
	fetchBedTypeList: async (force = false) => {
		if (!get().bedTypeList || force) {
			const bedTypeList = await getAttributes({ type: 'bed_type' });
			if (bedTypeList && bedTypeList.length > 0) {
				return set({ bedTypeList });
			} else {
				set({ bedTypeList: [] });
			}
		}
	},
	fetchDirectionList: async (force = false) => {
		if (!get().directionList || force) {
			const directionList = await getAttributes({ type: 'direction_type' });
			if (directionList && directionList.length > 0) {
				return set({ directionList });
			} else {
				set({ directionList: [] });
			}
		}
	},
	fetchImageTypeList: async (force = false) => {
		if (!get().imageTypeList || force) {
			const imageTypeList = await getAttributeImageType();
			if (imageTypeList && imageTypeList.length > 0) {
				return set({ imageTypeList });
			} else {
				set({ imageTypeList: [] });
			}
		}
	},
	fetchAccommodationTypeList: async (force = false) => {
		if (!get().accommodationTypeList || force) {
			const accommodationTypeList = await getAttributes({
				type: 'accommodation_type',
			});
			if (accommodationTypeList && accommodationTypeList.length > 0) {
				return set({ accommodationTypeList });
			} else {
				set({ accommodationTypeList: [] });
			}
		}
	},
	fetchRoomTypeList: async (force = false) => {
		if (!get().roomTypeList || force) {
			const roomTypeList = await getRoomType({ with_name: true });
			if (roomTypeList && roomTypeList.length > 0) {
				return set({ roomTypeList });
			} else {
				set({ roomTypeList: [] });
			}
		}
	},
	fetchServingTypeList: async (force = false) => {
		if (!get().servingTypeList || force) {
			const servingTypeList = await getAttributes({ type: 'serving_type' });
			if (servingTypeList && servingTypeList.length > 0) {
				return set({ servingTypeList });
			} else {
				set({ servingTypeList: [] });
			}
		}
	},
	fetchBreakFastTypeList: async (force = false) => {
		if (!get().breakFastTypeList || force) {
			const breakFastTypeList = await getAttributes({ type: 'breakfast_type' });
			if (breakFastTypeList && breakFastTypeList.length > 0) {
				return set({ breakFastTypeList });
			} else {
				set({ breakFastTypeList: [] });
			}
		}
	},
	fetchAdultRequireList: async (force = false) => {
		if (!get().adultRequireList || force) {
			const adultRequireList = await getAttributes({ type: 'adult_require' });
			if (adultRequireList && adultRequireList.length > 0) {
				return set({ adultRequireList });
			} else {
				set({ adultRequireList: [] });
			}
		}
	},
	fetchDuccumentRequireList: async (force = false) => {
		if (!get().duccumentRequireList || force) {
			const duccumentRequireList = await getAttributes({
				type: 'duccument_require',
			});

			if (duccumentRequireList && duccumentRequireList.length > 0) {
				return set({ duccumentRequireList });
			} else {
				set({ duccumentRequireList: [] });
			}
		}
	},

	fetchMethodDepositList: async (force = false) => {
		if (!get().methodDepositList || force) {
			const methodDepositList = await getAttributes({
				type: 'method_deposit',
			});
			if (methodDepositList && methodDepositList.length > 0) {
				return set({ methodDepositList });
			} else {
				set({ methodDepositList: [] });
			}
		}
	},
	fetchImageTypeParentList: async (force = false) => {
		if (!get().imageTypeParentList || force) {
			const imageTypeParentList = await getAttributes({
				type: 'image_type',
			});
			if (imageTypeParentList && imageTypeParentList.length > 0) {
				return set({ imageTypeParentList });
			} else {
				set({ imageTypeParentList: [] });
			}
		}
	},
	fetchImageRoomList: async (force = false) => {
		if (!get().imageRoomList || force) {
			const imageRoomList = await getAttributes({
				type: 'image_room',
			});
			if (imageRoomList && imageRoomList.length > 0) {
				return set({ imageRoomList });
			} else {
				set({ imageRoomList: [] });
			}
		}
	},
	fetchChainList: async (force = false) => {
		if (!get().chainList || force) {
			const chainList = await getChainList();
			return set({ chainList: chainList ?? undefined });
		}
	},
}));
