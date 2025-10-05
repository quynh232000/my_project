import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';

export interface IOrderVerify {
    code: string
    hotel_id: number
    room_id: number
    price_type_id: number
    price_type: PriceType
    final_money: number
    total_price: number
    total_discount: number
    total_surcharge: number
    quantity: number
    adt: number
    chd: number
    depart_date: string
    return_date: string
    duration: number
    currency: string
    status: number
    hotel: Hotel
    room: Room
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

export interface Room {
    id: number
    name: string
    area: number
    direction_id: number
    bed_type_id: number
    bed_quantity: number
    breakfast: number
    smoking: number
    capacity_avg: CapacityAvg
    direction: Direction
    bed_type: BedType
}

export interface CapacityAvg {
    adt: number
    chd: number
}

export interface Direction {
    id: number
    name: string
}

export interface BedType {
    id: number
    name: string
}


export const SOrderVerify = async (code: string): Promise<IOrderVerify | null> => {
    try {
        const { data } = await CallAPI(API_HOTEL).post(`${AppEndpoint.APP.BOOKING_ORDER_VERIFY}`, { code });
        if (!data) {
            return null;
        }
        return data.data ?? [];
    } catch (error) {
        console.error('SOrderVerify', error);
        return null;
    }
};
