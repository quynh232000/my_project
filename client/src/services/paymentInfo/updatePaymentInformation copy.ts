import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '../type';
import { getClientSideCookie } from '@/utils/cookie';
import { PaymentInformationForm } from '@/lib/schemas/property-profile/payment-information';
import { IStatusType, parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

export const updatePaymentInformation = async (
	body: Partial<PaymentInformationForm> & { id: number }
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().put(
			AppEndpoint.PAYMENT_INFO + `/${body.id}`,
			{
				...body,
				hotel_id,
			}
		);
		if (!data) {
			return {
				status: false,
				message: 'Có lỗi xảy ra, vui lòng thử lại!',
			};
		}
		return parseErrorStatus(data);
	} catch (error) {
		return parseErrorStatus(
			(error as AxiosError)?.response?.data as IStatusType
		);
	}
};
