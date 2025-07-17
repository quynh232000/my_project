import { CallAPI } from '@/configs/axios/axios';
import { OPEN_STREET_MAP_API_URL } from '@/services/type';

export const getAddressCoordinate = async (
	address: string
): Promise<{
	latitude: number;
	longitude: number;
} | null> => {
	try {
		const { data } = await CallAPI(
			OPEN_STREET_MAP_API_URL + '/search',
			false
		).get('', {
			params: {
				q: address,
				format: 'json',
			},
		});
		if (!data) {
			return null;
		}
		return {
			latitude: data?.[0]?.lat ? +data?.[0]?.lat : 0,
			longitude: data?.[0]?.lon ? +data?.[0]?.lon : 0,
		};
	} catch (error) {
		console.error('getAddress', error);
		return null;
	}
};
