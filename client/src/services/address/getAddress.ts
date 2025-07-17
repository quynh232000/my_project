import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, PROVINCE_API_URL } from '@/services/type';

export const addressTypes = [
	'country_id',
	'city_id',
	'district_id',
	'ward_id',
] as const;

export type AddressType = (typeof addressTypes)[number];

interface props {
	type: AddressType;
	id?: number;
}

export interface IAddressItem {
	id: number;
	name: string;
}

export const getAddress = async ({
	type,
	id,
}: props): Promise<IAddressItem[] | null> => {
	try {
		const { data } = await CallAPI(PROVINCE_API_URL).post(
			`${AppEndpoint.GET_ADDRESS}`,
			{
				type,
				id,
			}
		);
		if (!data) {
			return null;
		}
		return data.data ?? [];
	} catch (error) {
		console.error('getAddress', error);
		return null;
	}
};
