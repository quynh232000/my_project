import { CallAPI } from '@/configs/axios/axios';
import { IRoomDetail } from '@/services/room/getRoomDetail';
import { AppEndpoint, IResponseStatus } from '@/services/type';
import { getClientSideCookie } from '@/utils/cookie';
import { IStatusType, parseErrorStatus } from '@/utils/errors/parseErrorStatus';
import { AxiosError } from 'axios';

export interface UpdateRoomDetailBodyType extends Partial<IRoomDetail> {
	id: number;
}

export const updateRoomDetail = async (
	payload: UpdateRoomDetailBodyType
): Promise<IResponseStatus> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const res = await CallAPI().put(`${AppEndpoint.ROOM}/${payload.id}`, {
			...payload,
			hotel_id,
		});

		if (!res.data) {
			return {
				status: false,
				message: 'Có lỗi xảy ra, vui lòng thử lại!',
			};
		}
		return parseErrorStatus(res.data);
	} catch (error) {
		return parseErrorStatus(
			(error as AxiosError)?.response?.data as IStatusType
		);
	}
};
