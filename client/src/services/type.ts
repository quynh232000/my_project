export const API_URL =
	process.env.NEXT_PUBLIC_URL_TEST_API ||
	'https://backend.190booking.com/api/v1/hms';
export const PROVINCE_API_URL =
	process.env.NEXT_PUBLIC_PROVINCE_API ||
	'https://backend.190booking.com/api/v1';
export const OPEN_STREET_MAP_API_URL =
	process.env.NEXT_PUBLIC_OPEN_STREET_MAP_API ||
	'https://nominatim.openstreetmap.org';
export const GOOGLE_MAP_API_URL =
	process.env.NEXT_PUBLIC_GOOGLE_MAP_API_KEY ||
	'AIzaSyASrN441I7X4o4GuMuDngXlF_sAELakju4';

export const AppEndpoint = {
	AUTH_LOGIN: '/auth/login',
	AUTH_LOGOUT: '/auth/logout',
	FORGOT_PASSWORD: '/auth/forgot-password',
	RESET_PASSWORD: '/auth/reset-password',
	VERIFY_RESET_CODE: '/auth/verify-reset-code',
	REFRESH_TOKEN: '/auth/refresh',
	GET_ME: '/auth/me',

	GET_ATTRIBUTES: '/attribute',
	GET_SERVICES: '/service',
	GET_BANKS: '/bank',
	HOTEL_SERVICES: '/hotel-service',
	GET_LANGUAGE: '/language',
	GET_ADDRESS: '/general/country/address',
	GET_HOTEL_LIST: '/hotel',
	GET_CHAIN_LIST: '/chain',
	GET_HOTEL_DETAIL: '/hotel/detail',
	UPDATE_HOTEL_DETAIL: '/hotel',
	PAYMENT_INFO: '/payment-info',
	GET_BANK_BRANCH: '/bank-branch',
	UPDATE_PAYMENT_INFO: '/payment-info',
	ROOM: '/room',
	ROOM_TOGGLE_STATUS: '/room/toggle-status',
	POLICY_CHILDREN: '/policy-children',
	GENERAL_POLICY: '/policy-general',
	CANCEL_POLICY: '/policy-cancellation',
	POLICY_OTHER: '/policy-other',
	PRICE_TYPE: '/price-type',
	ALBUM: '/album',
	ROOM_LIST: '/room/list',
	ROOM_QUANTITY: '/room-quantity',
	ROOM_STATUS: '/room-status',
	PRICE_SETTING: '/price-setting',
	ROOM_PRICE: '/room-price',
	ROOM_TYPE: '/room-type',
	PROMOTION: '/promotion',
	CUSTOMER: '/customer',
} as const;

export interface IResponseStatus {
	status: boolean;
	message: string;
	id?: number;
}
