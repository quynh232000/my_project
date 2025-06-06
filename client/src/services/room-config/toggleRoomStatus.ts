import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IStatusType, parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';
import { ERoomStatus } from '../room/getRoomList';

interface toggleRoomStatusBody {
	status: ERoomStatus;
	room_ids: number[];
}

export const toggleRoomStatus = async (
	body: toggleRoomStatusBody
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().put(
			`${AppEndpoint.ROOM_TOGGLE_STATUS}`,
			{
				hotel_id,
				...body,
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
		console.error('toggleRoomStatus', error);
		return parseErrorStatus(
			(error as AxiosError)?.response?.data as IStatusType
		);
	}
};
