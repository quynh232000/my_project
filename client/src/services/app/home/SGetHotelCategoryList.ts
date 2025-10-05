import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';




export interface IData {
    destination: Destination[]
    interest: Interest[]
}

export interface Destination {
    id: number
    name: string
    slug: string
    image: string
    priority: number
    created_at: string
    country_id: number
    province_id: number
    ward_id?: number
    type_location?: string
    product_counts: number
}

export interface Interest {
    id: number
    name: string
    slug: string
    image: string
    priority: number
    created_at: string
    country_id: number
    province_id: number
    ward_id?: number
    type_location?: string
    product_counts: number
}


export const SGetHotelCategoryList = async (): Promise<IData | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).get(`${AppEndpoint.APP.HOTEL_CATEGORY_LIST}`,);
        if (!data) {
            return null;
        }
        return data.data ?? [];
    } catch (error) {
        console.error('SGetHotelCategoryList', error);
        return null;
    }
};
