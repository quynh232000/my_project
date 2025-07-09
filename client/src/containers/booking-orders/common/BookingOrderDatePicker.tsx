'use client';
import IconChevron from '@/assets/Icons/outline/IconChevron';
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import React, { useEffect, useMemo, useRef, useState } from 'react';
import { ControllerRenderProps } from 'react-hook-form';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { GlobalUI } from '@/themes/type';
import { Button } from '@/components/ui/button';
import PresetTimeSelector from '@/containers/booking-orders/common/PresetTimeSelector';
import CustomDateTimePicker from '@/containers/booking-orders/common/CustomDateTimePicker';
import { addDays } from 'date-fns';

interface SelectCheckboxProps {
	onChange?: (value: string | number) => void;
	className?: string;
	containerClassName?: string;
	classItemList?: string;
	placeholder?: string;
	controllerRenderProps?: Omit<ControllerRenderProps, 'onChange' | 'value'>;
	containerWidthDefault?: number;
}

const BookingOrderDatePicker = ({
	controllerRenderProps,
	...props
}: SelectCheckboxProps) => {
	const [open, setOpen] = useState(false);
	const [containerWidth, setContainerWidth] = useState(
		props.containerWidthDefault ?? 0
	);
	const containerRef = useRef<HTMLDivElement>(null);
	const [selectedIndex, setSelectedIndex] = useState<number>(0);
	const [date, setDate] = useState<{
		from: Date | undefined;
		to: Date | undefined;
	}>({
		from: new Date(),
		to: addDays(new Date(), 7),
	});

	const tabs = useMemo(
		() => [
			{
				title: 'Mốc thời gian',
				key: 'time',
				component: <PresetTimeSelector
				></PresetTimeSelector>,
			},
			{
				title: 'Lựa chọn khác',
				key: 'date_picker',
				component: <CustomDateTimePicker
					handleSearch={() => setOpen(false)}
					showSummaryAndSearch={true}
					dateRange={{
						from: date.from,
						to: date.to,
					}}
					onSelectDateRange={(value) => {
						if (value)
							setDate({
								from: value.from,
								to: value.to,
							});
					}}
				></CustomDateTimePicker>,
			},
		],
		[date]
	);
	const updateTab = (index: number) => {
		setSelectedIndex(index);
	};
	useEffect(() => {
		if (containerRef.current && containerWidth === 0) {
			setContainerWidth(containerRef.current.offsetWidth);
		}
	}, [containerRef.current]);

	return (
		<Popover open={open} onOpenChange={setOpen}>
			<div
				className={cn(
					'whitespace-normal break-words',
					props.containerClassName
				)}>
				<PopoverTrigger className="w-full">
					<div
						ref={containerRef}
						className={cn(
							'flex h-8 items-center justify-between gap-2 rounded-lg border-[1.5px] px-3 py-1 text-center text-neutral-600',
							open && 'border-secondary-200',
							props.className,
							TextVariants.caption_14px_400
						)}>
						Thời gian đặt
						<div
							className={`transition-transform ${open ? 'rotate-180' : 'rotate-0'}`}>
							<IconChevron
								direction={'down'}
								width={16}
								height={16}
								color={GlobalUI.colors.neutrals['400']}
							/>
						</div>
						{controllerRenderProps && (
							<input
								className={'h-0 w-0 overflow-hidden'}
								title={controllerRenderProps.name}
								placeholder={controllerRenderProps.name}
								{...controllerRenderProps}
							/>
						)}
					</div>
				</PopoverTrigger>
				<PopoverContent
					style={{ minWidth: `${containerWidth}px` }}
					align={'start'}
					side={'bottom'}
					className={cn(
						'overflow-hidden rounded-lg border-stroke-subtle px-6 py-4 shadow-[0px_24px_24px_-16px_rgba(15,15,15,0.20)]'
					)}>
					<div
						className={
							'mb-2 inline-flex items-center gap-1 rounded-[6px] bg-neutral-100 p-1'
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
				</PopoverContent>
			</div>
		</Popover>
	);
};
BookingOrderDatePicker.displayName = 'BookingOrderDatePicker';
export default BookingOrderDatePicker;
