'use client';
import DashboardTable, {
	ColumnDef,
	renderStatus,
} from '@/components/shared/DashboardTable';
import Typography from '@/components/shared/Typography';
import { DashboardRouter } from '@/constants/routers';
import { filterData } from '@/containers/setting-room/data';
import { toggleRoomStatus } from '@/services/room-config/toggleRoomStatus';
import { ERoomStatus, IRoomItem } from '@/services/room/getRoomList';
import { useLoadingStore } from '@/store/loading/store';
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

	const {
		roomList,
		setRoomList: setRoomListStore,
		fetchRoomList,
		allColumns,
		setAllColumns,
		visibleFields,
	} = useRoomStore(
		useShallow((state) => ({
			roomList: state.roomList,
			fetchRoomList: state.fetchRoomList,
			setRoomList: state.setRoomList,
			allColumns: state.allColumns,
			setAllColumns: state.setAllColumns,
			visibleFields: state.visibleFields,
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

	useEffect(() => {
		const columns: ColumnDef<IRoomItem>[] = [
			{
				label: 'Mã phòng',
				field: 'id',
				sortable: true,
				style: { width: '127px' },
			},
			{
				label: 'Tên phòng',
				field: 'name',
				sortable: true,
			},
			{
				label: 'Sức chứa',
				field: 'max_capacity',
				sortable: true,
				renderCell: (_, row) => (
					<Typography
						tag={'p'}
						variant={'caption_14px_400'}
						className={'text-neutral-600'}>
						{row.max_extra_adults > 0
							? `${String(row.max_extra_adults)} người lớn, `
							: ''}
						{row.max_extra_children > 0
							? `${String(row.max_extra_children)} trẻ em`
							: ''}
					</Typography>
				),
			},
			{
				label: 'Kích thước',
				field: 'area',
				sortable: true,
				renderCell: (cell) => (
					<Typography
						tag={'p'}
						variant={'caption_14px_400'}
						className={'text-neutral-600'}>
						{String(cell)}m<sup>2</sup>
					</Typography>
				),
			},
			{
				label: 'Số lượng',
				field: 'quantity',
				sortable: true,
			},
			{
				label: 'Trạng thái',
				field: 'status',
				renderCell: (status, row) =>
					renderStatus(status, row, {
						onToggleStatus: () => onToggleStatus(row),
					}),
				sortable: true,
			},
		];

		const filteredColumns = columns.filter(
			(col): col is ColumnDef<IRoomItem> & { field: keyof IRoomItem } =>
				!!col.field && visibleFields.includes(col.field)
		);

		setAllColumns(filteredColumns);
	}, [visibleFields, room]);

	// const handleChangeStatus = (status: ERoomStatus, room_ids: number[]) => {
	// 	if(room_ids.length === roomList?.length && roomList.every(room => room.status === status)) {
	// 		toast.success('Cập nhật trạng thái phòng thành công');
	// 	}else{
	// 		setLoading(true);
	// 		toggleRoomStatus({
	// 			status,
	// 			room_ids,
	// 		})
	// 			.then((res) => {
	// 				if (res.status) {
	// 					toast.success('Cập nhật trạng thái phòng thành công');
	// 					setRoomListStore(
	// 						roomList?.map((r) => (room_ids.includes(r.id) ?{
	// 							...r,
	// 							status,
	// 						} : r)) ?? []
	// 					);
	// 				} else {
	// 					toast.error('Có lỗi xảy ra, vui lòng thử lại!');
	// 				}
	// 			})
	// 			.catch(() => {
	// 				toast.error('Có lỗi xảy ra, vui lòng thử lại!');
	// 			})
	// 			.finally(() => setLoading(false));
	// 	}
	// }

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
			filterData={filterData}
			checkboxSelection={true}
			// handleChangeStatus={handleChangeStatus}
			fieldSearch={['id', 'name']}
			columns={allColumns}
			rows={room}
			action={{
				name: 'Thiết lập',
				type: 'edit',
				handle: [
					(room) => {
						startHolyLoader();
						setLoading(true);
						router.push(
							`${DashboardRouter.room}/${room.id}?tab=general`
						);
					},
				],
			}}
		/>
	);
}
