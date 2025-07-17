import React, { useMemo, useState } from 'react';
import {
	Dialog,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import { TBookingOrder } from '@/containers/booking-orders/data';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { IconClose, IconDownload } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import BookingGuestAndDateDetails from '@/containers/booking-orders/common/BookingGuestAndDateDetails';
import RoomAndOccupancyInfo from '@/containers/booking-orders/common/RoomAndOccupancyInfo';
import PaymentAndDisbursement from '@/containers/booking-orders/common/PaymentAndDisbursement';
import IconPrinter from '@/assets/Icons/outline/IconPrinter';

const BookingOrderDialog = ({
	openDialog,
	handleOpenDialog,
	onClose,
	orderDetails,
}: {
	openDialog: boolean;
	handleOpenDialog: () => void;
	onClose: () => void;
	orderDetails: (TBookingOrder & { id: number }) | undefined;
}) => {
	const [selectedIndex, setSelectedIndex] = useState<number>(0);
	const updateTab = (index: number) => {
		setSelectedIndex(index);
	};

	const tabs = useMemo(
		() => [
			{
				title: 'Chi tiết khách và ngày',
				key: 'customer_date_detail',
				component: (
					<BookingGuestAndDateDetails
						orderDetails={
							orderDetails
						}></BookingGuestAndDateDetails>
				),
			},
			{
				title: 'Phòng và số khách lưu trú',
				key: 'room_occupancy_info',
				component: <RoomAndOccupancyInfo></RoomAndOccupancyInfo>,
			},
			{
				title: 'Nhận tiền xuất chi',
				key: 'payment_disbursement',
				component: <PaymentAndDisbursement></PaymentAndDisbursement>,
			},
		],
		[orderDetails]
	);

	return (
		<Dialog open={openDialog} onOpenChange={() => handleOpenDialog()}>
			<DialogContent
				onPointerDownOutside={() => onClose()}
				hideButtonClose={true}
				className={
					'max-h-[90vh] gap-0 overflow-hidden rounded-2xl p-0 sm:max-w-[888px]'
				}>
				<DialogHeader className={'hidden'}>
					<DialogTitle></DialogTitle>
					<DialogDescription></DialogDescription>
				</DialogHeader>
				<div
					className={
						'bg-gradient-to-r from-[#254CCA] to-secondary-500 p-6'
					}>
					<div className={'mb-4 flex items-center justify-between'}>
						<Typography
							tag={'h3'}
							variant={'caption_18px_700'}
							className={'text-white'}>
							Chi tiết đặt phòng: #{orderDetails?.id}
						</Typography>
						<Button
							type={'button'}
							onClick={() => onClose()}
							className={
								'flex h-8 w-8 min-w-fit items-center justify-center rounded-full bg-neutral-50 p-2'
							}>
							<IconClose
								width={20}
								height={20}
								color={GlobalUI.colors.neutrals['500']}
							/>
						</Button>
					</div>
					<div className={'flex items-center gap-3'}>
						<Button
							className={cn(
								'h-8 min-w-fit rounded-lg bg-white px-3 py-1 text-neutral-600 hover:opacity-80',
								TextVariants.caption_14px_600
							)}>
							<IconDownload
								color={GlobalUI.colors.neutrals['600']}
								className={'size-4'}
							/>
							Tải hóa đơn điện tử
						</Button>
						<Button
							className={cn(
								'h-8 min-w-fit rounded-lg bg-white px-3 py-1 text-neutral-600 hover:opacity-80',
								TextVariants.caption_14px_600
							)}>
							<IconPrinter className={'size-4'} />
							In
						</Button>
					</div>
				</div>
				<div className={'p-6'}>
					<div
						className={
							'mb-4 grid grid-cols-3 gap-1 rounded-[6px] bg-neutral-100 p-1'
						}>
						{tabs.map((tab, i) => (
							<Button
								key={i}
								className={cn(
									'h-6 min-w-fit rounded px-4 hover:bg-neutral-100',
									TextVariants.caption_14px_600,
									selectedIndex === i
										? 'bg-white text-neutral-600'
										: 'bg-neutral-100 text-neutral-300'
								)}
								onClick={() => updateTab(i)}>
								{tab.title}
							</Button>
						))}
					</div>
					{tabs[selectedIndex].component}
				</div>
			</DialogContent>
		</Dialog>
	);
};

export default BookingOrderDialog;
