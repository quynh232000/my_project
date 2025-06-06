import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export type TImageTagList = {
	id: number;
	name: string;
	slug: string;
	parent_id: number;
	children: {
		id: number;
		name: string;
		slug: string;
		parent_id: number;
	}[];
}[];

export const getAttributeImageType = async (): Promise<TImageTagList> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.GET_ATTRIBUTES}`, {
			params: {
				type: 'image_type',
				list_tree: true,
				hotel_id,
			},
		});

		return data.data ?? {}; // Trả về object group sẵn
	} catch (error) {
		console.error('getAttributeImageType', error);
		throw error;
	}
};