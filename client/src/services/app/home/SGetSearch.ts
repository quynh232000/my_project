import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';


export interface ISearch {
    categories: Category[]
    hotels: Hotel[]
    locations: Location2[]
    chains: Chain[]
}

export interface Category {
    id: number
    name: string
    slug: string
    image: string
    priority: number
    country_id: number
    ward_id?: number
    province_id?: number
    type_location: string
    position?: string[]
    product_counts: number
}

export interface Hotel {
    id: number
    name: string
    slug: string
    image: string
    location: Location
    accommodation: any
}

export interface Location {
    id: number
    hotel_id: number
    country_name: string
    province_name: string
    ward_name: string
    address: string
}

export interface Location2 {
    id: number
    country_name: string
    country_slug: string
    province_name: any
    province_slug: any
    ward_name: any
    ward_slug: any
    type: string
    label: string
}

export interface Chain {
    id: number
    name: string
    slug: string
    logo: string
}


export const SGetSearch = async (search: string): Promise<ISearch | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).get(`${AppEndpoint.APP.HOTEL_SEARCH}?search=` + search);
        if (!data) {
            return null;
        }
        return data.data ?? null;
    } catch (error) {
        console.error('SGetSearch', error);
        return null;
    }
};
