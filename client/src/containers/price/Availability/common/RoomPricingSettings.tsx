'use client';
import { IconClose } from '@/assets/Icons/outline';
import IconQuestion from '@/assets/Icons/outline/IconQuestion';
import { AppTooltip } from '@/components/shared/AppTooltip/AppTooltip';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormMessage,
} from '@/components/ui/form';
import { Label } from '@/components/ui/label';
import { NumberInput } from '@/components/ui/number-input';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import {
	Sheet,
	SheetContent,
	SheetDescription,
	SheetHeader,
	SheetTitle,
} from '@/components/ui/sheet';
import { DateRangePicker } from '@/containers/price/common/DateRangePicker';
import { weekDays } from '@/lib/schemas/type-price/room-availability-setting';
import {
	createRoomPricingSettingSchema,
	roomPricingDefaultValue,
	RoomPricingSettingType,
} from '@/lib/schemas/type-price/room-pricing-setting';
import { updateRoomPrice } from '@/services/room-config/updateRoomPrice';
import { ERoomStatus, IRoomItem } from '@/services/room/getRoomList';
import { useAvailabilityCenterStore } from '@/store/availability-center/store';
import { useLoadingStore } from '@/store/loading/store';
import { usePricesStore } from '@/store/prices/store';
import { useRoomStore } from '@/store/room/store';
import { GlobalUI } from '@/themes/type';
import { zodResolver } from '@hookform/resolvers/zod';
import { format } from 'date-fns';
import { useEffect, useState } from 'react';
import { Controller, useForm } from 'react-hook-form';
import { toast } from 'sonner';

