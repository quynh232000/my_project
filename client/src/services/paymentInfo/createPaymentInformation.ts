import { CallAPI } from '@/configs/axios/axios';
import { PaymentInformationForm } from '@/lib/schemas/property-profile/payment-information';
import { getClientSideCookie } from '@/utils/cookie';
import { IStatusType, parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';
import { AppEndpoint, IResponseStatus } from '../type';

export const createPaymentInformation =
	async (body: PaymentInformationForm): Promise<IResponseStatus> => {
		try {
			const hotel_id = getClientSideCookie('hotel_id');
			const { data } = await CallAPI().post(AppEndpoint.PAYMENT_INFO, {
				...body,
				hotel_id,
			});
			if (!data || !data.data) {
				return {
					status: false,
					message: 'Có lỗi xảy ra, vui lòng thử lại!',
				};
			};
			return parseErrorStatus(data);
		} catch (error) {
			return parseErrorStatus(
				(error as AxiosError)?.response?.data as IStatusType
			);
		}
	};
