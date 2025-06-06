import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export const attributeTypes = [
	'accommodation_type',
	'bed_type',
	'direction_type',
	'image_type',
	'room_type',
	'serving_type',
	'breakfast_type',
	'adult_require',
	'duccument_require',
	'method_deposit',
	'image_room',
	'image_hotel',
	'image_facility',
	'image_food',
	'image_local_sight',
	'image_other',
] as const;

export type AttributeType = (typeof attributeTypes)[number];

interface props {
	type: AttributeType;
	list_tree?: boolean;
}

export interface IAttributeItem {
	id: string;
	name: string;
	slug: string;
}

export interface IChainItem {
	id: number;
	name: string;
	type: string;
}

export const getAttributes = async ({
	type,
}: props): Promise<IAttributeItem[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.GET_ATTRIBUTES}`, {
			params: {
				type,
				hotel_id,
			},
		});
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getAttributes', error);
		return null;
	}
};
