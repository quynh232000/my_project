import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';
import { getFeatureDate, objectToParams } from '@/utils/common';

export class propsHotelDetail {
    adt: number | string;
    slug: string | string;
    chd: number | string;
    quantity: number | string;
    date_start: string;
    date_end: string;
    constructor() {
        this.slug = '';
        this.adt = 2;
        this.chd = 0;
        this.quantity = 1;
        this.date_start = getFeatureDate(1);
        this.date_end = getFeatureDate(2);
    }
}





export const SGetHotelDetail = async (params: propsHotelDetail): Promise<IHotelDetail | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).get(`${AppEndpoint.APP.HOTEL_DETAIL}/${params.slug}?` + objectToParams(params));
        if (!data) {
            return null;
        }
        return data.data ?? null;
    } catch (error) {
        console.error('SGetHotelDetail', error);
        return null;
    }
};


export interface IHotelDetail {
    id: number
    customer_id: any
    name: string
    curation: any
    slug: string
    category_id: any
    stars: string
    commission_rate: string
    accommodation_id: number
    time_checkin: string
    time_checkout: string
    avg_price: number
    rank: any
    chain_id: number
    construction_year: number
    room_count: number
    bar_count: number
    restaurant_count: number
    floor_count: number
    language: number
    position: string[]
    faqs: Faq[]
    description: string
    room_number: number
    image: string
    meta_title: any
    meta_keyword: any
    meta_description: any
    hotelId: any
    reviewMessage: any
    reviewCount: any
    recommended_rooms: RecommendedRoom[]
    breadcrumb: Breadcrumb[]
    relative_hotels: RelativeHotel[]
    reviews: Reviews
    location: Location2
    chain: Chain
    hotel_image: hotelImage[]
    accommodation: Accommodation2
    facilities: Facility[]
    near_locations: any[]
    policy_others: any[]
    policy_generals: any[]
    policy_children: any[]
    policy_cancellations: any[]
    keymaps: Keymap[]
}

export interface Faq {
    question: string
    reply: string
}

export interface RecommendedRoom {
    id: number
    name: string
    name_id: number
    hotel_id: number
    slug: any
    type_id: number
    direction_id: number
    area: number
    quantity: number
    smoking: number
    breakfast: number
    price_min: number
    price_standard: number
    price_max: number
    bed_type_id: number
    bed_quantity: number
    sub_bed_type_id: any
    sub_bed_quantity: any
    allow_extra_guests: number
    standard_guests: number
    max_extra_adults: number
    max_extra_children: number
    max_capacity: number
    amenities: Amenity[]
    images: hotelImage[]
    room_extra_beds: any[]
    bed_type: BedType
    sub_bed_type: any
    direction: Direction
    room_inventory_list: RoomInventoryList[]
}
export interface hotelImage {
    id: number
    image: string
    label: Label
}

export interface Label {
    name: string
}


export interface Amenity {
    id: number
    name: string
    image: any
    parent_id: number
    pivot: Pivot
    parents: Parents
}

export interface Pivot {
    point_id: number
    service_id: number
}

export interface Parents {
    id: number
    name: string
}

export interface Image {
    id: number
    hotel_id: number
    label_id: number
    type: string
    point_id: number
    priority: number
    image: string
    label: Label
}

export interface Label {
    id: number
    name: string
}

export interface BedType {
    id: number
    name: string
}

export interface Direction {
    id: number
    name: string
}

export interface RoomInventoryList {
    surcharge: number
    prices: Price[]
    policy_cancellation: Policy_cancellation
    final_price: FinalPrice
}
export interface Policy_cancellation {
    id: number
    hotel_id: number
    code: string
    name: string
    is_global: number
    policy_cancel_rules: PolicyCancelRule[]
}

export interface PolicyCancelRule {
    id: number
    policy_cancel_id: number
    day: number
    fee_type: string
    fee: number
}

export interface Price {
    price_type_id: number
    price: number
    date: string
    promotions: any[]
    num_remaining_rooms: number
}

export interface FinalPrice {
    price_base: number
    price_after_discount: number
}

export interface Breadcrumb {
    id: number
    name: string
    slug: string
    type_location: string
}

export interface RelativeHotel {
    id: number
    name: string
    slug: string
    avg_price: number
    stars: string
    image: string
    accommodation_id: number
    hotel_image: any[]
    facilities: any[]
    location: Location
    accommodation: Accommodation
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

export interface Accommodation {
    id: number
    name: string
}

export interface Reviews {
    avg: number
    list: any[]
    rating: any[]
    list_images: any[]
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

export interface Chain {
    id: number
    name: string
    slug: string
}

export interface Accommodation2 {
    id: number
    name: string
    slug: string
}

export interface Facility {
    id: number
    name: string
    image: any
    parent_id: number
    pivot: Pivot2
    parents: Parents2
}

export interface Pivot2 {
    point_id: number
    service_id: number
}

export interface Parents2 {
    id: number
    name: string
}

export interface Keymap {
    id: number
    name: string
    parent_id: number
    slug: string
    parents: Parents3
}

export interface Parents3 {
    id: number
    name: string
    slug: string
}

