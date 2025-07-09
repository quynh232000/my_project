import React from 'react';
import { Separator } from '@/components/ui/separator';
import Typography from '@/components/shared/Typography';
import { cancelPolicy, roomOccupancyInfo } from '@/containers/booking-orders/data';
import { CancellationTimeline } from '@/containers/policy/refund-and-cancellation-policy/commons/CancellationTimeline';
import Link from 'next/link';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { cn } from '@/lib/utils';

const RoomAndOccupancyInfo = () => {
	return (
		<div>
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Loại phòng
				</Typography>
				<div className={'col-span-2'}>
					{roomOccupancyInfo.roomType.map((room, index) => (
						<div key={index}>
							<Typography
								tag="span"
								variant="caption_14px_400"
								className="text-neutral-600">
								{room.count} x{' '}
							</Typography>
							<Typography
								tag="span"
								variant="caption_14px_400"
								className="text-neutral-600">
								{room.nameRoom}
							</Typography>
						</div>
					))}
				</div>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Lợi ích
				</Typography>
				<Typography
					tag="span"
					variant="caption_14px_400"
					className={'col-span-2 text-neutral-600'}>
					{roomOccupancyInfo.benefits.join(', ')}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Số đêm lưu trú
				</Typography>
				<Typography
					tag="span"
					variant="caption_14px_400"
					className={'col-span-2 text-neutral-600'}>
					{roomOccupancyInfo.numberOfNights}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Người lớn
				</Typography>
				<Typography
					tag="span"
					variant="caption_14px_400"
					className={'col-span-2 text-neutral-600'}>
					{roomOccupancyInfo.adults}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Trẻ em
				</Typography>
				<Typography
					tag="span"
					variant="caption_14px_400"
					className={'col-span-2 text-neutral-600'}>
					{roomOccupancyInfo.children}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Giường phụ
				</Typography>
				<Typography
					tag="span"
					variant="caption_14px_400"
					className={'col-span-2 text-neutral-600'}>
					{roomOccupancyInfo.extraBed}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Yêu cầu đặc biệt
				</Typography>
				<Typography
					tag="span"
					variant="caption_14px_400"
					className={'col-span-2 text-neutral-600'}>
					{roomOccupancyInfo.specialRequest}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Khuyến mãi
				</Typography>
				{roomOccupancyInfo.promotion ?
					<div className={"flex items-center justify-between col-span-2"}>
						<Typography
							tag="span"
							variant="caption_14px_400"
							className={'text-neutral-600'}>
							{roomOccupancyInfo.promotion}
						</Typography>
						<Link href={"/"} className={cn(TextVariants.caption_12px_500, "text-secondary-500")}>Chi tiết khuyến mãi</Link>
					</div> : <Typography
						tag="span"
						variant="caption_14px_400"
						className={'col-span-2 text-neutral-600'}>
						Đơn đặt phòng này không có chương trình khuyến mại
					</Typography>
				}
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Loại giá
				</Typography>
				<Typography
					tag="span"
					variant="caption_14px_400"
					className={'col-span-2 text-neutral-600'}>
					{roomOccupancyInfo.rateType}
				</Typography>
			</div>
			<Separator orientation={'horizontal'} className={'my-2'} />
			<div className="grid grid-cols-3 gap-4">
				<Typography
					tag="span"
					variant="caption_14px_400"
					className="col-span-1 text-neutral-600">
					Chính sách hủy
				</Typography>
				<div className={'col-span-2'}>
					<Typography
						tag={'span'}
						variant={'caption_14px_400'}
						className={'mb-2 text-neutral-600'}>
						Chính sách hoàn hủy chung
					</Typography>
					<CancellationTimeline policyRow={cancelPolicy} cancelable={true} />
				</div>
			</div>
		</div>
	);
};

export default RoomAndOccupancyInfo;
