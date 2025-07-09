import { IconChevron, IconUser } from '@/assets/Icons/outline';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import {
	IOnToggleSingleRoom,
	IOnUpdateRoomPrice,
	IOnUpdateRoomQuantity,
	IRoomPriceSetting,
} from '@/containers/price/Availability';
import { useAvailabilityCenterStore } from '@/store/availability-center/store';
import { GlobalUI } from '@/themes/type';
import { addDays, differenceInDays, format, isWeekend, parse } from 'date-fns';
import { vi } from 'date-fns/locale';
import React, { Fragment, useEffect, useMemo, useRef, useState } from 'react';
import AvailabilityCellsPopover from './AvailabilityCellsPopover';
import { useShallow } from 'zustand/react/shallow';

interface AvailabilityTableProps {
	onEditOccupancy: (data: IRoomPriceSetting) => void;
	onToggleSingleRoom: (data: IOnToggleSingleRoom) => void;
	onUpdateRoomQuantity: (data: IOnUpdateRoomQuantity) => Promise<void>;
	onUpdateRoomPrice: (data: IOnUpdateRoomPrice) => Promise<void>;
}

type SelectType = 'roomCount' | 'price';

interface ISelectData {
	room_id: number;
	value: number;
	min?: number;
	max?: number;
	price_id?: number;
}

