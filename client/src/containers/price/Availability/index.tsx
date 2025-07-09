'use client';
import DialogPricingSetting from '@/containers/price/Availability/common/DialogPricingSetting';
import { updateRoomStatus } from '@/services/room-config/updateRoomStatus';
import { useAvailabilityCenterStore } from '@/store/availability-center/store';
import { useLoadingStore } from '@/store/loading/store';
import { parse } from 'date-fns';
import { useState } from 'react';
import { toast } from 'sonner';
import { AvailabilityTable } from './common/AvailabilityTable';
import { updateRoomQuantity } from '@/services/room-config/updateRoomQuantity';
import { weekDays } from '@/lib/schemas/type-price/room-availability-setting';
import { updateRoomPrice } from '@/services/room-config/updateRoomPrice';

export interface IRoomPriceSetting {
	room_id: number;
	room_name: string;
	price_name: string;
	price_type_id: number;
	max_capacity: number;
	standard_index: number;
	price_max: number;
	price_min: number;
	price_standard: number;
	data: {
		capacity: number;
		price: number;
		status: 'active' | 'inactive';
	}[];
}

export interface IOnToggleSingleRoom {
	day: string;
	room_id: number;
	status: 'open' | 'close';
}

export interface IOnUpdateRoomQuantity {
	start_date: string;
	end_date: string;
	room_id: number;
	val: number;
}

export interface IOnUpdateRoomPrice {
	start_date: string;
	end_date: string;
	room_id: number;
	price_id: number;
	val: number;
}

const Availability = () => {
	const setLoading = useLoadingStore((state) => state.setLoading);
	const fetchListConfig = useAvailabilityCenterStore(
		(state) => state.fetchListConfig
	);
	const [dialog, setDialog] = useState<IRoomPriceSetting | undefined>(
		undefined
	);

	const onToggleSingleRoom = ({
		day,
		room_id,
		status,
	}: IOnToggleSingleRoom) => {
		const parsedDay = parse(day, 'yyyy-MM-dd', new Date());
		setLoading(true);
		const dayOfWeek = parsedDay.getDay() === 0 ? 7 : parsedDay.getDay();
		updateRoomStatus({
			start_date: day,
			end_date: day,
			room_ids: [room_id],
			day_of_week: {
				[dayOfWeek]: status,
			},
		})
			.then(async (res) => {
				if (res.status) {
					await fetchListConfig();
					toast.success('Thiết lập đóng/mở phòng nhanh thành công!');
				} else {
					toast.error(res.message);
				}
			})
			.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
			.finally(() => setLoading(false));
	};

	const onUpdateRoomQuantity = async ({
		start_date,
		end_date,
		room_id,
		val,
	}: IOnUpdateRoomQuantity) => {
		setLoading(true);
		updateRoomQuantity({
			start_date,
			end_date,
			room_ids: [room_id],
			day_of_week: Object.fromEntries(weekDays.map((day) => [day, val])),
		})
			.then(async (res) => {
				if (res.status) {
					await fetchListConfig();
					toast.success('Thiết lập phòng trống thành công!');
					return Promise.resolve();
				} else {
					toast.error(res.message);
					return Promise.reject();
				}
			})
			.catch(() => {
				return Promise.reject();
			})
			.finally(() => setLoading(false));
	};

	const onUpdateRoomPrice = async ({
		start_date,
		end_date,
		room_id,
		price_id,
		val,
	}: IOnUpdateRoomPrice) => {
		setLoading(true);
		updateRoomPrice({
			start_date,
			end_date,
			is_overwrite: true,
			room_ids: [room_id],
			price_type: [price_id],
			day_of_week: Object.fromEntries(weekDays.map((day) => [day, val])),
		})
			.then(async (res) => {
				if (res.status) {
					await fetchListConfig();
					toast.success('Thiết lập giá phòng thành công!');
				} else {
					toast.error(res.message);
				}
			})
			.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
			.finally(() => setLoading(false));
	};

	return (
		<>
			<AvailabilityTable
				onEditOccupancy={(data) => setDialog(data)}
				onToggleSingleRoom={onToggleSingleRoom}
				onUpdateRoomQuantity={onUpdateRoomQuantity}
				onUpdateRoomPrice={onUpdateRoomPrice}
			/>
			<DialogPricingSetting
				open={!!dialog}
				onClose={() => setDialog(undefined)}
				priceSetting={dialog}
			/>
		</>
	);
};

export default Availability;
