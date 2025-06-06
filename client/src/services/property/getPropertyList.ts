import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';

export interface IProperty {
	id: number;
	name: string;
	address: string;
	status: string;
	created_at: string;
}

export const getPropertyList = async (): Promise<IProperty[] | null> => {
	try {
		const { data } = await CallAPI().get(`${AppEndpoint.GET_HOTEL_LIST}`);
		if (!data) {
			return null;
		}
		return Promise.resolve(data.data ?? []);
	} catch (error) {
		return Promise.reject(error);
	}
};