export const AvailabilityTable = ({
	onEditOccupancy,
	onToggleSingleRoom,
	onUpdateRoomQuantity,
	onUpdateRoomPrice,
}: AvailabilityTableProps) => {
	const { list, params } = useAvailabilityCenterStore(
		useShallow((state) => ({
			list: state.list,
			params: state.params,
		}))
	);

	const [showFadeEdge, setShowFadeEdge] = useState(true);
	const [selecting, setSelecting] = useState<
		| {
				action: boolean;
				data: ISelectData;
				type: SelectType;
				side?: 'left' | 'right';
		  }
		| undefined
	>(undefined);

	const [selectedItems, setSelectedItems] = useState<string[]>([]);
	const [wrapperElement, setWrapperElement] = useState<HTMLDivElement | null>(
		null
	);

	const filteredList =
		params?.room === 'all'
			? list
			: list?.filter((room) => room.id === params.room);

	const dates = useMemo(() => {
		if (
			filteredList?.length > 0 &&
			filteredList?.[0]?.availability?.length > 0
		) {
			return {
				start_date: filteredList?.[0]?.availability?.[0]?.date,
				end_date:
					filteredList?.[0]?.availability?.[
						filteredList?.[0]?.availability?.length - 1
					]?.date,
			};
		}
		return null;
	}, [filteredList]);

	const rates = useMemo(() => {
		return filteredList?.map((room) => {
			const maxOccupancy = room.allow_extra_guests
				? room.max_capacity
				: Math.max(
						room.standard_guests + room.max_extra_children,
						room.standard_guests + room.max_extra_adults
					);
			return {
				id: room.id,
				maxOccupancy,
				rate: room?.room_price_types
					// ?.filter((rate) => rate.price_type_id === 0 || !!rate.price_type)
					?.map((rate) => {
						const capacityPriceMap = new Map<number, number>(
							room.price_settings
								?.filter((item) => item.price_type_id === rate.price_type_id)
								?.map((item) => [
									item.capacity,
									item.status === 'active' ? item.price : 0,
								])
						);

						const prices = Object.fromEntries(
							Array.from({ length: maxOccupancy }).map((_, i) => [
								i + 1,
								Object.fromEntries(
									room?.availability?.map(({ prices, date }) => {
										const price = prices?.find(
											(item) => item.price_type_id === rate.price_type_id
										);
										const priceVal =
											rate?.price_type_id == 0
												? (price?.price ?? room.price_standard)
												: price?.price;
										const priceValAfterCharge = priceVal
											? priceVal +
												(capacityPriceMap.get(i + 1) ?? 0) *
													(i + 1 >= room.standard_guests ? 1 : -1)
											: undefined;
										return [date, priceValAfterCharge];
									})
								),
							])
						);

						return {
							id: rate.id,
							rate_id: rate.price_type_id,
							name: rate.price_type_name,
							prices: prices,
						};
					}),
			};
		});
	}, [filteredList, params]);

	const bodyRef = useRef<HTMLDivElement>(null);
	const headRef = useRef<HTMLDivElement>(null);

	const header = useMemo(() => {
		if (!dates) {
			return null;
		}
		const startDate = parse(dates.start_date, 'yyyy-MM-dd', new Date());
		const endDate = parse(dates.end_date, 'yyyy-MM-dd', new Date());
		const res: { [key: string]: Date[] } = {};
		Array.from({
			length: differenceInDays(endDate, startDate) + 1,
		}).forEach((_, i) => {
			const day = addDays(startDate, i);
			const monthStr = format(day, 'MMMM', { locale: vi });
			res[monthStr] = res[monthStr] ? [...res[monthStr], day] : [day];
		});
		return res;
	}, [dates]);

	const handlePointerDown = (
		e: React.PointerEvent<HTMLDivElement>,
		data: ISelectData,
		type: SelectType
	) => {
		setSelecting({
			action: true,
			data,
			type,
		});
		setSelectedItems([e.currentTarget.id, e.currentTarget.id]);
	};

	const handlePointerMove = (
		e: React.PointerEvent<HTMLDivElement>,
		roomId: number,
		type: SelectType,
		priceId?: number
	) => {
		if (
			!selecting?.action ||
			selecting?.data?.room_id !== roomId ||
			selecting?.type !== type ||
			(priceId !== undefined && selecting.data.price_id !== priceId) ||
			selectedItems?.[1] === e.currentTarget.id
		)
			return;
		const nextMove =
			selecting.side === 'left'
				? [e.currentTarget.id, selectedItems[1]]
				: [selectedItems[0], e.currentTarget.id];
		setSelectedItems(nextMove);
	};

	const handleContinuePauseAction = (
		action: boolean,
		side?: 'left' | 'right'
	) => {
		const elId = selectedItems[0];
		if (elId) {
			const lastDashIndex = elId.lastIndexOf('-');
			const prefix = elId.slice(0, lastDashIndex);
			const ids = [
				+elId.slice(lastDashIndex + 1),
				+selectedItems[1].slice(lastDashIndex + 1),
			];
			setSelectedItems([
				`${prefix}-${Math.min(...ids)}`,
				`${prefix}-${Math.max(...ids)}`,
			]);
		}
		setSelecting((prev) => {
			if (prev) {
				return { ...prev, action, side: action ? side : 'right' };
			}
			return undefined;
		});
	};

	const handleControllerPointerDown = (event: MouseEvent) => {
		if (selecting?.action) return;
		const rect = (
			event.currentTarget as HTMLDivElement
		).getBoundingClientRect();

		const clickX = event.clientX - rect.left;
		handleContinuePauseAction(true, clickX < rect.width / 2 ? 'left' : 'right');
	};

	useEffect(() => {
		document.addEventListener('pointerup', () => {
			handleContinuePauseAction(false);
		});
		return () => {
			document.removeEventListener('pointerup', () => {
				handleContinuePauseAction(false);
			});
		};
	}, []);

	useEffect(() => {
		if (selectedItems.length === 2) {
			if (selectedItems[0] == selectedItems[1]) {
				const element = document.getElementById(selectedItems[0]);
				if (element) {
					const wrapper = document.createElement('div');
					wrapper.className = 'selected';
					wrapper.onpointerdown = handleControllerPointerDown;
					wrapper.onpointerup = () => {
						handleContinuePauseAction(false);
					};
					element.parentNode?.insertBefore(wrapper, element);
					wrapper.appendChild(element);
					setWrapperElement((prev) => {
						clearSelectedItems(prev);
						return wrapper;
					});
				}
			} else {
				const elId = selectedItems[0];
				const lastDashIndex = elId.lastIndexOf('-');
				const prefix = elId.slice(0, lastDashIndex);
				const ids = [
					+elId.slice(lastDashIndex + 1),
					+selectedItems[1].slice(lastDashIndex + 1),
				];
				const startIdx = Math.min(...ids);
				const endIdx = Math.max(...ids);
				const elements = [];
				for (let i = +startIdx; i <= +endIdx; i++) {
					const el = document.getElementById(`${prefix}-${i}`);
					if (el) elements.push(el);
				}
				if (elements.length > 0) {
					const wrapper = document.createElement('div');
					wrapper.className = 'selected';
					wrapper.onpointerdown = handleControllerPointerDown;
					wrapper.onpointerup = () => {
						handleContinuePauseAction(false);
					};
					const parent = elements[0].parentNode;
					parent?.insertBefore(wrapper, elements[0]);
					elements.forEach((el) => {
						wrapper.appendChild(el);
					});
					setWrapperElement((prev) => {
						clearSelectedItems(prev);
						return wrapper;
					});
				}
			}
		} else {
			setWrapperElement((prev) => {
				clearSelectedItems(prev);
				return null;
			});
		}
	}, [selectedItems]);

	const clearSelectedItems = (wrapper: HTMLDivElement | null) => {
		const children = wrapper?.childNodes;
		if (wrapper && children && (children?.length ?? 0) > 0) {
			[...children]?.forEach((child) => {
				wrapper?.parentNode?.insertBefore(child, wrapper);
			});
		}
		wrapper?.parentNode?.removeChild(wrapper);
	};

	const syncScroll = (
		e: React.UIEvent<HTMLDivElement>,
		source: 'head' | 'body'
	) => {
		const scrollLeft = e.currentTarget.scrollLeft;
		if (
			(headRef?.current?.scrollWidth ?? 0) -
				(headRef?.current?.offsetWidth ?? 0) -
				(headRef?.current?.scrollLeft ?? 0) >
			0
		) {
			setShowFadeEdge(true);
		} else {
			setShowFadeEdge(false);
		}

		if (source === 'head' && bodyRef?.current) {
			bodyRef.current.scrollLeft = scrollLeft;
		} else if (headRef.current) {
			headRef.current.scrollLeft = scrollLeft;
		}
	};
	return (
		<>
			{filteredList?.length > 0 && !!header ? (
				<div className="relative">
					<div
						className={'sticky top-0 z-[4] rounded-t-2xl bg-white px-6 pt-4'}>
						<div
							className={
								'scrollbar z-40 !w-full overflow-x-scroll head [&::-webkit-scrollbar-track]:bg-transparent'
							}
							ref={headRef}
							onScroll={(e) => syncScroll(e, 'head')}>
							<div
								className={
									'sticky left-0 z-10 !h-[82px] !border-l-0 border-b border-r column'
								}
							/>
							<div className={'flex flex-row'}>
								{Object.entries(header)?.map(([k, v]) => (
									<div key={k} className={'flex flex-col'}>
										<div className={'border-b border-r pb-2'}>
											<Typography
												tag={'span'}
												className={`sticky left-[208px] truncate pl-4 capitalize`}>
												{k}
											</Typography>
										</div>
										<div className={'flex flex-row border-b'}>
											{v.map((day) => (
												<div
													key={day.toString()}
													className={`flex !h-12 flex-col !items-end border-r px-4 text-right column`}>
													<Typography
														variant={'caption_12px_400'}
														className={`whitespace-nowrap text-neutral-600 ${isWeekend(day) ? 'font-semibold' : 'font-normal'}`}>
														{format(day, 'EEE', { locale: vi })}
													</Typography>
													<Typography
														variant={'caption_12px_400'}
														className={`whitespace-nowrap text-neutral-600 ${isWeekend(day) ? 'font-semibold' : 'font-normal'}`}>
														{format(day, 'dd', { locale: vi })}
													</Typography>
												</div>
											))}
										</div>
									</div>
								))}
							</div>
						</div>
					</div>
					<div className={'mb-6 rounded-b-2xl bg-white px-6 pb-6'}>
						<div
							ref={bodyRef}
							onScroll={(e) => syncScroll(e, 'body')}
							className={
								'relative overflow-hidden overflow-x-scroll text-neutral-600 [&::-webkit-scrollbar]:hidden'
							}>
							<div className={'body'}>
								{filteredList?.map((room) => {
									const roomRate = rates?.find((rate) => rate.id === room.id);
									return (
										<div
											key={room?.id}
											className={
												'mt-6 [&>:nth-child(2)_>*:first-child]:!rounded-tl-lg [&>:nth-child(2)_>*:last-child]:!rounded-tr-lg'
											}>
											<div className={`top-[80px] mb-4 !h-fit row`}>
												<div
													className={
														'sticky left-0 flex !h-fit !w-fit gap-4 !border-0 !p-0 column'
													}>
													<Typography variant={'content_16px_700'}>
														{room?.name}
													</Typography>
													<Typography
														variant={'caption_12px_600'}
														className={
															'rounded-lg bg-green-50 px-4 py-1 text-accent-02'
														}>
														ID: #{room?.id}
													</Typography>
												</div>
											</div>
											<div className={`row`}>
												<div
													className={'sticky left-0 border-r border-t column'}>
													<Typography variant={'caption_12px_500'}>
														Trạng thái mở bán
													</Typography>
												</div>
												{room?.availability?.map(({ status, date }, index) => (
													<div
														key={index}
														className={`select-none border-r border-t px-1 column`}>
														<Typography
															onClick={() =>
																onToggleSingleRoom({
																	day: date,
																	room_id: room.id,
																	status: status === 'close' ? 'open' : 'close',
																})
															}
															variant={'caption_12px_600'}
															className={`cursor-pointer ${status === 'close' ? 'bg-red-50 text-alert-error-base' : 'bg-green-50 text-accent-02'} w-full rounded-full py-1 text-center`}>
															{status === 'close' ? 'Đóng' : 'Mở'}
														</Typography>
													</div>
												))}
											</div>
											<div className={`row`}>
												<div
													className={'sticky left-0 border-r border-t column'}>
													<Typography variant={'caption_12px_500'}>
														Số phòng trống tiêu chuẩn
													</Typography>
												</div>
												{room?.availability?.map(
													({ quantity, date }, index) => (
														<div
															id={`${room.id}-roomCount-${index}`}
															data-date={date}
															onPointerDown={(e) =>
																handlePointerDown(
																	e,
																	{
																		room_id: room.id,
																		value: quantity ?? room.quantity,
																		max: room.quantity,
																	},
																	'roomCount'
																)
															}
															onPointerMove={(e) =>
																handlePointerMove(e, room.id, 'roomCount')
															}
															onPointerUp={() =>
																handleContinuePauseAction(false)
															}
															key={index}
															className={
																'cursor-pointer select-none border-r border-t px-1 column'
															}>
															<Typography variant={'caption_12px_400'}>
																{quantity ?? room.quantity}
															</Typography>
														</div>
													)
												)}
											</div>
											{roomRate?.rate?.map((rate, rateIndex, array) => {
												return (
													<Fragment key={rateIndex}>
														<div
															className={`group row ${!params.filterPrice && roomRate?.maxOccupancy > 1 && 'hid'}`}>
															<div
																className={`sticky left-0 !h-12 border-r border-t !py-2 column ${rateIndex === array.length - 1 && 'group-[.hid]:!rounded-bl-lg group-[.hid]:!border-b'} ${roomRate?.maxOccupancy <= 1 && 'rounded-bl-lg border-b'}`}>
																<div className={'w-full'}>
																	<Typography
																		tag={'p'}
																		variant={'caption_12px_500'}
																		className={
																			'flex flex-row items-center gap-1'
																		}>
																		{roomRate?.maxOccupancy > 1 && (
																			<IconChevron
																				direction={'up'}
																				className={
																					'h-4 w-4 shrink-0 p-1 transition-transform'
																				}
																			/>
																		)}
																		<span className={'truncate'}>
																			{rate.name}
																		</span>
																	</Typography>
																	<div className={'flex flex-row gap-2 pl-5'}>
																		<Typography
																			tag={'span'}
																			variant={'caption_12px_500'}
																			className={
																				'flex flex-row items-center gap-1'
																			}>
																			<IconUser
																				color={GlobalUI.colors.neutrals['400']}
																				className={'h-3 w-2.5'}
																			/>
																			x{room.standard_guests}
																		</Typography>
																		{roomRate?.maxOccupancy > 1 && (
																			<button
																				onClick={() => {
																					onEditOccupancy({
																						room_id: room.id,
																						room_name:
																							room.name,
																						price_name: rate.name,
																						max_capacity:
																							roomRate?.maxOccupancy,
																						price_type_id: rate.rate_id,
																						standard_index:
																							room.standard_guests,
																						price_max: room.price_max,
																						price_min: room.price_min,
																						price_standard: room.price_standard,
																						data: room?.price_settings?.filter(
																							(item) =>
																								item.price_type_id ===
																								rate.rate_id
																						),
																					});
																				}}
																				className={`cursor-pointer text-secondary-500 ${TextVariants.caption_12px_400}`}>
																				Chỉnh sửa
																			</button>
																		)}
																	</div>
																</div>
															</div>
															{Object.entries(
																rate?.prices?.[room.standard_guests] ?? {}
															).map(([date, price], index, arr) => {
																return (
																	<div
																		id={`${room.id}-${rate.rate_id}-price-${index}`}
																		data-date={date}
																		onPointerDown={(e) =>
																			handlePointerDown(
																				e,
																				{
																					room_id: room.id,
																					value: price ?? NaN,
																					max: room.price_max,
																					min: room.price_min,
																					price_id: rate.rate_id,
																				},
																				'price'
																			)
																		}
																		onPointerMove={(e) =>
																			handlePointerMove(
																				e,
																				room.id,
																				'price',
																				rate.rate_id
																			)
																		}
																		onPointerUp={() =>
																			handleContinuePauseAction(false)
																		}
																		key={index}
																		className={`!h-12 cursor-pointer select-none border-r border-t px-1 column ${rateIndex === array.length - 1 && 'group-[.hid]:!border-b'} ${rateIndex === array.length - 1 && index === arr.length - 1 && `group-[.hid]:!rounded-br-lg ${roomRate?.maxOccupancy <= 1 && 'rounded-br-lg'}`} ${roomRate?.maxOccupancy <= 1 && 'border-b'}`}>
																		<Typography variant={'caption_12px_400'}>
																			{price
																				? Math.round(price / 1000) + 'K'
																				: '-'}
																		</Typography>
																	</div>
																);
															})}
														</div>
														{room?.max_capacity > 1 && (
															<div
																className={`transition-[visibility,max-height,opacity] ${rateIndex === array.length - 1 ? '[&>:last-child_>*:first-child]:!rounded-bl-lg [&>:last-child_>*:last-child]:!rounded-br-lg [&>:last-child_>*]:border-b' : ''}`}
																style={{
																	maxHeight: `${32 * (room?.max_capacity - 1)}px`,
																}}>
																{Object.entries(rate?.prices)
																	?.filter(
																		([key, _]) => +key !== room?.standard_guests
																	)
																	?.reverse()
																	?.map(([occupancyCount, occupancyPrice]) => (
																		<div key={occupancyCount} className={`row`}>
																			<div
																				className={
																					'sticky left-0 !h-8 border-r border-t column'
																				}>
																				<Typography
																					tag={'span'}
																					variant={'caption_12px_500'}
																					className={
																						'flex w-full flex-row items-center justify-center gap-1'
																					}>
																					<IconUser
																						color={
																							GlobalUI.colors.neutrals['400']
																						}
																						className={'h-3 w-2.5'}
																					/>
																					x{occupancyCount}
																				</Typography>
																			</div>
																			{Object.entries(occupancyPrice ?? {}).map(
																				([_, price], index) => (
																					<div
																						key={index}
																						className={`!h-8 border-r border-t px-1 column`}>
																						<Typography
																							variant={'caption_12px_400'}>
																							{price
																								? Math.round(price / 1000) + 'K'
																								: '-'}
																						</Typography>
																					</div>
																				)
																			)}
																		</div>
																	))}
															</div>
														)}
													</Fragment>
												);
											})}
										</div>
									);
								})}
							</div>
						</div>
					</div>
					<div
						className={`absolute bottom-4 right-0 top-4 z-[1] w-[63px] bg-gradient-to-r from-transparent to-white ${showFadeEdge ? 'block' : 'hidden'}`}></div>
					{!!wrapperElement && selecting?.action === false && (
						<AvailabilityCellsPopover
							open={true}
							anchor={wrapperElement}
							collisionBoundary={bodyRef.current}
							onClose={() => {
								setSelectedItems([]);
								setSelecting(undefined);
							}}
							onSubmit={(val) => {
								const children = wrapperElement?.children;
								if (children && children.length > 0) {
									const start = children[0].getAttribute('data-date');
									const end =
										children[children.length - 1].getAttribute('data-date');
									if (start && end) {
										if (selecting?.type === 'roomCount') {
											onUpdateRoomQuantity({
												start_date: start,
												end_date: end,
												room_id: selecting?.data?.room_id,
												val,
											})
												.then(() => {
													setSelectedItems([]);
													setSelecting(undefined);
												})
												.catch(() => {
													//do nothing
												});
										} else if (selecting?.type === 'price') {
											onUpdateRoomPrice({
												start_date: start,
												end_date: end,
												room_id: selecting?.data?.room_id,
												price_id: selecting?.data?.price_id ?? 0,
												val,
											})
												.then(() => {
													setSelectedItems([]);
													setSelecting(undefined);
												})
												.catch(() => {
													//do nothing
												});
										}
									}
								}
							}}
							type={selecting?.type}
							defaultValue={
								selectedItems?.[0] === selectedItems?.[1]
									? selecting?.data?.value
									: undefined
							}
							validate={{
								min: selecting?.data?.min,
								max: selecting?.data?.max,
							}}
						/>
					)}
				</div>
			) : (
				<Typography
					variant={'content_16px_600'}
					className={'rounded-lg bg-white py-6 text-center'}>
					Chọn khoảng ngày để hiển thị dữ liệu giá
				</Typography>
			)}
		</>
	);
};
