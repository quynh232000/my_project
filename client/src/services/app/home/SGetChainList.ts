import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';




export interface IChainItem {
    id: number
    name: string
    slug: string
    logo: string
    image: string
    price: number
}



export const SGetChainList = async (): Promise<IChainItem[] | []> => {
    try {
        const { data } = await CallAPI(API_HOTEL).get(`${AppEndpoint.APP.CHAIN_LIST}`,);
        if (!data) {
            return [];
        }
        return data.data ?? [];
    } catch (error) {
        console.error('SGetChainList', error);
        return [];
    }
};
