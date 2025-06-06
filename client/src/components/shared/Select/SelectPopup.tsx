'use client';
import { IconCheck, IconClose } from '@/assets/Icons/outline';
import IconChevron from '@/assets/Icons/outline/IconChevron';
import Typography from '@/components/shared/Typography';
import {
	Command,
	CommandEmpty,
	CommandGroup,
	CommandInput,
	CommandItem,
	CommandList,
} from '@/components/ui/command';
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/components/ui/popover';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { cn } from '@/lib/utils';
import { GlobalUI } from '@/themes/type';
import { normalizeText } from '@/utils/string/remove-accent';
import { useEffect, useMemo, useRef, useState } from 'react';
import { ControllerRenderProps } from 'react-hook-form';

export interface OptionType {
	value: string | number;
	label: string;
}

interface SelectPopupProps {
	clearable?: boolean;
	defaultValue?: string | number;
	selectedValue?: string | number;
	onChange?: (value: string | number) => void;
	selectLabel?: string;
	label?: string;
	data?: OptionType[];
	labelClassName?: string;
	className?: string;
	containerClassName?: string;
	classItemList?: string;
	required?: boolean;
	disabled?: boolean;
	searchInput?: boolean;
	placeholder?: string;
	controllerRenderProps?: Omit<ControllerRenderProps, 'onChange' | 'value'>;
	showCheck?: boolean;
}

const SelectPopup = ({
	searchInput = true,
	controllerRenderProps,
	showCheck = true,
	clearable = false,
	...props
}: SelectPopupProps) => {
	const [open, setOpen] = useState(false);
	const [containerWidth, setContainerWidth] = useState(0);

	const containerRef = useRef<HTMLDivElement>(null);
	const listRef = useRef<HTMLDivElement>(null);

	const selectedName = useMemo(() => {
		const selectedItem = props.data?.find(
			(item) => `${item.value}` === `${props.selectedValue}`
		);
		return selectedItem?.label || '';
	}, [props.selectedValue, props.data]);

	useEffect(() => {
		if (containerRef.current) {
			setContainerWidth(containerRef.current.offsetWidth);
		}
	}, [containerRef.current]);

	useEffect(() => {
		setTimeout(() => {
			if (open) {
				listRef.current?.scrollIntoView({
					behavior: (props.data?.length ?? 0) <= 50 ? 'smooth' : 'instant',
				});
			}
		}, 0);
	}, [open, props.data]);

	return (
		<Popover open={open} onOpenChange={setOpen}>
			<div
				className={cn(
					'col-span-12 w-full overflow-hidden whitespace-normal break-words lg:col-span-1',
					props.containerClassName
				)}>
				{props.label && (
					<div
						className={cn(
							'text-neutral-4 mb-2 w-full text-start leading-3',
							props.labelClassName
						)}>
						<Typography
							tag={'span'}
							variant={'caption_14px_500'}
							className={'truncate text-nowrap text-neutral-600'}>
							{props.label}{' '}
							{props.required && <span className={'text-red-500'}>*</span>}
						</Typography>
					</div>
				)}
				<PopoverTrigger className="w-full" disabled={props.disabled}>
					<div
						ref={containerRef}
						className={cn(
							'box-border flex items-center gap-2 rounded-xl border-2 border-other-divider-02 p-3 text-center',
							open && 'border-secondary-200',
							props.className,
							props.disabled && 'cursor-not-allowed !bg-neutral-50'
						)}>
						<Typography
							tag={'p'}
							variant={'caption_14px_400'}
							className={cn(
								'items-center justify-start gap-2 truncate',
								selectedName ? 'text-neutral-600' : 'text-neutral-300'
							)}>
							{selectedName || props.placeholder}
						</Typography>
						<div className="ml-auto flex items-center gap-3">
							{clearable && !!selectedName && (
								<div
									className="rounded-full bg-neutral-50 p-1 hover:bg-neutral-100"
									onClick={() => props.onChange?.(0)}>
									<IconClose />
								</div>
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
					style={{ width: containerWidth }}
					align={'start'}
					side={'bottom'}
					className={
						'divide-y overflow-hidden rounded-xl !border border-other-divider-02 shadow'
					}>
					<Command
						filter={(value, search) => {
							return normalizeText(value).includes(normalizeText(search))
								? 1
								: 0;
						}}>
						{searchInput && <CommandInput placeholder="Tìm kiếm..." />}
						<CommandList>
							<ScrollArea
								className={cn(
									'shadow-md',
									props.classItemList,
									(props.data?.length ?? 0) >= 5 ? 'h-60' : 'h-auto'
								)}>
								<CommandEmpty>Không tìm thấy lựa chọn</CommandEmpty>
								<CommandGroup>
									{props.data?.map((item) => {
										const isSelected =
											String(item.value) === String(props.selectedValue);
										return (
											<CommandItem
												className={`${isSelected ? '!bg-neutral-100' : ''}`}
												ref={isSelected ? listRef : null}
												key={item.value}
												value={item.label.toString()}
												title={item.label}
												onSelect={() => {
													props.onChange?.(item.value);
													setOpen(false);
												}}>
												<div
													className={'flex items-center justify-between gap-2'}>
													<span className={'truncate whitespace-nowrap'}>
														{item.label}
													</span>
													{isSelected && showCheck && (
														<IconCheck
															color={GlobalUI.colors.secondary['500']}
															className={'size-5 shrink-0'}
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
			</div>
		</Popover>
	);
};
SelectPopup.displayName = 'SelectVisaProduct';
export default SelectPopup;
