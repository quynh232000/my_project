'use client';

import * as React from 'react';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { DayPicker } from 'react-day-picker';
import { cn } from '@/lib/utils';
import { buttonVariants } from '@/components/ui/button';
import { vi } from 'date-fns/locale';
import { TextVariants } from '@/components/shared/Typography/TextVariants';

export type CalendarProps = React.ComponentProps<typeof DayPicker>;

function Calendar({
	className,
	classNames,
	showOutsideDays = true,
	...props
}: CalendarProps) {
	const LIST = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];
	return (
		<DayPicker
			locale={vi}
			showOutsideDays={showOutsideDays}
			formatters={{
				formatCaption: (month) =>
					`T${month.getMonth() + 1} ${month.getFullYear()}`,
			}}
			className={cn('', className)}
			classNames={{
				months: cn(
					'flex flex-col sm:flex-row sm:space-x-6 relative',
					props.numberOfMonths && props.numberOfMonths >= 2
						? 'after:content-[""] after:absolute after:top-9 after:bottom-4 after:left-1/2 after:w-px after:bg-neutral-200'
						: ''
				),
				month: 'space-y-4',
				caption: 'flex justify-center pt-1 relative items-center',
				caption_label: 'text-sm font-medium',
				nav: 'space-x-1 flex items-center',
				nav_button: cn(
					buttonVariants({ variant: 'outline' }),
					'h-7 w-7 min-w-min bg-transparent p-0 opacity-50 hover:opacity-100'
				),
				nav_button_previous: 'absolute left-1 border-none',
				nav_button_next: 'absolute right-1 border-none',
				table: 'w-full border-collapse space-y-1',
				head_row: 'flex',
				head_cell:
					'text-neutral-500 rounded-md w-9 font-normal text-[0.8rem]',
				row: 'flex w-full mt-2',
				cell: 'h-9 w-9 min-w-min text-center text-sm p-0 relative [&:has([aria-selected].day-range-end)]:rounded-r-md [&:has([aria-selected].day-outside)]:bg-neutral-100/50  first:[&:has([aria-selected])]:rounded-l-md last:[&:has([aria-selected])]:rounded-r-md focus-within:relative focus-within:z-20',
				day: cn(
					buttonVariants({ variant: 'ghost' }),
					'h-9 w-9 min-w-min p-0 font-normal aria-selected:opacity-100 rounded-full'
				),
				day_range_end: 'day-range-end',
				day_selected:
					'bg-primary-100 text-neutral-600 hover:bg-primary-100 hover:text-neutral-50 focus:bg-primary-100 focus:text-neutral-600 rounded-full',
				day_today: ' text-neutral-600',
				day_outside:
					'day-outside text-neutral-500 aria-selected:bg-neutral-100/50 aria-selected:text-neutral-500',
				day_disabled: 'text-neutral-500 opacity-50 rounded-none',
				day_range_middle:
					'aria-selected:bg-transparent aria-selected:text-neutral-900',
				day_hidden: 'invisible',
				...classNames,
			}}
			components={{
				IconLeft: ({ className, ...props }) => (
					<ChevronLeft
						className={cn('h-5 w-5', className)}
						{...props}
					/>
				),
				IconRight: ({ className, ...props }) => (
					<ChevronRight
						className={cn('h-5 w-5', className)}
						{...props}
					/>
				),
				Head: () => {
					return (
						<tbody>
							<tr className={'flex h-6 w-full items-center'}>
								{LIST.map((day, index) => (
									<td
										key={index}
										className={`flex h-6 w-6 flex-1 items-center justify-center text-neutral-400 ${TextVariants.caption_12px_500}`}>
										{day}
									</td>
								))}
							</tr>
						</tbody>
					);
				},
			}}
			{...props}
		/>
	);
}

Calendar.displayName = 'Calendar';

export { Calendar };
