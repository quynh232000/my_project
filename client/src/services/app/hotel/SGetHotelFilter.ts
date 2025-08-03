import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';

export interface propsFilter {
    type: string,
    slug: string,
    date_start?: string,
    date_end?: string,
    adt?: number,
    chd?: number,
    quantity?: number,
    price_min?: number,
    price_max?: number,
    limit?: number,
    stars?: number[],
    chain_ids?: number[],
    accommodation_id?: number[],
    facilities?: number[],
    amenities?: number[],
    sort?: string,
}
export interface IHotelFilter {
    status: boolean
    message: string
    data: Daum[]
    meta: Meta
}

export interface Daum {
    id: number
    name: string
    stars: string
    avg_price: number
    slug: string
    image: string
    accommodation_id: number
    total_price: any
    price_after_discount: any
    room_id: any
    hotel_image: any[]
    facilities: Facility[]
    accommodation: Accommodation
    location: Location
}

export interface Facility {
    id: number
    name: string
    pivot: Pivot
}

export interface Pivot {
    point_id: number
    service_id: number
}

export interface Accommodation {
    id: number
    name: string
}

export interface Location {
    id: number
    hotel_id: number
    country_id: number
    country_name: string
    country_slug: string
    province_id: number
    province_name: string
    province_slug: string
    ward_id: number
    ward_name: string
    ward_slug: string
    address: string
    country_index: number
    province_index: number
    ward_index: number
    longitude: string
    latitude: string
}

export interface Meta {
    per_page: number
    current_page: number
    total_page: number
    total_item: number
}





export const SGetHotelFilter = async (params: propsFilter): Promise<IHotelFilter | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).post(`${AppEndpoint.APP.HOTEL_FILTER}`, {
            ...params
        });
        if (!data) {
            return null;
        }
        return data ?? null;
    } catch (error) {
        console.error('SGetHotelFilter', error);
        return null;
    }
};
