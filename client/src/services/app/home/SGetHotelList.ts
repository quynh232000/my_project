import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';




export interface IHotelList {
    trending: Trending[]
    best_price: BestPrice[]
}

export interface Trending {
    id: number
    name: string
    slug: string
    type_location: string
    hotels: Hotel[]
}

export interface Hotel {
    id: number
    name: string
    slug: string
    stars: number
    avg_price: number
    image: string
    accommodation_id: number
    position: string[]
    hotel_image: HotelImage[]
    facilities: Facility[]
    accommodation: Accommodation
    location: Location
}

export interface HotelImage {
    id: number
    hotel_id: number
    point_id: any
    type: string
    image: string
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

export interface BestPrice {
    id: number
    name: string
    slug: string
    type_location: string
    hotels: Hotel2[]
}

export interface Hotel2 {
    id: number
    name: string
    slug: string
    stars: string
    avg_price: number
    image: string
    accommodation_id: number
    position: string[]
    hotel_image: HotelImage2[]
    facilities: Facility2[]
    accommodation: Accommodation2
    location: Location2
}

export interface HotelImage2 {
    id: number
    hotel_id: number
    point_id: any
    type: string
    image: string
}

export interface Facility2 {
    id: number
    name: string
    pivot: Pivot2
}

export interface Pivot2 {
    point_id: number
    service_id: number
}

export interface Accommodation2 {
    id: number
    name: string
}

export interface Location2 {
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


export const SGetHotelList = async (): Promise<IHotelList | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).get(`${AppEndpoint.APP.HOTEL_HOTEL_LIST}`);
        if (!data) {
            return null;
        }
        return data.data ?? [];
    } catch (error) {
        console.error('SGetHotelList', error);
        return null;
    }
};
