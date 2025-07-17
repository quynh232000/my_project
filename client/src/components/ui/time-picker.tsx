import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { Label } from '@/components/ui/label';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import * as React from 'react';
import { useEffect, useRef, useState } from 'react';
import IconChevron from '@/assets/Icons/outline/IconChevron';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import Typography from '@/components/shared/Typography';
import { GlobalUI } from '@/themes/type';

interface Props extends ClassNameProp {
	label?: string;
	triggerClassName?: string;
	triggerLabel?: string;
	required?: boolean;
	onChange: (val: string) => void;
	placeholder?: string;
}

const TimePicker = ({
	containerClassName,
	className,
	triggerLabel,
	label,
	triggerClassName,
	required,
	onChange,
	placeholder,
}: Props) => {
	const [open, setOpen] = useState(false);

	const hourRef = useRef<HTMLDivElement>(null);
	const minuteRef = useRef<HTMLDivElement>(null);

	const hours = Array.from({ length: 24 }).map((_, i) => i);
	const minutes = Array.from({ length: 60 }).map((_, i) => i);

	const [selectedHour, selectedMinute] = triggerLabel?.split?.(':') ?? [];

	useEffect(() => {
		setTimeout(() => {
			if (open && triggerLabel && hourRef.current && minuteRef.current) {
				const [hour, minute] = triggerLabel?.split?.(':') ?? [];
				if (hour) {
					hourRef.current.scrollTo({
						top: Number(hour) * 24,
						behavior: 'smooth',
					});
				}
				if (minute) {
					minuteRef.current.scrollTo({
						top: Number(minute) * 24,
						behavior: 'smooth',
					});
				}
			}
		}, 0);
	}, [open, triggerLabel]);

	const onSelectTime = (val: number, type: 'hour' | 'minute') => {
		const [hourStr, minuteStr] = triggerLabel?.split?.(':') ?? [];
		const hour = type === 'hour' ? val : Number(hourStr) || 0;
		const minute = type === 'minute' ? val : Number(minuteStr) || 0;
		onChange(
			`${hour}`.padStart(2, '0') + ':' + `${minute}`.padStart(2, '0')
		);
	};

	return (
		<Popover onOpenChange={setOpen} open={open}>
			<PopoverTrigger
				className={cn('w-full text-start', triggerClassName)}>
				{label && <Label required={required}>{label}</Label>}
				<div
					className={cn(
						TextVariants.caption_14px_400,
						`flex min-h-6 w-full items-center justify-between rounded-lg border-2 p-3 ${open ? 'border-secondary-200' : 'border-other-divider-02'}`,
						className
					)}>
					{triggerLabel ? (
						<span className={'text-neutral-600'}>
							{triggerLabel}
						</span>
					) : (
						<span className={'text-neutral-300'}>
							{placeholder}
						</span>
					)}
					<div
						className={`transition-transform ${open ? 'rotate-180' : 'rotate-0'}`}>
						<IconChevron
							direction={'down'}
							width={14}
							height={14}
							color={GlobalUI.colors.neutrals['4']}
						/>
					</div>
				</div>
			</PopoverTrigger>
			<PopoverContent
				forceMount
				onClick={() => {
					// setOpen(false);
				}}
				align={'center'}
				className={cn(
					'rounded-lg !border border-other-divider bg-white shadow-2xl',
					containerClassName
				)}>
				<div className={'flex flex-row items-start justify-start p-3'}>
					<ScrollArea ref={hourRef} className={'h-60 min-w-14'}>
						{hours.map((hour) => (
							<div key={hour} className={'flex flex-col'}>
								<button
									onClick={() => onSelectTime(hour, 'hour')}>
									<Typography
										variant={`${Number(selectedHour) === hour ? 'caption_14px_600' : 'caption_14px_400'}`}
										className={`text-center ${Number(selectedHour) === hour && 'text-secondary-500'}`}>
										{`${hour}`.padStart(2, '0')}
									</Typography>
								</button>
							</div>
						))}
						<div className={'h-[216px]'} />
						<ScrollBar className={'hidden'} />
					</ScrollArea>
					<Typography
						variant={'caption_14px_600'}
						className={'mt-[-2px] text-secondary-500'}>
						:
					</Typography>
					<ScrollArea ref={minuteRef} className={'h-60 min-w-14'}>
						{minutes.map((minute) => (
							<div key={minute} className={'flex flex-col'}>
								<button
									onClick={() =>
										onSelectTime(minute, 'minute')
									}>
									<Typography
										variant={`${Number(selectedMinute) === minute ? 'caption_14px_600' : 'caption_14px_400'}`}
										className={`text-center ${Number(selectedMinute) === minute && 'text-secondary-500'}`}>
										{`${minute}`.padStart(2, '0')}
									</Typography>
								</button>
							</div>
						))}
						<div className={'h-[216px]'} />
						<ScrollBar className={'hidden'} />
					</ScrollArea>
				</div>
			</PopoverContent>
		</Popover>
	);
};

export default TimePicker;