const RoomPricingSettings = ({
	open,
	onClose,
}: {
	open: boolean;
	onClose: () => void;
}) => {
	const priceData = usePricesStore((state) => state.data);
	const roomList = useRoomStore((state) => state.roomList);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const fetchListConfig = useAvailabilityCenterStore(
		(state) => state.fetchListConfig
	);
	const [availableRoom, setAvailableRoom] = useState<IRoomItem[]>([]);
	const [schema, setSchema] = useState(
		createRoomPricingSettingSchema({
			price_min: 0,
			price_max: 999999999,
		})
	);

	const form = useForm<RoomPricingSettingType>({
		mode: 'onChange',
		resolver: zodResolver(schema),
		defaultValues: roomPricingDefaultValue,
	});

	const {
		control,
		watch,
		setValue,
		getValues,
		formState: { errors },
	} = form;

	const watchRoomIds = form.watch('room_ids');
	const day_of_week = watch('day_of_week');
	const priceIds = watch('price_type');

	useEffect(() => {
		const rooms = availableRoom.filter((room) =>
			watchRoomIds.includes(room.id)
		);
		const price_min = Math.max(...rooms.map((room) => room.price_min)) ?? 0;
		const price_max =
			Math.min(...rooms.map((room) => room.price_max)) ?? 999999999;
		setSchema(
			createRoomPricingSettingSchema({
				price_min,
				price_max,
			})
		);
	}, [availableRoom, watchRoomIds]);

	useEffect(() => {
		form.reset(form.getValues(), { keepValues: true });
	}, [schema]);

	useEffect(() => {
		const selectableRoom =
			roomList?.filter(
				(room) =>
					(room.status === ERoomStatus.active &&
						priceIds?.[0] === 0) ||
					room?.price_types
						?.map((item) => item.id)
						?.includes(priceIds?.[0])
			) ?? [];
		const selectableRoomIds = selectableRoom?.map((room) => room.id);
		const selectedRoom = getValues('room_ids');
		setValue(
			'room_ids',
			selectedRoom?.filter((ids) => selectableRoomIds?.includes(ids))
		);
		setAvailableRoom(selectableRoom);
	}, [priceIds, roomList]);

	const onSubmit = (values: RoomPricingSettingType) => {
		setLoading(true);
		updateRoomPrice({
			start_date: format(values?.date?.from, 'yyyy-MM-dd'),
			end_date: format(values?.date?.to, 'yyyy-MM-dd'),
			is_overwrite: values?.is_overwrite,
			room_ids: values.room_ids,
			price_type: values.price_type,
			day_of_week: Object.fromEntries(
				Object.entries(values.day_of_week)
					.filter(([_, val]) => val.active)
					.map(([key, val]) => [key, val.price])
			),
		})
			.then(async (res) => {
				if (res.status) {
					toast.success('Thiết lập giá phòng thành công!');
					_onClose();
					await fetchListConfig();
				} else {
					toast.error(res.message);
				}
			})
			.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
			.finally(() => setLoading(false));
	};

	const _onClose = () => {
		form.reset();
		onClose();
	};

	return (
		<Sheet onOpenChange={(open) => !open && _onClose()} open={open}>
			<SheetContent
				className={
					'scrollbar min-w-[375px] overflow-y-auto scroll-smooth p-0 md:min-w-[466px]'
				}
				hideButtonClose={true}>
				<SheetHeader className={'hidden'}>
					<SheetTitle></SheetTitle>
					<SheetDescription></SheetDescription>
				</SheetHeader>
				<div className={'flex items-center justify-between px-8 pt-8'}>
					<Typography tag={'h3'} variant={'headline_20px_700'}>
						Thiết lập giá
					</Typography>
					<span
						onClick={_onClose}
						className={
							'cursor-pointer rounded-full bg-neutral-50 p-2'
						}>
						<IconClose
							className={'size-4'}
							color={GlobalUI.colors.neutrals['5']}
						/>
					</span>
				</div>

				<Form {...form}>
					<form
						onSubmit={form.handleSubmit(onSubmit)}
						className={'mt-8 space-y-8 px-8'}>
						<div>
							<Typography tag={'h4'} variant={'content_16px_600'}>
								Khoảng ngày
							</Typography>
							<FormField
								name={'date'}
								control={control}
								render={({ field }) => (
									<FormItem className={'space-y-2'}>
										<FormControl>
											<DateRangePicker
												showSummaryAndSearch={true}
												disabled={{
													before: new Date(),
												}}
												className={'mt-4'}
												dateRange={{
													from: field?.value?.from,
													to: field?.value?.to,
												}}
												onSelectDateRange={
													field.onChange
												}
											/>
										</FormControl>
										{errors?.date?.message ? (
											<FormMessage />
										) : (
											<FieldErrorMessage
												errors={errors}
												name={
													errors?.date?.from
														? 'date.from'
														: 'date.to'
												}
											/>
										)}
									</FormItem>
								)}
							/>
							<FormField
								name={'is_overwrite'}
								control={control}
								render={({ field }) => (
									<FormItem className={'space-y-2'}>
										<FormControl>
											<CheckBoxView
												value={field.value}
												containerClassName={'mt-4'}
												onValueChange={field.onChange}>
												<Typography
													tag={'p'}
													variant={'caption_14px_400'}
													className={
														'text-nowrap text-neutral-600'
													}>
													Cho phép ghi đè giá cũ trong
													khoảng thời gian chọn
												</Typography>
												<AppTooltip
													icon={<IconQuestion />}
													content={
														'Giá đã thiết lập trước đó trong khoảng thời gian này sẽ được thay bằng giá mới'
													}
													contentProps={{
														side: 'bottom',
														className:
															'bg-neutral-900 border-none p-2 w-[309px] text-center *:text-white',
													}}
													arrow={true}
												/>
											</CheckBoxView>
										</FormControl>
										{errors?.date?.message ? (
											<FormMessage />
										) : (
											<FieldErrorMessage
												errors={errors}
												name={
													errors?.date?.from
														? 'date.from'
														: 'date.to'
												}
											/>
										)}
									</FormItem>
								)}
							/>
						</div>
						<div>
							<Typography tag={'h4'} variant={'content_16px_600'}>
								Loại giá áp dụng
								<span className={'ml-2 text-red-500'}>*</span>
							</Typography>
							<FormField
								name={'price_type'}
								control={control}
								render={({ field }) => (
									<FormItem className={'mt-4'}>
										<input
											className={
												'absolute h-0 w-0 overflow-hidden'
											}
											ref={field.ref}
										/>
										<FormMessage className={'mt-4'} />
										<FormControl>
											<RadioGroup
												className="flex flex-wrap gap-x-0 !bg-white"
												value={String(field.value[0])}
												onValueChange={(val) =>
													field.onChange([+val])
												}>
												<div className="flex h-fit w-1/2 items-center space-x-2 pr-4">
													<RadioGroupItem
														id="standard"
														value={`0`}
													/>
													<Label
														htmlFor="standard"
														containerClassName={
															'm-0'
														}
														className={`cursor-pointer ${TextVariants.caption_14px_400}`}>
														Giá tiêu chuẩn
													</Label>
												</div>
												{priceData?.map((priceType) => (
													<div
														className="flex h-fit w-1/2 items-center space-x-2 pr-4"
														key={priceType.id}>
														<RadioGroupItem
															id={priceType.name}
															value={String(
																priceType.id
															)}
														/>
														<Label
															htmlFor={
																priceType.name
															}
															containerClassName={
																'm-0'
															}
															className={`cursor-pointer ${TextVariants.caption_14px_400}`}>
															{priceType.name}
														</Label>
													</div>
												))}
											</RadioGroup>
										</FormControl>
									</FormItem>
								)}
							/>
						</div>
						<div>
							<Typography tag={'h4'} variant={'content_16px_600'}>
								Loại phòng áp dụng
								<span className={'ml-2 text-red-500'}>*</span>
							</Typography>
							<FormField
								name={'room_ids'}
								control={control}
								rules={{
									deps: Array.from({ length: 7 }).map(
										(_, i) => `day_of_week.${i}.price`
									) as `day_of_week.${number}.price`[],
								}}
								render={({ field }) => (
									<FormItem className={'space-y-0'}>
										<input
											className={
												'absolute h-0 w-0 overflow-hidden'
											}
											ref={field.ref}
										/>
										<FormMessage className={'!mt-4'} />
										<FormControl>
											<div
												className={
													'flex flex-wrap !bg-white'
												}>
												{availableRoom?.map(
													(type, index) => (
														<CheckBoxView
															containerClassName={`w-1/2 mt-4 ${index % 2 === 0 ? 'pr-2' : ''}`}
															key={index}
															id={type.name}
															value={
																field.value?.includes(
																	type.id
																) || false
															}
															onValueChange={(
																val
															) => {
																const newArr =
																	val
																		? [
																				...(field?.value ||
																					[]),
																				type.id,
																			]
																		: (
																				field.value ||
																				[]
																			).filter(
																				(
																					val: number
																				) =>
																					val !==
																					type.id
																			);
																field.onChange(
																	newArr
																);
															}}>
															<Typography
																tag={'p'}
																title={
																	type.name
																}
																variant={
																	'caption_14px_400'
																}
																className={
																	'truncate text-nowrap text-neutral-600'
																}>
																{type.name ??
																	'N/A'}
															</Typography>
														</CheckBoxView>
													)
												)}
												{availableRoom?.length ===
													0 && (
													<Typography
														className={
															'mx-auto text-accent-03'
														}>
														{priceIds?.length > 0
															? 'Không có phòng nào áp dụng loại giá trên'
															: 'Vui lòng chọn trước loại giá'}
													</Typography>
												)}
											</div>
										</FormControl>
									</FormItem>
								)}
							/>
						</div>
						<div>
							<Typography tag={'h4'} variant={'content_16px_600'}>
								Thiết lập giá
							</Typography>
							<Controller
								control={control}
								render={({ field }) => (
									<input
										className={
											'absolute h-0 w-0 overflow-hidden'
										}
										ref={field.ref}
									/>
								)}
								name={'day_of_week'}
							/>
							{errors.day_of_week?.root?.message && (
								<Typography
									tag="span"
									variant="caption_12px_500"
									className={'mt-2 text-red-500'}>
									{errors.day_of_week?.root?.message}
								</Typography>
							)}
							<div className={'mt-4 grid gap-4'}>
								{weekDays.map((day, index) => (
									<div
										key={index}
										className={
											'grid w-full grid-cols-[100%_,1fr] items-center gap-x-4 gap-y-2 lg:grid-cols-[96px_,1fr]'
										}>
										<Controller
											control={form.control}
											name={`day_of_week.${day}.active`}
											render={({ field }) => (
												<CheckBoxView
													id={`day_of_week.${day}.active`}
													value={field.value}
													onValueChange={(e) => {
														field.onChange(e);
														form.clearErrors(
															e
																? 'day_of_week'
																: `day_of_week.${day}.price`
														);
													}}>
													<Typography
														tag={'p'}
														variant={
															'caption_14px_400'
														}
														className={
															'text-nowrap text-neutral-600'
														}>
														{day + 1 < 8
															? `Thứ ${day + 1}`
															: 'Chủ nhật'}
													</Typography>
												</CheckBoxView>
											)}
										/>
										<FormField
											control={form.control}
											name={`day_of_week.${day}.price`}
											render={({
												field: {
													onChange,
													value,
													...props
												},
											}) => (
												<FormItem>
													<div className={'relative'}>
														<FormControl>
															<NumberInput
																disabled={
																	!day_of_week?.[
																		day
																	]?.active
																}
																placeholder="1,500,000"
																inputMode="numeric"
																suffix=""
																maxLength={11}
																className="h-[52px] rounded-xl py-2 leading-6"
																{...props}
																value={value}
																onValueChange={(
																	e
																) => {
																	onChange(
																		e.value
																			.length ===
																			0
																			? NaN
																			: Number(
																					e.value
																				)
																	);
																}}
																endAdornment={
																	'VND'
																}
															/>
														</FormControl>
													</div>
												</FormItem>
											)}
										/>
										<FieldErrorMessage
											className={'col-start-2 mt-0'}
											errors={errors}
											name={`day_of_week.${day}.price`}
										/>
									</div>
								))}
							</div>
						</div>
					</form>
					<ButtonActionGroup
						className={
							'sticky bottom-0 mt-0 grid grid-cols-2 gap-4 bg-white px-8 pb-8 pt-6'
						}
						actionCancel={_onClose}
						actionSubmit={form.handleSubmit(onSubmit)}
						titleBtnCancel={'Hủy'}
						titleBtnConfirm={'Áp dụng'}
					/>
				</Form>
			</SheetContent>
		</Sheet>
	);
};

export default RoomPricingSettings;
