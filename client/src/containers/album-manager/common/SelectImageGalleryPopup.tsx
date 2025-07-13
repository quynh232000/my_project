'use client';
import React, { useEffect, useMemo, useRef, useState } from 'react';
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/components/ui/popover';
import IconChevron from '@/assets/Icons/outline/IconChevron';
import { GlobalUI } from '@/themes/type';
import { cn } from '@/lib/utils';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import IconClose from '@/assets/Icons/outline/IconClose';
import { normalizeText } from '@/utils/string/remove-accent';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { ControllerRenderProps } from 'react-hook-form';
import { IconCheck } from '@/assets/Icons/outline';
import { TImageTagList } from '@/services/attributes/getAttributeImageType';
import debounce from 'lodash/debounce';

interface SelectPopupProps {
	selectedValue?: string | number;
	onChange?: (value: string | number) => void;
	data?: TImageTagList;
	className?: string;
	disabled?: boolean;
	placeholder?: string;
	controllerRenderProps?: Omit<ControllerRenderProps, 'onChange' | 'value'>;
	searchInput?: boolean;
}

const SelectImageGalleryPopup = ({
	searchInput = true,
	controllerRenderProps,
	...props
}: SelectPopupProps) => {
	const [open, setOpen] = useState(false);
	const [search, setSearch] = useState('');
	const containerRef = useRef<HTMLDivElement>(null);
	const listRef = useRef<HTMLButtonElement>(null);
	const listContainerRef = useRef<HTMLDivElement>(null);
	const [containerWidth, setContainerWidth] = useState(0);
	const [list, setList] = useState<TImageTagList>([]);

	const selectedName = useMemo(() => {
		const selectedItem =
			props.data &&
			props.data
				.map((item) => item.children)
				.flat(1)
				?.find((item) => `${item.id}` === `${props.selectedValue}`);
		return selectedItem?.name || '';
	}, [props.selectedValue, props.data]);

	useEffect(() => {
		if (containerRef.current) {
			setContainerWidth(containerRef.current.offsetWidth);
		}
	}, [containerRef.current, props.data, props.selectedValue]);

	useEffect(() => {
		if (props.data) {
			setList(props.data || []);
		}
	}, [props.data]);

	useEffect(() => {
		setTimeout(() => {
			if (open) {
				listRef.current?.scrollIntoView({
					behavior:
						(props.data?.length ?? 0) <= 50 ? 'smooth' : 'instant',
				});
			}
		}, 0);
	}, [open, props.data]);

	const handleSearch = debounce((text: string) => {
		if (!props.data || !text) {
			setList(props.data || []);
		} else {
			const filteredList = props.data?.map((item) => ({
				...item,
				children: item.children.filter((item) =>
					normalizeText(item.name).includes(normalizeText(text))
				),
			}));
			setList(filteredList);
		}
		listContainerRef?.current?.scrollTo({
			top: 0,
			behavior: (props.data?.length ?? 0) <= 50 ? 'smooth' : 'instant',
		});
	}, 500);

	return (
		<Popover open={open} onOpenChange={setOpen}>
			<div
				className={cn(
					'col-span-12 w-full overflow-hidden whitespace-normal break-words lg:col-span-1'
				)}>
				<PopoverTrigger className="w-full" disabled={props.disabled}>
					<div
						ref={containerRef}
						className={cn(
							'box-border flex items-center gap-2 rounded-xl border-2 border-other-divider-02 p-3 text-center',
							!props.disabled && 'hover:border-primary-1-1',
							open && 'border-secondary-200',
							props.className
						)}>
						<Typography
							tag={'p'}
							variant={'caption_14px_400'}
							className={cn(
								'items-center justify-start gap-2 truncate',
								selectedName
									? 'text-neutral-600'
									: 'text-neutral-300'
							)}>
							{selectedName || props.placeholder}
						</Typography>
						{!props.disabled && (
							<div
								className={`transition-transform ${open ? 'rotate-180' : 'rotate-0'} ml-auto`}>
								<IconChevron
									direction={'down'}
									width={14}
									height={14}
									color={GlobalUI.colors.neutrals['4']}
								/>
							</div>
						)}
						{controllerRenderProps && (
							<input
								className={'h-0 w-0 overflow-hidden'}
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
					{searchInput && (
						<div className={'flex items-stretch'}>
							<input
								placeholder={'Tìm kiếm...'}
								value={search}
								className={`reset-input w-full flex-1 !border-0 p-3 leading-5 ${TextVariants.caption_14px_400}`}
								onChange={(value) => {
									setSearch(value.target.value);
									handleSearch(
										normalizeText(value.target.value)
									);
								}}
							/>
							<button
								className={'p-4'}
								aria-label={'Close'}
								onClick={() => {
									if (search) setSearch('');
									setList(props.data || []);
								}}>
								<IconClose />
							</button>
						</div>
					)}
					<ScrollArea
						ref={listContainerRef}
						className={cn(
							'shadow-md',
							list.reduce(
								(acc, cur) => acc + cur.children.length,
								0
							) >= 5
								? 'h-52'
								: 'h-auto'
						)}>
						{list && list.length > 0 ? (
							list.map(
								(group) =>
									group.children.length > 0 && (
										<div key={`group-${group.id}`}>
											<Typography
												tag={'p'}
												variant={'content_16px_600'}
												className={
													'mt-1 px-3 text-neutral-600'
												}>
												{group.name}
											</Typography>
											{group.children.map((item) => (
												<button
													key={item.id}
													title={item.name}
													{...(item.id ===
													props.selectedValue
														? { ref: listRef }
														: {})}
													onClick={() => {
														props.onChange?.(
															item.id
														);
														setOpen(false);
													}}
													className={`line-clamp-1 h-8 w-full px-4 text-left hover:bg-neutral-00 ${
														item.id ===
														props.selectedValue
															? 'bg-neutral-00 text-secondary-500'
															: 'text-neutral-600'
													}`}>
													<Typography
														tag={'p'}
														variant={
															'caption_14px_400'
														}
														className={cn(
															'flex items-center justify-between truncate text-nowrap',
															item.id ===
																props.selectedValue &&
																'text-secondary-500'
														)}>
														{item.name}
														{item.id ===
															props.selectedValue && (
															<IconCheck
																color={
																	GlobalUI
																		.colors
																		.secondary[
																		'500'
																	]
																}
																className={
																	'size-5'
																}
															/>
														)}
													</Typography>
												</button>
											))}
										</div>
									)
							)
						) : (
							<div
								className={`p-4 text-center ${TextVariants.caption_14px_600}`}>
								{'Không tìm thấy lựa chọn'}
							</div>
						)}
						<ScrollBar />
					</ScrollArea>
				</PopoverContent>
			</div>
		</Popover>
	);
};
SelectImageGalleryPopup.displayName = 'SelectImageGalleryPopup';
export default SelectImageGalleryPopup;
