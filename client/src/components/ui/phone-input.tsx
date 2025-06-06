import IconCheck from '@/assets/Icons/outline/IconCheck';
import IconChevron from '@/assets/Icons/outline/IconChevron';
import {
	Command,
	CommandEmpty,
	CommandGroup,
	CommandInput,
	CommandItem,
	CommandList,
} from '@/components/ui/command'; // import { Input } from '@/components/ui/input';
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/components/ui/popover';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { ListCountry } from '@/lib/seeds/country';
import { cn } from '@/lib/utils';
import { GlobalUI } from '@/themes/type';
import Image from 'next/image';
import { useEffect, useMemo, useRef, useState } from 'react';
import Typography from '../shared/Typography';
import { Input } from './input';

interface PhoneInputProps {
	disabled?: boolean;
	value: string;
	onChange: (phone: string) => void;
	className?: string;
}

const PhoneInput = ({
	disabled,
	value = '+84',
	onChange,
	className,
}: PhoneInputProps) => {
	const [open, setOpen] = useState(false);
	const [containerWidth, setContainerWidth] = useState(0);

	const containerRef = useRef<HTMLDivElement>(null);
	const listRef = useRef<HTMLDivElement>(null);

	const phoneCode = value.slice(0, 5);
	const selectedCountry = useMemo(() => {
		for (let i = 5; i >= 1; i--) {
			const code = phoneCode.slice(0, i);
			const country = ListCountry[code];
			if (country) {
				return {
					country,
					dialCode: code,
				};
			}
		}
	}, [phoneCode]);

	const barePhoneNumber = useMemo(() => {
		return value.slice(selectedCountry?.dialCode.length ?? 0);
	}, [value, selectedCountry?.dialCode]);

	useEffect(() => {
		if (containerRef.current) {
			setContainerWidth(containerRef.current.offsetWidth);
		}
	}, [containerRef.current]);

	useEffect(() => {
		setTimeout(() => {
			if (open) {
				listRef.current?.scrollIntoView({
					behavior: 'instant',
				});
			}
		}, 0);
	}, [open]);

	return (
		<Popover open={open} onOpenChange={setOpen}>
			<div
				className={`flex items-center ${disabled && 'cursor-not-allowed'}`}
				ref={containerRef}>
				<PopoverTrigger className="w-20" disabled={disabled}>
					<div
						className={cn(
							'relative box-border flex h-[44px] items-center gap-2 rounded-l-xl border-2 border-other-divider-02 p-3 text-center',
							open && 'z-10 border-secondary-200',
							className,
							disabled && 'cursor-not-allowed !bg-neutral-50'
						)}>
						{selectedCountry && (
							<Image
								src={`https://flagcdn.com/w40/${selectedCountry?.country?.code?.toLocaleLowerCase()}.png`}
								alt={''}
								className={'h-[18px] w-[24px]'}
								width={24}
								height={18}
							/>
						)}
						<div
							className={`transition-transform ${open ? 'rotate-180' : 'rotate-0'} ml-auto`}>
							<IconChevron
								direction={'down'}
								width={14}
								height={14}
								color={GlobalUI.colors.neutrals['4']}
							/>
						</div>
					</div>
				</PopoverTrigger>
				<div className="flex-1">
					<Input
						disabled={disabled}
						type="tel"
						maxLength={10}
						className={cn(
							`ml-[-2px] h-[44px] rounded-l-none py-2 !pb-2.5`,
							className
						)}
						style={{
							paddingLeft: `${(selectedCountry?.dialCode.length ?? 0) * 8 + 30}px`,
						}}
						placeholder="Nhập số điện thoại"
						value={barePhoneNumber}
						startAdornment={
							<Typography
								variant="caption_14px_400"
								className="text-neutral-600">
								({selectedCountry?.dialCode})
							</Typography>
						}
						onChange={(e) =>
							onChange(`${selectedCountry?.dialCode ?? ''}${e.target.value}`)
						}
					/>
				</div>
			</div>
			<PopoverContent
				style={{ width: containerWidth }}
				align={'start'}
				side={'bottom'}
				className={
					'divide-y overflow-hidden rounded-xl !border border-other-divider-02 shadow'
				}>
				<Command>
					<CommandInput placeholder="Tìm kiếm..." />
					<CommandList>
						<ScrollArea className={'h-60 shadow-md'}>
							<CommandEmpty>Không tìm thấy lựa chọn</CommandEmpty>
							<CommandGroup>
								{Object.entries(ListCountry)?.map(([key, item]) => {
									const isSelected = selectedCountry?.dialCode === key;
									return (
										<CommandItem
											className={`${isSelected ? '!bg-neutral-100' : ''}`}
											ref={isSelected ? listRef : null}
											key={item.code}
											value={`${item.name} (+${key})`}
											title={item.name}
											onSelect={() => {
												onChange(`${key}${barePhoneNumber}`);
											}}>
											<div className={'flex items-center gap-2'}>
												<Image
													src={`https://flagcdn.com/w40/${item.code.toLocaleLowerCase()}.png`}
													alt={item.name}
													className={'h-[18px] w-[24px] object-contain'}
													width={24}
													height={18}
												/>
												<span className={'truncate whitespace-nowrap'}>
													{`${item.name} (${key})`}
												</span>
												{isSelected && (
													<IconCheck
														color={GlobalUI.colors.secondary['500']}
														className={'ml-auto size-5 shrink-0'}
													/>
												)}
											</div>
										</CommandItem>
									);
								})}
							</CommandGroup>
							<ScrollBar />
						</ScrollArea>
					</CommandList>
				</Command>
			</PopoverContent>
		</Popover>
	);
};

export default PhoneInput;
