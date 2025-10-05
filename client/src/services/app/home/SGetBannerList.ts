import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';




export interface IBannerItem {
    id: number
    slug: string
    image: string
    title: string
}

export const SGetBannerList = async (): Promise<IBannerItem[]> => {
    try {
        const { data } = await CallAPI(API_HOTEL).get(`${AppEndpoint.APP.HOTEL_BANNER_LIST}`);
        if (!data) {
            return [];
        }
        return data.data ?? [];
    } catch (error) {
        console.error('SGetBannerList', error);
        return [];
    }
};
