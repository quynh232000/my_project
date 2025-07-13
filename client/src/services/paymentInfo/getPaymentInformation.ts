import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '../type';
import { getClientSideCookie } from '@/utils/cookie';
import { PaymentInformationForm } from '@/lib/schemas/property-profile/payment-information';

export const getPaymentInformation = async (): Promise<
	PaymentInformationForm[] | null
> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(AppEndpoint.PAYMENT_INFO, {
			params: {
				hotel_id,
				limit: 9999,
			},
		});
		if (!data || !data.data) return null;
		return data.data;
	} catch (error) {
		return null;
	}
};
