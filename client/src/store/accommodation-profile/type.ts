import { AccommodationInfo } from '@/lib/schemas/property-profile/general-information';
import { PaymentInformationForm } from '@/lib/schemas/property-profile/payment-information';
import { IService } from '@/services/service/getServices';

export interface IAccommodationProfileAPI {
	id: number;
	customer_id: number;
	name: string | null;
	slug: string | null;
	status: string | null;
	category_id: number | null;
	stars: string | null;
	country_id: number | null;
	city_id: number | null;
	district_id: number | null;
	ward_id: number | null;
	address: string | null;
	latitude: number | null;
	longitude: number | null;
	commission_rate: string | null;
	accommodation_id: number | null;
	time_checkin: string | null;
	time_checkout: string | null;
	avg_price: number | null;
	chain_id: number | null;
	construction_year: number | null;
	room_count: number | null;
	bar_count: number | null;
	restaurant_count: number | null;
	floor_count: number | null;
	language: string | null;
	faqs:
	| {
		question: string;
		reply: string;
	}[]
	| null;
	description: string | null;
	created_at: string;
	created_by: number;
	updated_at: string | null;
	updated_by: number | null;
	room_number: number | null;
	image: string | null;
}

export interface AccommodationProfileState {
	profile: AccommodationInfo | undefined;
	services: IService[] | undefined;
	paymentInfo: PaymentInformationForm[] | undefined;
}

export interface AccommodationProfileActions {
	setProfile: (profile: AccommodationInfo) => void;
	fetchProfile: (hotel_id: number) => Promise<void>;
	fetchServices: () => Promise<void>;
	setServices: (list: IService[] | undefined) => void;
	fetchPaymentInfo: (force?: boolean) => Promise<void>;
	reset: () => void;
}
