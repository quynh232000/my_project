'use client';
import IconChevron from '@/assets/Icons/outline/IconChevron';
import {
	Command,
	CommandEmpty,
	CommandGroup,
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
import { normalizeText } from '@/utils/string/remove-accent';
import React, { useEffect, useRef, useState } from 'react';
import { ControllerRenderProps } from 'react-hook-form';
import { TSelectCheckbox } from '@/containers/booking-orders/data';
import { Checkbox } from '@/components/ui/checkbox';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { GlobalUI } from '@/themes/type';


interface SelectCheckboxProps {
	onChange?: (value: string | number) => void;
	data?: TSelectCheckbox[];
	handleChangeData?: (data: TSelectCheckbox[]) => void;
	className?: string;
	containerClassName?: string;
	classItemList?: string;
	placeholder?: string;
	controllerRenderProps?: Omit<ControllerRenderProps, 'onChange' | 'value'>;
	displayLabel: React.ReactNode;
	containerWidthDefault?: number;
	isIconChevronLight?: boolean;
}

const SelectCheckbox = ({
	controllerRenderProps,
	isIconChevronLight = false,
	...props
}: SelectCheckboxProps) => {
	const [open, setOpen] = useState(false);
	const [containerWidth, setContainerWidth] = useState(
		props.containerWidthDefault ?? 0
	);
	const containerRef = useRef<HTMLDivElement>(null);

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
						{props.displayLabel}
						<div
							className={`transition-transform ${open ? 'rotate-180' : 'rotate-0'}`}>
							<IconChevron
								direction={'down'}
								width={12}
								height={12}
								color={
									isIconChevronLight ? '#fff' : GlobalUI.colors.neutrals['400']
								}
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
					style={{ width: `${containerWidth}px` }}
					align={'end'}
					side={'bottom'}
					className={cn(
						'divide-y overflow-hidden rounded-lg border-stroke-subtle shadow-[0px_24px_24px_-16px_rgba(15,15,15,0.20)]'
					)}>
					<Command
						filter={(value, search) => {
							return normalizeText(value).includes(normalizeText(search))
								? 1
								: 0;
						}}>
						<CommandList>
							<ScrollArea className={cn('h-auto', props.classItemList)}>
								<CommandEmpty>Không tìm thấy lựa chọn</CommandEmpty>
								<CommandGroup className={'m-0 bg-other-white px-3 py-2'}>
									{props.data &&
										props.data.length > 0 &&
										props.data.map((item) => {
											return (
												<CommandItem
													className={
														'mb-0 px-0 py-1 data-[selected=true]:!bg-white'
													}
													key={item.value}
													value={item.value}
													title={item.value}
													onSelect={() => {
														props.onChange?.(item.value);
													}}>
													<div className={'flex w-full items-center gap-2'}>
														<Checkbox
															id={`checkbox_${item.value}`}
															checked={item.checked}
															onCheckedChange={(value) => {
																const newList = props.data?.map((itemCheck) =>
																	itemCheck.value === item.value
																		? {
																			...itemCheck,
																			checked: Boolean(value),
																		}
																		: itemCheck
																);
																props.handleChangeData?.(newList || []);
															}}
															className={
																'duration-800 transition-all ease-in-out'
															}
														/>
														<label
															htmlFor={`checkbox_${item.value}`}
															className={cn(
																'flex-1 cursor-pointer text-neutral-600',
																TextVariants.caption_14px_400
															)}>
															{item.title}
														</label>
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
SelectCheckbox.displayName = 'SelectCheckbox';
export default SelectCheckbox;
