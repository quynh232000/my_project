import { CallAPI } from '@/configs/axios/axios';
import { API_URL, AppEndpoint } from '@/services/type';
import { AccommodationInfo } from '@/lib/schemas/property-profile/general-information';
import { getAddressCoordinate } from '@/services/address/getAddressCoordinate';
import { getClientSideCookie } from '@/utils/cookie';

export const updateAccommodationProfile = async (
	body: AccommodationInfo
): Promise<boolean> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const formData: FormData = new FormData();
		const generalObj = { ...body.generalInfo };
		const addressObj = { ...body.address };
		const { fullAddress, ...addressData } = addressObj;
		const { image, chain_id, ...generalData } = generalObj;
		const coordinate =
			addressObj?.latitude && addressObj?.longitude
				? {
						latitude: addressObj.latitude,
						longitude: addressObj.longitude,
					}
				: fullAddress
					? await getAddressCoordinate(fullAddress)
					: null;
		Object.entries({
			_method: 'PUT',
			hotel_id: hotel_id,
			...(chain_id ? { chain_id } : {}),
			...generalData,
			...addressData,
			...body.introduction,
		}).forEach(([key, value]) => {
			formData.append(key, `${value}`);
		});
		if (image instanceof File) {
			formData.append('image', image);
		}
		if (coordinate) {
			formData.append('latitude', `${coordinate.latitude}`);
			formData.append('longitude', `${coordinate.longitude}`);
		} else {
			formData.append('latitude', '0');
			formData.append('longitude', '0');
		}
		body.faq.forEach((faq, index) => {
			formData.append(`faqs[${index}][question]`, faq.question);
			formData.append(`faqs[${index}][reply]`, faq.reply);
		});
		const res = await CallAPI(API_URL, true, 'multipart/form-data').post(
			AppEndpoint.UPDATE_HOTEL_DETAIL + `/${hotel_id}`,
			formData
		);
		return !!res;
	} catch (error) {
		console.error('getHotelDetail', error);
		return false;
	}
};
