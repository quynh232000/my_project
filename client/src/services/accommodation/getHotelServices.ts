import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { IService, ServiceType } from '@/services/service/getServices';
import { getClientSideCookie } from '@/utils/cookie';

interface props {
	type: ServiceType;
	point_id?: number;
}

export const getHotelServices = async ({
	type,
	point_id,
}: props): Promise<IService[] | undefined> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(
			`${AppEndpoint.HOTEL_SERVICES}`,
			{
				params: {
					type,
					point_id,
					hotel_id
				},
			}
		);
		if (!data) {
			return undefined;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getHotelServices', error);
		return undefined;
	}
};
