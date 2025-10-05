import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';

type props = {
    type: string,
    slug: string
}



export interface IHotelCategoryDetail {
    info: Info
    accommodation: Accommodation[]
    chains: Chain[]
    facilities: Facility[]
    amenities: Amenity[]
}

export interface Info {
    id: number
    name: string
    slug: string
    image: string
    parent_id: any
    type: string
    position: any
    country_id: number
    province_id: any
    ward_id: any
    address: any
    accommodation_id: any
    lat: any
    lon: any
    radius_km: any
    facility_id: any
    priority: number
    is_default: number
    description: string
    meta_title: string
    type_location: string
    location_radius: any
    meta_keyword: string
    meta_description: string
    created_at: string
    product_counts: number
    origin: string
}

export interface Accommodation {
    id: number
    name: string
    slug: string
}

export interface Chain {
    id: number
    name: string
}

export interface Facility {
    id: number
    service_id: number
    facility: Facility2
}

export interface Facility2 {
    id: number
    name: string
}

export interface Amenity {
    id: number
    service_id: number
    amenity: Amenity2
}

export interface Amenity2 {
    id: number
    name: string
}


export const SGetHotelCategoryDetail = async (params: props): Promise<IHotelCategoryDetail | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).get(`${AppEndpoint.APP.HOTEL_HOTEL_CATEGORY_DETAIL}/${params.slug}?type=${params.type}`);
        if (!data) {
            return null;
        }
        return data.data ?? null;
    } catch (error) {
        console.error('SGetHotelCategoryDetail', error);
        return null;
    }
};
