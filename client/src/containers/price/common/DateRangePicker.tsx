import { format } from 'date-fns';
import * as React from 'react';
import { useState } from 'react';
import { DateRange, DayPickerRangeProps } from 'react-day-picker';
import IconCalendarAll from '@/assets/Icons/outline/IconCalendarAll';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Button } from '@/components/ui/button';
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import CustomDateTimePicker from '@/containers/booking-orders/common/CustomDateTimePicker';

interface DateRangePickerProps extends Omit<DayPickerRangeProps, 'mode'> {
	dateRange: DateRange | undefined;
	onSelectDateRange: (dateRange: DateRange | undefined) => void;
	labelClassName?: string;
	handleSearch?: () => void;
	showSummaryAndSearch?: boolean;
}

export function DateRangePicker({
	labelClassName,
	className,
	dateRange,
	onSelectDateRange,
	showSummaryAndSearch = false,
	handleSearch,
	...props
}: DateRangePickerProps) {
	const [open, setOpen] = useState(false);

	return (
		<div className={cn('col-span-12 grid gap-2 lg:col-span-1', className)}>
			<Popover open={open} onOpenChange={setOpen}>
				<PopoverTrigger
					asChild
					className={cn(
						`!bg-white ${open && '!border-secondary-200'}`
					)}>
					<Button
						id="date"
						className={cn(
							'h-10 justify-start rounded-lg border-2 border-other-divider-02 px-3 text-left font-normal [&_svg]:size-[14px]',
							!dateRange && 'text-muted-foreground',
							labelClassName
						)}>
						{dateRange?.from ? (
							<div className={'flex w-full items-center'}>
								<div
									className={cn(
										TextVariants.caption_14px_400,
										'flex-1 text-neutral-600'
									)}>
									{format(dateRange.from, 'dd/MM/yyyy')}
									{dateRange.to &&
										' - ' +
											format(dateRange.to, 'dd/MM/yyyy')}
								</div>
							</div>
						) : (
							<span className={'text-neutral-400'}>
								Chọn khoảng ngày
							</span>
						)}
						<IconCalendarAll
							className={'ml-auto !h-5 !w-5 text-neutral-400'}
						/>
					</Button>
				</PopoverTrigger>
				<PopoverContent
					className="w-auto p-4"
					align="start"
					side={'bottom'}>
					<CustomDateTimePicker
						dateRange={dateRange}
						onSelectDateRange={onSelectDateRange}
						showSummaryAndSearch={showSummaryAndSearch}
						onClose={() => setOpen(false)}
						{...(handleSearch && {
							handleSearch: () => {
								handleSearch();
								setOpen(false);
							},
						})}
						{...props}
					/>
				</PopoverContent>
			</Popover>
		</div>
	);
}
