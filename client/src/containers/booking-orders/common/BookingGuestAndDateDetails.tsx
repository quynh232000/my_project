import React from 'react';
import { TBookingOrder } from '@/containers/booking-orders/data';
import Typography from '@/components/shared/Typography';
import { Separator } from '@/components/ui/separator';

const renderStatus = (status: string) => {
	switch (status) {
		case 'active':
			return (
				<Typography
					tag={'span'}
					variant={'caption_14px_400'}
					className={'rounded-lg bg-green-50 px-4 py-1 text-accent-02'}>
					Đã xác nhận
				</Typography>
			);
		case 'inactive':
			return (
				<Typography
					tag={'span'}
					variant={'caption_14px_400'}
					className={'rounded-lg bg-red-50 px-4 py-1 text-accent-03'}>
					Đã hủy
				</Typography>
			);
		case 'pending':
			return (
				<Typography
					tag={'span'}
					variant={'caption_14px_400'}
					className={'bg-orange-50-50 rounded-lg px-4 py-1 text-accent-04'}>
					Chờ xác nhận
				</Typography>
			);
	}
};
const maskStringStart = (str: string, length: number) => {
	const masked = '*'.repeat(Math.min(length, str.length));
	const visible = str.substring(length);

	return (
		<Typography tag={'p'} variant={'caption_14px_400'}>
			<span className={'font-mono'}>{masked}</span>
			{visible}
		</Typography>
	);
};

const BookingGuestAndDateDetails = ({
	orderDetails,
}: {
	orderDetails: TBookingOrder | undefined;
}) => {
	return (
		<div className={'text-neutral-600'}>
			<div className={'flex items-center gap-4'}>
				<Typography tag={'p'} variant={'caption_14px_400'} className={'w-60'}>
					Mã đặt phòng
				</Typography>
				<Typography tag={'p'} variant={'caption_14px_400'}>
					{orderDetails?.id}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className={'flex items-center gap-4'}>
				<Typography tag={'p'} variant={'caption_14px_400'} className={'w-60'}>
					Trạng thái đơn
				</Typography>
				{orderDetails && renderStatus(orderDetails?.status)}
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className={'flex items-center gap-4'}>
				<Typography tag={'p'} variant={'caption_14px_400'} className={'w-60'}>
					Tên khách
				</Typography>
				<Typography tag={'p'} variant={'caption_14px_400'}>
					{orderDetails?.name}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className={'flex items-center gap-4'}>
				<Typography tag={'p'} variant={'caption_14px_400'} className={'w-60'}>
					Email
				</Typography>
				{maskStringStart(orderDetails?.email || '', 4)}
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className={'flex items-center gap-4'}>
				<Typography tag={'p'} variant={'caption_14px_400'} className={'w-60'}>
					Số điện thoại
				</Typography>
				{maskStringStart(
					orderDetails?.phone || '',
					orderDetails ? orderDetails.phone.length - 3 : 7
				)}
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className={'flex items-center gap-4'}>
				<Typography tag={'p'} variant={'caption_14px_400'} className={'w-60'}>
					Ngày ở
				</Typography>
				<Typography tag={'p'} variant={'caption_14px_400'}>
					{orderDetails?.date.from.toLocaleDateString('vi-vn')} -{' '}
					{orderDetails?.date.to.toLocaleDateString('vi-vn')}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className={'flex items-center gap-4'}>
				<Typography tag={'p'} variant={'caption_14px_400'} className={'w-60'}>
					Thời gian đặt phòng
				</Typography>
				<Typography tag={'p'} variant={'caption_14px_400'}>
					{orderDetails?.time_order}
				</Typography>
			</div>
		</div>
	);
};

export default BookingGuestAndDateDetails;
