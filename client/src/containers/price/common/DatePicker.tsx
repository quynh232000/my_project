'use client';
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/components/ui/popover';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { Calendar } from '@/components/ui/calendar';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { useFormContext } from 'react-hook-form';
import { subDays } from 'date-fns/fp/subDays';
import { format } from 'date-fns/fp/format';
import IconCalendar from '@/assets/Icons/outline/IconCalendar';
import React, { useState } from 'react';
import IconChevron from '../../../assets/Icons/outline/IconChevron';
import { GlobalUI } from '@/themes/type';

interface Props {
	title: string;
	name: string;
	required?: boolean;
	align?: 'start' | 'center' | 'end';
	disabled?: boolean;
}

export const DatePicker = ({
	title,
	name,
	required,
	align = 'start',
	disabled = false,
}: Props) => {
	const [focusedMonth, setFocusedMonth] = useState(new Date().getMonth());
	const { control } = useFormContext();
	const [open, setOpen] = useState(false);
	return (
		<FormField
			control={control}
			name={name}
			render={({ field }) => (
				<FormItem className="flex w-full flex-col">
					<FormLabel
						required={required}
						className={cn(
							'text-base font-medium',
							disabled ? 'text-neutral-300' : 'text-neutral-500'
						)}>
						{title}
					</FormLabel>
					<Popover open={open} onOpenChange={setOpen}>
						<PopoverTrigger asChild disabled={disabled}>
							<FormControl>
								<Button
									variant={'outline'}
									className={cn(
										'h-10 w-full justify-start rounded-lg border-2 border-other-divider-02 pl-3 text-left text-[14px] font-normal text-neutral-600 hover:bg-transparent hover:text-black',
										!disabled && 'hover:border-blue-500',
										!field.value && '',
										disabled &&
											'cursor-not-allowed bg-neutral-50 text-neutral-300 hover:text-neutral-300'
									)}>
									<IconCalendar
										width={20}
										height={20}
										className="font-bold"
									/>
									<p>
										{field.value ? (
											format('dd/MM/yyyy', field.value)
										) : (
											<span>dd/mm/yyyy</span>
										)}
									</p>
									<div
										className={`ml-auto transition-transform ${open ? 'rotate-180' : 'rotate-0'} ml-auto`}>
										<IconChevron
											direction={'down'}
											width={14}
											height={14}
											color={
												GlobalUI.colors.neutrals['4']
											}
										/>
									</div>
								</Button>
							</FormControl>
						</PopoverTrigger>
						<PopoverContent
							className="w-auto rounded-lg border bg-white p-4 shadow-md"
							align={align}
							side={'bottom'}
							avoidCollisions={true}>
							<Calendar
								mode="single"
								selected={field.value}
								onSelect={(date) => {
									if (date) {
										field.onChange(date);
										setOpen(false);
									}
								}}
								onMonthChange={(date) =>
									setFocusedMonth(date.getMonth())
								}
								disabled={(date) =>
									date.getMonth() !== focusedMonth ||
									date < subDays(1, new Date())
								}
								initialFocus
								showOutsideDays={false}
							/>
						</PopoverContent>
					</Popover>
					<FormMessage />
				</FormItem>
			)}
		/>
	);
};
