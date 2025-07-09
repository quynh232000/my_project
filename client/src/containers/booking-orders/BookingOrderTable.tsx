'use client';
import React, { useState } from 'react';
import DashboardTable, {
	renderStatus,
	TCellType,
} from '@/components/shared/DashboardTable';
import Typography from '@/components/shared/Typography';
import { filterData } from '@/containers/setting-room/data';

import {
	bookingOrderList,
	TBookingOrder,
} from '@/containers/booking-orders/data';
import FilterContent from '@/containers/booking-orders/common/FilterContent';
import BookingOrderDialog from '@/containers/booking-orders/common/BookingOrderDialog';

export const renderRoomGuests = (roomGuests: TCellType, row: TBookingOrder) => {
	const data = roomGuests as TBookingOrder['room_guests'];

	return (
		<>
			<Typography
				tag={'p'}
				variant={'caption_14px_400'}
				text={data}
				className={'text-neutral-600'}
			/>
			<Typography
				tag={'p'}
				variant={'caption_12px_500'}
				text={`${row.max_extra_adults} người lớn, ${row.max_extra_children} trẻ em`}
				className={'border-neutral-400 text-neutral-400'}
			/>
		</>
	);
};

const renderDateOrder = (date: TCellType) => {
	const data = date as TBookingOrder['date'];
	return (
		<>
			<Typography
				tag={'p'}
				variant={'caption_14px_400'}
				className={'text-neutral-600'}>
				{data.from.toLocaleDateString('vi-vn')} -{' '}
				{data.to.toLocaleDateString('vi-vn')}
			</Typography>
			<Typography
				tag={'p'}
				variant={'caption_12px_500'}
				className={'text-neutral-400'}>
				{Math.ceil(
					(data.to.getTime() - data.from.getTime()) / (1000 * 60 * 60 * 24)
				)}{' '}
				đêm
			</Typography>
		</>
	);
};

const BookingOrderTable = () => {
	const [openDialog, setOpenDialog] = useState<boolean>(false);
	const [orderDetails, setOrderDetails] = useState<
		(TBookingOrder & { id: number }) | undefined
	>(undefined);
	return (
		<>
			<FilterContent />
			<DashboardTable<TBookingOrder & { id: number }>
				showSearchComponent={false}
				searchInputClassName={'border-[1.5px]'}
				searchContainerClassName={'md:gap-4 grid grid-cols-5'}
				tableClassName={''}
				searchPlaceholder={'Mã đặt phòng/Tên khách'}
				filterPlaceholder={'Trạng thái'}
				fieldSearch={['id', 'name']}
				filterData={filterData}
				columns={[
					{ label: 'Mã đặt phòng', field: 'id', sortable: true },
					{ label: 'Thời gian đặt', field: 'time_order' },
					{ label: 'Tên khách', field: 'name', sortable: true },
					{
						label: 'Ngày ở',
						field: 'date',
						sortable: true,
						renderCell: renderDateOrder,
					},
					{
						label: 'Phòng & số người ở',
						field: 'room_guests',
						sortable: true,
						renderCell: renderRoomGuests,
					},
					{ label: 'Tổng giá bán', field: 'total_price' },
					{
						label: 'Trạng thái',
						field: 'status',
						renderCell: (status, row) =>
							renderStatus(status, row, {
								statusesPalete: {
									active: {
										label: 'Đã xác nhận',
										backgroundColor: 'bg-green-50',
										color: 'text-green-500',
									},
									inactive: {
										label: 'Đã huỷ bỏ',
										backgroundColor: 'bg-red-50',
										color: 'text-red-500',
									},
									pending: {
										label: 'Chờ xác nhận',
										backgroundColor: 'bg-[#FFF6D3]',
										color: 'text-alert-warning-dark',
									},
								},
							}),
						sortable: true,
					},
				]}
				rows={
					(bookingOrderList as Array<
						Omit<TBookingOrder, 'id'> & { id: number }
					>) ?? []
				}
				action={{
					name: 'Thiết lập',
					type: 'edit',
					handle: [
						(row) => {
							setOpenDialog(true);
							setOrderDetails(row);
						},
					],
				}}
			/>

			<BookingOrderDialog
				orderDetails={orderDetails}
				openDialog={openDialog}
				handleOpenDialog={() => setOpenDialog(!openDialog)}
				onClose={() => {
					setOpenDialog(false);
					setOrderDetails(undefined);
				}}
			/>
		</>
	);
};

export default BookingOrderTable;
