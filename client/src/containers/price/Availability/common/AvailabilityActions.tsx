'use client';
import React, { useEffect } from 'react';
import { Button } from '@/components/ui/button';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { cn } from '@/lib/utils';
import RoomAvailabilitySettings from '@/containers/price/Availability/common/RoomAvailabilitySettings';
import RoomPricingSettings from '@/containers/price/Availability/common/RoomPricingSettings';
import QuickRoomToggle from '@/containers/price/Availability/common/QuickRoomToggle';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomStore } from '@/store/room/store';
import { usePricesStore } from '@/store/prices/store';

const AvailabilityActions = () => {
	const setLoading = useLoadingStore((state) => state.setLoading);
	const fetchRoomList = useRoomStore((state) => state.fetchRoomList);
	const fetchPrices = usePricesStore((state) => state.fetchPrices);

	const [isRoomAvailabilityOpen, setIsRoomAvailabilityOpen] =
		React.useState(false);
	const [isRoomPricingOpen, setIsRoomPricingOpen] = React.useState(false);
	const [isQuickRoomToggleOpen, setIsQuickRoomToggleOpen] =
		React.useState(false);

	useEffect(() => {
		setLoading(true);
		Promise.all([fetchPrices(), fetchRoomList()]).finally(() =>
			setLoading(false)
		);
	}, []);

	return (
		<div>
			<div className={'flex flex-wrap items-center gap-2 lg:flex-nowrap'}>
				<Button
					onClick={() => setIsRoomAvailabilityOpen(true)}
					className={cn(
						'h-8 w-[47%] rounded-lg bg-secondary-500 px-4 py-1 text-white hover:bg-secondary-500/80 lg:w-auto',
						TextVariants.caption_14px_600
					)}>
					Thiết lập phòng trống
				</Button>
				<Button
					onClick={() => setIsRoomPricingOpen(true)}
					className={cn(
						'h-8 w-[47%] rounded-lg bg-accent-02 px-4 py-1 text-white hover:bg-accent-02/80 lg:w-auto',
						TextVariants.caption_14px_600
					)}>
					Thiết lập giá
				</Button>
				<Button
					onClick={() => setIsQuickRoomToggleOpen(true)}
					className={cn(
						'h-8 w-[47%] rounded-lg bg-accent-05 px-4 py-1 text-white hover:bg-accent-05/80 lg:w-auto',
						TextVariants.caption_14px_600
					)}>
					Đóng/mở phòng nhanh
				</Button>
			</div>
			<RoomAvailabilitySettings
				open={isRoomAvailabilityOpen}
				onClose={() => setIsRoomAvailabilityOpen(false)}
			/>
			<RoomPricingSettings
				open={isRoomPricingOpen}
				onClose={() => setIsRoomPricingOpen(false)}
			/>
			<QuickRoomToggle
				open={isQuickRoomToggleOpen}
				onClose={() => setIsQuickRoomToggleOpen(false)}
			/>
		</div>
	);
};

export default AvailabilityActions;
