import React, { useEffect, useState } from 'react';
import { useController, useFormContext } from 'react-hook-form';
import {
	addYears,
	format,
	isAfter,
	isBefore,
	isEqual,
	startOfDay,
} from 'date-fns';
import { vi } from 'date-fns/locale';
import {
	Popover,
	PopoverAnchor,
	PopoverContent,
} from '@/components/ui/popover';
import { Calendar } from '@/components/ui/calendar';
import { Label } from '@/components/ui/label';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Button } from '@/components/ui/button';
import { IconCalendarAll } from '@/assets/Icons/outline';
import Typography from '@/components/shared/Typography';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';

const SeparatelyDateRangePicker = () => {
	const { control } = useFormContext();

	const [open, setOpen] = useState(false);
	const [target, setTarget] = useState<'from' | 'to'>('from');

	const {
		field: { value, onChange },
		formState: {errors}
	} = useController({
		name: 'date',
		control,
	});

	const handleChange = (date: Date) => {
		if (!date) {
			setOpen(false);
			return;
		}
		if (target === 'from') {
			if (value.from && value.to) {
				if (isBefore(date, value.from)) {
					onChange({ from: date, to: value.to });
					setTarget('to');
				} else if (isAfter(date, value.to)) {
					onChange({ from: date, to: null });
					setTarget('to');
				} else {
					onChange({ from: date, to: value.to });
					setTarget('to');
				}
			} else if (value.from && !value.to) {
				onChange({ from: value.from, to: date });
			} else onChange({ from: date, to: value?.to });
		} else {
			if (isEqual(startOfDay(date), startOfDay(value.from))) {
				onChange({ from: value.from, to: date });
			} else onChange({ from: value.from, to: date });
			setOpen(false);
		}
	};
	const getTimeConvert = (date: Date) => {
		try {
			return format(date, 'dd/MM/yyyy', { locale: vi });
		} catch (_) {
			onChange(value.from);
			return '';
		}
	};

	useEffect(() => {
		if (!open) {
			setTarget('from');
		}
	}, [open, value.to]);

	return (
		<Popover
			open={open}
			onOpenChange={(isOpen) => {
				if (!isOpen) setOpen(false);
			}}>
			<PopoverAnchor className="mt-4 flex w-full flex-1 cursor-pointer gap-4">
				<div className={'flex-1'}>
					<Label
						required
						className={`select-none text-neutral-600 ${TextVariants.caption_14px_500}`}>
						Từ
					</Label>
					<Button
						type={'button'}
						variant={'outline'}
						onClick={(e) => {
							e.stopPropagation();
							setOpen(true);
						}}
						className={`h-10 w-full rounded-xl border-2 border-other-divider-02 pl-3 text-neutral-600 hover:border-secondary-500 hover:bg-transparent ${target === 'from' && open && 'border-secondary-500'}`}>
						<Typography variant={'caption_14px_400'}>
							{value ? getTimeConvert(value?.from ?? value) : 'dd/mm/yyyy'}
						</Typography>
						<IconCalendarAll className={'ml-auto !h-5 !w-5 text-neutral-400'} />
					</Button>
					<FieldErrorMessage errors={errors} name={'date.from'} />
				</div>

				<div className={'flex-1'}>
					<Label
						required
						className={`select-none text-neutral-600 ${TextVariants.caption_14px_500}`}>
						Đến
					</Label>
					<Button
						type={'button'}
						variant={'outline'}
						onClick={(e) => {
							e.stopPropagation();
							setOpen(true);
							setTarget('to');
						}}
						className={`h-10 w-full rounded-xl border-2 border-other-divider-02 pl-3 text-neutral-600 hover:border-secondary-500 hover:bg-transparent ${target === 'to' && 'border-secondary-500'}`}>
						<Typography variant={'caption_14px_400'}>
							{value.to ? getTimeConvert(value?.to) : 'dd/mm/yyyy'}
						</Typography>
						<IconCalendarAll className={'ml-auto !h-5 !w-5 text-neutral-400'} />
					</Button>
					<FieldErrorMessage errors={errors} name={'date.to'} />

				</div>
			</PopoverAnchor>
			<PopoverContent
				sideOffset={-16}
				side={'top'}
				className={'border-neutral-divider mt-6 w-auto border bg-white p-0'}>
				{open && (
					<Calendar
						locale={vi}
						selected={value || ''}
						onDayClick={handleChange as never}
						mode={'range'}
						disabled={{
							before: target === 'from' ? new Date() : value.from,
							after: addYears(new Date(), 1),
						}}
						numberOfMonths={2}
						showOutsideDays={false}
					/>
				)}
			</PopoverContent>
		</Popover>
	);
};

export default SeparatelyDateRangePicker;
