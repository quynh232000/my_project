import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';

export const serviceTypes = ['room', 'hotel'] as const;

export type ServiceType = (typeof serviceTypes)[number];

interface props {
	type: ServiceType;
}

export interface IService {
	id: number;
	name: string;
	parent_id: number;
	children: { id: number; name: string; parent_id: number }[];
}

export const getServices = async ({
	type,
}: props): Promise<IService[] | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.GET_SERVICES}`, {
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
		console.error('getServices', error);
		return null;
	}
};
