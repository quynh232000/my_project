'use client';
import React, { useEffect, useState } from 'react';
import {
	Sheet,
	SheetContent,
	SheetDescription,
	SheetHeader,
	SheetTitle,
} from '@/components/ui/sheet';
import Typography from '@/components/shared/Typography';
import { IconClose } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormMessage,
} from '@/components/ui/form';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { Controller, useForm } from 'react-hook-form';
import {
	createRoomAvailabilitySettingSchema,
	roomAvailabilityDefaultValue,
	RoomAvailabilitySettingType,
	weekDays,
} from '@/lib/schemas/type-price/room-availability-setting';
import { zodResolver } from '@hookform/resolvers/zod';
import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import { NumberInput } from '@/components/ui/number-input';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import { useLoadingStore } from '@/store/loading/store';
import { updateRoomQuantity } from '@/services/room-config/updateRoomQuantity';
import { format } from 'date-fns';
import { toast } from 'sonner';
import { useRoomStore } from '@/store/room/store';
import { ERoomStatus } from '@/services/room/getRoomList';
import { DateRangePicker } from '@/containers/price/common/DateRangePicker';
import { useAvailabilityCenterStore } from '@/store/availability-center/store';

const RoomAvailabilitySettings = ({
	open,
	onClose,
}: {
	open: boolean;
	onClose: () => void;
}) => {
	const setLoading = useLoadingStore((state) => state.setLoading);
	const roomList = useRoomStore((state) => state.roomList);
	const fetchListConfig = useAvailabilityCenterStore(
		(state) => state.fetchListConfig
	);
	const [schema, setSchema] = useState(
		createRoomAvailabilitySettingSchema(9999)
	);

	const form = useForm<RoomAvailabilitySettingType>({
		mode: 'onChange',
		resolver: zodResolver(schema),
		defaultValues: roomAvailabilityDefaultValue,
	});

	const {
		control,
		watch,
		reset,
		formState: { errors },
	} = form;
	const dayOfWeek = watch('day_of_week');

	const watchRoomIds = watch('room_ids');
	useEffect(() => {
		const rooms =
			roomList?.filter((room) => watchRoomIds.includes(room.id)) ?? [];
		const maxQuantityRoom =
			Math.min(...rooms.map((room) => room.max_capacity)) ?? 9999;
		setSchema(createRoomAvailabilitySettingSchema(maxQuantityRoom));
	}, [roomList, watchRoomIds]);

	const onSubmit = (values: RoomAvailabilitySettingType) => {
		setLoading(true);
		updateRoomQuantity({
			start_date: format(values?.date?.from, 'yyyy-MM-dd'),
			end_date: format(values?.date?.to, 'yyyy-MM-dd'),
			room_ids: values.room_ids,
			day_of_week: Object.fromEntries(
				Object.entries(values.day_of_week)
					.filter(([_, val]) => val.active)
					.map(([key, val]) => [key, val.count])
			),
		})
			.then(async (res) => {
				if (res.status) {
					toast.success('Thiết lập phòng trống thành công!');
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
		reset();
		onClose();
	};

	return (
		<Sheet onOpenChange={(open) => !open && _onClose()} open={open}>
			<SheetContent
				className={
					'scrollbar min-w-[375px] overflow-y-auto scroll-smooth p-0 pt-8 md:min-w-[466px]'
				}
				hideButtonClose={true}>
				<SheetHeader className={'hidden'}>
					<SheetTitle></SheetTitle>
					<SheetDescription></SheetDescription>
				</SheetHeader>
				<div className={'flex items-center justify-between px-8'}>
					<Typography tag={'h3'} variant={'headline_20px_700'}>
						Thiết lập phòng trống
					</Typography>
					<span
						onClick={_onClose}
						className={'cursor-pointer rounded-full bg-neutral-50 p-2'}>
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
												className={'mt-4'}
												disabled={{
													before: new Date(),
												}}
												dateRange={{
													from: field?.value?.from,
													to: field?.value?.to,
												}}
												onSelectDateRange={field.onChange}
											/>
										</FormControl>
										{errors?.date?.message ? (
											<FormMessage />
										) : (
											<FieldErrorMessage
												errors={errors}
												name={errors?.date?.from ? 'date.from' : 'date.to'}
											/>
										)}
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
										(_, i) => `day_of_week.${i}.count`
									) as `day_of_week.${number}.count`[],
								}}
								render={({ field }) => (
									<FormItem className={'space-y-2'}>
										<input
											className={'absolute h-0 w-0 overflow-hidden'}
											ref={field.ref}
										/>
										<FormMessage />
										<FormControl>
											<div className={'!mt-4 grid grid-cols-2 gap-4 !bg-white'}>
												{roomList
													?.filter((room) => room.status === ERoomStatus.active)
													?.map((room, index) => (
														<CheckBoxView
															key={index}
															id={String(room.id)}
															value={!!field.value?.includes(room.id)}
															onValueChange={(value) => {
																const newArr = value
																	? [...(field?.value || []), room.id]
																	: (field.value || []).filter(
																			(val) => val !== room.id
																		);
																field.onChange(newArr);
															}}>
															<Typography
																tag={'p'}
																variant={'caption_14px_400'}
																title={room.name}
																className={
																	'truncate text-nowrap text-neutral-600'
																}>
																{room.name ?? 'N/A'}
															</Typography>
														</CheckBoxView>
													))}
											</div>
										</FormControl>
									</FormItem>
								)}
							/>
						</div>
						<div>
							<Typography tag={'h4'} variant={'content_16px_600'}>
								Thiết lập số phòng trống
							</Typography>
							<Controller
								control={control}
								render={({ field }) => (
									<input
										className={'absolute h-0 w-0 overflow-hidden'}
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
							<FieldErrorMessage
								errors={form.formState.errors}
								name={'availability'}
							/>
							<div className={'mt-4 space-y-4'}>
								{weekDays.map((day, index) => (
									<div
										key={index}
										className={
											'grid grid-cols-[100%_,1fr] items-center gap-4 lg:grid-cols-[96px_,1fr]'
										}>
										<Controller
											control={form.control}
											name={`day_of_week.${day}.active`}
											render={({ field }) => (
												<CheckBoxView
													id={`availability.${day}.active`}
													value={field.value}
													onValueChange={(val) => {
														field.onChange(val);
														form.clearErrors(
															val ? 'day_of_week' : `day_of_week.${day}.count`
														);
													}}>
													<Typography
														tag={'p'}
														variant={'caption_14px_400'}
														className={'text-neutral-600'}>
														{day + 1 < 8 ? `Thứ ${day + 1}` : 'Chủ nhật'}
													</Typography>
												</CheckBoxView>
											)}
										/>

										<FormField
											control={form.control}
											name={`day_of_week.${day}.count`}
											render={({ field: { onChange, value, ...props } }) => (
												<FormItem>
													<div className={'relative'}>
														<FormControl>
															<NumberInput
																disabled={!dayOfWeek?.[day]?.active}
																placeholder="2"
																inputMode="numeric"
																suffix=""
																maxLength={4}
																className="h-[52px] rounded-xl py-2 leading-6"
																{...props}
																value={value}
																onValueChange={(e) => {
																	onChange(
																		e.value.length === 0 ? NaN : Number(e.value)
																	);
																}}
																endAdornment={'phòng'}
															/>
														</FormControl>
													</div>
												</FormItem>
											)}
										/>
										<FieldErrorMessage
											className={'col-start-2 mt-0'}
											errors={errors}
											name={`day_of_week.${day}.count`}
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

export default RoomAvailabilitySettings;
