'use client';
import React, { useEffect, useState } from 'react';
import { Calendar } from '@/components/ui/calendar';
import { isBefore } from 'date-fns';
import { DateRange, DayPickerRangeProps } from 'react-day-picker';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Button } from '@/components/ui/button';

interface DateRangePickerProps extends Omit<DayPickerRangeProps, 'mode'> {
	dateRange: DateRange | undefined;
	onSelectDateRange: (dateRange: DateRange | undefined) => void;
	labelClassName?: string;
	handleSearch?: () => void;
	showSummaryAndSearch?: boolean;
	onClose?: () => void;
}

const CustomDateTimePicker = ({
	dateRange,
	onSelectDateRange,
	showSummaryAndSearch = false,
	handleSearch,
	onClose,
	...props
}: DateRangePickerProps) => {
	const [target, setTarget] = useState<'from' | 'to'>('from');

	useEffect(() => {
		setTarget('from');
	}, []);
	const handleChange = (selectedDate: Date) => {
		if (!selectedDate) {
			return;
		}
		if (!dateRange?.from || target === 'from') {
			onSelectDateRange({ from: selectedDate, to: undefined });
			setTarget('to');
		} else {
			if (isBefore(selectedDate, dateRange?.from)) {
				onSelectDateRange({ from: selectedDate, to: dateRange?.from });
			} else onSelectDateRange({ from: dateRange?.from, to: selectedDate });
			!handleSearch &&  onClose?.()
			setTarget("from")
		}
	};
	return (
		<>
			<Calendar
				{...props}
				initialFocus
				mode="range"
				defaultMonth={dateRange?.from}
				selected={dateRange}
				onDayClick={handleChange}
				max={30 * 6}
				numberOfMonths={2}
				showOutsideDays={false}
			/>
			{showSummaryAndSearch  && (
				<div className={cn('mt-4 flex items-center justify-between')}>
					<div
						className={cn(
							'flex items-center gap-6 text-neutral-600',
							TextVariants.caption_12px_600
						)}>
						<span>
							Từ ngày:{' '}
							<span className={'text-secondary-500'}>
								{dateRange?.from?.toLocaleDateString('vi-VN') ||
									new Date().toLocaleDateString('vi-VN')}
							</span>
						</span>
						<span>
							Đến ngày:{' '}
							<span className={'text-secondary-500'}>
								{dateRange?.to?.toLocaleDateString('vi-VN') ||
									new Date().toLocaleDateString('vi-VN')}
							</span>
						</span>
					</div>
					{ handleSearch &&
						<Button
							variant={'secondary'}
							onClick={handleSearch}
							className={'min-w-fit px-3 py-1'}>
							Tìm kiếm
						</Button>
					}
				</div>
			)}
		</>
	);
};

export default CustomDateTimePicker;
