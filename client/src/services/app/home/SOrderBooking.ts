import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';

export class Bill {
    address: string;
    company: string;
    tax_code: string;

    constructor(address: string, company: string, tax_code: string) {
        this.address = address;
        this.company = company;
        this.tax_code = tax_code;
    }
}
export class Other {
    no_smoking: boolean;
    ceil: boolean;
    other: boolean;
    other_value: string;

    constructor(no_smoking: boolean, ceil: boolean, other: boolean, other_value: string) {
        this.no_smoking = no_smoking;
        this.ceil = ceil;
        this.other = other;
        this.other_value = other_value;
    }
}

export class Deputy {
    full_name: string;
    email: string;
    phone: string;
    address: string;
    is_self_booking: boolean;
    other_full_name: string;
    special_require: Other;

    constructor(
        full_name: string,
        email: string,
        phone: string,
        address: string,
        is_self_booking: boolean,
        other_full_name: string,
        special_require: Other,
        orther: Other
    ) {
        this.full_name = full_name;
        this.email = email;
        this.phone = phone;
        this.address = address;
        this.is_self_booking = is_self_booking;
        this.other_full_name = other_full_name;
        this.special_require = orther;
    }
}

export class Info {
    adt: number;
    chd: number;
    quantity: number;
    date_start: string;
    date_end: string;
    room_id: number;
    price_type_id: number;

    constructor(
        adt: number,
        chd: number,
        quantity: number,
        date_start: string,
        date_end: string,
        room_id: number,
        price_type_id: number
    ) {
        this.adt = adt;
        this.chd = chd;
        this.quantity = quantity;
        this.date_start = date_start;
        this.date_end = date_end;
        this.room_id = room_id;
        this.price_type_id = price_type_id;
    }
}

export class IOrderBooking {
    bill: Bill;
    deputy: Deputy;
    info: Info;
    order_from: string;
    payment_method: string
    return_url: string

    constructor(bill: Bill, deputy: Deputy, info: Info, order_from: string, payment_method: string, return_url: string) {
        this.bill = bill;
        this.deputy = deputy;
        this.info = info;
        this.order_from = order_from;
        this.payment_method = payment_method;
        this.return_url = return_url;
    }
}


export const SOrderBooking = async (formDate: IOrderBooking): Promise<any> => {
    try {
        const { data } = await CallAPI(API_HOTEL).post(`${AppEndpoint.APP.BOOKING_ORDER}`, formDate);
        if (!data) {
            return null;
        }
        return data.data ?? [];
    } catch (error) {
        console.error('SOrderBooking', error);
        return null;
    }
};
