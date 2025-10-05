import { CallAPI } from '@/configs/axios/axios';
import { API_HOTEL, AppEndpoint } from '@/services/type';



export const SCreateOrder = async (token: string): Promise<any> => {
    try {
        const { data } = await CallAPI(API_HOTEL).post(`${AppEndpoint.APP.BOOKING_ORDER}`, { token });
        if (!data) {
            return null;
        }
        return data ?? null;
    } catch (error) {
        console.error('SCreateOrder', error);
        return null;
    }
};
