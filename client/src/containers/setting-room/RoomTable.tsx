'use client';
import DashboardTable, {
	renderStatus,
} from '@/components/shared/DashboardTable';
import Typography from '@/components/shared/Typography';
import { DashboardRouter } from '@/constants/routers';
import { filterData } from '@/containers/setting-room/data';
import { toggleRoomStatus } from '@/services/room-config/toggleRoomStatus';
import { ERoomStatus, IRoomItem } from '@/services/room/getRoomList';
import { useLoadingStore } from '@/store/loading/store';
import { initialState, useRoomDetailStore } from '@/store/room-detail/store';
import { useRoomStore } from '@/store/room/store';
import { startHolyLoader } from 'holy-loader';
import { useRouter } from 'next/navigation';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

export default function RoomTable() {
	const router = useRouter();
	const [room, setRoomList] = useState<IRoomItem[]>([]);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const setRoomDetailState = useRoomDetailStore(
		(state) => state.setRoomDetailState
	);
	const {
		roomList,
		setRoomList: setRoomListStore,
		fetchRoomList,
	} = useRoomStore(
		useShallow((state) => ({
			roomList: state.roomList,
			fetchRoomList: state.fetchRoomList,
			setRoomList: state.setRoomList,
		}))
	);
	useEffect(() => {
		setLoading(true);
		fetchRoomList().finally(() => setLoading(false));
	}, []);
	useEffect(() => {
		if (roomList && roomList.length > 0) {
			setRoomList(
				roomList
					.sort((a, b) => b.id - a.id)
					.map((item) => ({
						...item,
						max_capacity: item.max_capacity
							? item.max_capacity
							: item.max_extra_adults + item.max_extra_children,
					}))
			);
		}
	}, [roomList]);

	const onToggleStatus = (room: IRoomItem) => {
		setLoading(true);
		const status =
			room.status === ERoomStatus.active
				? ERoomStatus.inactive
				: ERoomStatus.active;
		toggleRoomStatus({
			status,
			room_ids: [room.id],
		})
			.then((res) => {
				if (res.status) {
					toast.success('Cập nhật trạng thái phòng thành công');
					setRoomListStore(
						roomList?.map((r) => ({
							...r,
							status: r.id === room.id ? status : r.status,
						})) ?? []
					);
				} else {
					toast.error('Có lỗi xảy ra, vui lòng thử lại!');
				}
			})
			.catch(() => {
				toast.error('Có lỗi xảy ra, vui lòng thử lại!');
			})
			.finally(() => setLoading(false));
	};

	return (
		<DashboardTable<IRoomItem>
			searchPlaceholder={'Tìm kiếm theo tên/mã phòng'}
			filterPlaceholder={'Trạng thái'}
			addButtonText={'Thêm phòng mới'}
			handleAdd={() => {
				router.push(DashboardRouter.roomCreate);
				setRoomDetailState(initialState.roomDetail);
			}}
			filterData={filterData}
			checkboxSelection={true}
			fieldSearch={['id', 'name']}
			columns={[
				{
					label: 'Mã phòng',
					field: 'id',
					sortable: true,
					style: { width: '127px' },
				},
				{ label: 'Tên phòng', field: 'name', sortable: true },
				{
					label: 'Sức chứa',
					field: 'max_capacity',
					sortable: true,
					renderCell: (cell) => {
						return (
							<Typography
								tag={'p'}
								variant={'caption_14px_400'}
								className={'text-neutral-600'}>
								{String(cell)} người
							</Typography>
						);
					},
				},
				{
					label: 'Kích thước',
					field: 'area',
					sortable: true,
					renderCell: (cell) => {
						return (
							<Typography
								tag={'p'}
								variant={'caption_14px_400'}
								className={'text-neutral-600'}>
								{String(cell)}m<sup>2</sup>
							</Typography>
						);
					},
				},
				{ label: 'Số lượng', field: 'quantity', sortable: true },
				{
					label: 'Trạng thái',
					field: 'status',
					renderCell: (status, row) =>
						renderStatus(status, row, {
							onToggleStatus: () => onToggleStatus(row),
						}),
					sortable: true,
				},
			]}
			rows={room}
			action={{
				name: 'Thiết lập',
				type: 'edit',
				handle: [
					(room) => {
						startHolyLoader();
						setLoading(true);
						router.push(`${DashboardRouter.room}/${room.id}?tab=general`);
					},
				],
			}}
		/>
	);
}
