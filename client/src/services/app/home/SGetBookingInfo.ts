import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';

export interface IBookingInfo {
    code: string
    price_type_id: number
    final_money: number
    total_price: number
    total_discount: number
    total_surcharge: number
    duration: number
    quantity: number
    adt: number
    chd: number
    depart_date: string
    return_date: string
    room_id: number
    hotel_id: number
    currency: string
    order_from: string
    ip: string
    price_type: PriceType
    room: Room
    hotel: Hotel
    daily_prices: DailyPrice[]
    time_left: number



}

export interface PriceType {
    id: number
    name: string
    rate_type: string
    policy_cancel_id: number
    adt_fees: any
    date_min: number
    date_max: number
    night_min: number
    night_max: number
    status: string
    policy_cancel: PolicyCancel
    policy_children: PolicyChildren[]
}

export interface PolicyCancel {
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

export interface PolicyChildren {
    id: number
    hotel_id: number
    age_from: number
    age_to: number
    fee_type: string
    quantity_child: number
    fee: number
    type: string
    meal_type: string
    price_type_id: any
}

export interface Room {
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
    price_details: PriceDetail[]
    direction: Direction
    bed_type: BedType
    price_settings: any[]
    promotions: Promotion[]
    images: RoomImage[]
}
interface RoomImage {
    id: number
    image: string
}

export interface PriceDetail {
    id: number
    room_id: number
    date: string
    quantity: any
    room_booked: number
    status: any
    updated_by: any
    updated_at: any
    price_detail_price_types: PriceDetailPriceType[]
}

export interface PriceDetailPriceType {
    id: number
    price_detail_id: number
    price_type_id: number
    room_id: number
    price: number
    price_type: PriceType2
}

export interface PriceType2 {
    id: number
    name: string
    rate_type: string
    policy_cancel_id: number
    adt_fees: any
    date_min: number
    date_max: number
    night_min: number
    night_max: number
    status: string
}

export interface Direction {
    id: number
    name: string
}

export interface BedType {
    id: number
    name: string
}

export interface Promotion {
    id: number
    hotel_id: number
    name: string
    type: string
    value: string
    start_date: string
    end_date: any
    is_stackable: number
    status: string
    day_1: number
    day_2: number
    day_3: number
    day_4: number
    day_5: number
    day_6: number
    day_7: number
    pivot: Pivot
}

export interface Pivot {
    room_id: number
    promotion_id: number
}

export interface Hotel {
    id: number
    slug: string
    name: string
    accommodation_id: number
    stars: string
    accommodation: Accommodation
    policy_others: PolicyOther[]
    policy_generals: PolicyGeneral[]
    policy_cancellations: PolicyCancellation[]
    image: string
    location: Location2
    time_checkin: string
    time_checkout: string
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

export interface Accommodation {
    id: number
    name: string
}

export interface PolicyOther {
    id: number
    hotel_id: number
    policy_setting_id: number
    settings?: Settings
    policy_name: PolicyName
}

export interface Settings {
    time_from?: string
    time_to?: string
    breakfast_type?: number
    serving_type?: number
    extra_breakfast?: any[]
    age?: number
    adult_require?: string[]
    duccument_require?: string[]
    accompanying_adult_proof?: boolean
    doccument_require?: string[]
    amount?: number
    type_deposit?: string
    method_deposit?: string[]
}

export interface PolicyName {
    id: number
    name: string
}

export interface PolicyGeneral {
    id: number
    hotel_id: number
    policy_setting_id: number
    is_allow: number
    policy_name: PolicyName2
}

export interface PolicyName2 {
    id: number
    name: string
}

export interface PolicyCancellation {
    id: number
    hotel_id: number
    code: any
    name: string
    is_global: number
    policy_cancel_rules: PolicyCancelRule2[]
    price_types: any[]
}

export interface PolicyCancelRule2 {
    id: number
    policy_cancel_id: number
    day: number
    fee_type: string
    fee: number
}

export interface DailyPrice {
    price: number
    date: string
    surcharge: number
    room_booked_current: number
    discount_amount: number
    final_price: number
    promotions: string
}


export const SGetBookingInfo = async (token: string): Promise<IBookingInfo | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).post(`${AppEndpoint.APP.BOOKING_INFO}`, { token });
        if (!data) {
            return null;
        }
        return data.data ?? [];
    } catch (error) {
        console.error('SGetBookingInfo', error);
        return null;
    }
};
