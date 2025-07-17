'use client';
import { IconClose } from '@/assets/Icons/outline';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import Typography from '@/components/shared/Typography';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormMessage,
} from '@/components/ui/form';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import {
	Sheet,
	SheetContent,
	SheetDescription,
	SheetHeader,
	SheetTitle,
} from '@/components/ui/sheet';
import { DateRangePicker } from '@/containers/price/common/DateRangePicker';
import {
	quickRoomToggleSchema,
	QuickRoomToggleType,
	quickRoomToggleValue,
} from '@/lib/schemas/type-price/quick-room-toggle';
import { weekDays } from '@/lib/schemas/type-price/room-availability-setting';
import { updateRoomStatus } from '@/services/room-config/updateRoomStatus';
import { ERoomStatus } from '@/services/room/getRoomList';
import { useAvailabilityCenterStore } from '@/store/availability-center/store';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomStore } from '@/store/room/store';
import { GlobalUI } from '@/themes/type';
import { zodResolver } from '@hookform/resolvers/zod';
import { format } from 'date-fns';
import { Controller, useForm } from 'react-hook-form';
import { toast } from 'sonner';

const QuickRoomToggle = ({
	open,
	onClose,
}: {
	open: boolean;
	onClose: () => void;
}) => {
	const roomList = useRoomStore((state) => state.roomList);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const fetchListConfig = useAvailabilityCenterStore(
		(state) => state.fetchListConfig
	);

	const form = useForm<QuickRoomToggleType>({
		resolver: zodResolver(quickRoomToggleSchema),
		defaultValues: quickRoomToggleValue,
	});

	const {
		reset,
		control,
		formState: { errors },
	} = form;

	const onSubmit = (values: QuickRoomToggleType) => {
		setLoading(true);
		updateRoomStatus({
			start_date: format(values?.date?.from, 'yyyy-MM-dd'),
			end_date: format(values?.date?.to, 'yyyy-MM-dd'),
			room_ids: values.room_ids,
			day_of_week: Object.fromEntries(
				values.day_of_week.map((day) => [day, values.status_room])
			),
		})
			.then(async (res) => {
				if (res.status) {
					toast.success('Thiết lập đóng/mở phòng nhanh thành công!');
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
				className={'min-w-[375px] overflow-y-auto p-8 md:min-w-[466px]'}
				hideButtonClose={true}>
				<SheetHeader>
					<SheetTitle></SheetTitle>
					<SheetDescription></SheetDescription>
				</SheetHeader>
				<div className={'flex items-center justify-between'}>
					<Typography tag={'h3'} variant={'headline_20px_700'}>
						Đóng/mở phòng nhanh
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
						className={'mt-8 space-y-8'}>
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
						</div>
						<div>
							<Typography tag={'h4'} variant={'content_16px_600'}>
								Áp dụng vào các ngày
							</Typography>
							{errors.day_of_week?.message && (
								<Typography
									tag="span"
									variant="caption_12px_500"
									className={'mt-2 text-red-500'}>
									{errors.day_of_week?.message}
								</Typography>
							)}
							<div className={'mt-4 grid grid-cols-4 gap-6'}>
								{weekDays.map((day, index) => (
									<Controller
										key={index}
										control={control}
										name="day_of_week"
										render={({ field }) => (
											<CheckBoxView
												id={`availability-${day}`}
												value={field.value.includes(
													day
												)}
												onValueChange={(val) => {
													const newValue = val
														? [...field.value, day]
														: field.value.filter(
																(val) =>
																	val !== day
															);

													field.onChange(newValue);
												}}>
												<Typography
													tag={'p'}
													variant={'caption_14px_400'}
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
								))}
							</div>
						</div>
						<div>
							<Typography tag={'h4'} variant={'content_16px_600'}>
								Loại phòng áp dụng
								<span className={'ml-2 text-red-500'}>*</span>
							</Typography>
							<Controller
								control={control}
								name={'room_ids'}
								render={({ field }) => (
									<div
										className={
											'mt-4 grid grid-cols-2 gap-4'
										}>
										{roomList
											?.filter(
												(room) =>
													room.status ===
													ERoomStatus.active
											)
											.map((type, index) => (
												<CheckBoxView
													key={index}
													id={type.name}
													value={
														field.value?.includes(
															type.id
														) || false
													}
													onValueChange={(val) => {
														const newArr = val
															? [
																	...(field?.value ||
																		[]),
																	type.id,
																]
															: (
																	field.value ||
																	[]
																).filter(
																	(val) =>
																		val !==
																		type.id
																);
														field.onChange(newArr);
													}}>
													<Typography
														tag={'p'}
														title={type.name}
														variant={
															'caption_14px_400'
														}
														className={
															'truncate text-nowrap text-neutral-600'
														}>
														{type.name ?? 'N/A'}
													</Typography>
												</CheckBoxView>
											))}
										<FieldErrorMessage
											errors={form.formState.errors}
											name={field.name}
											className={'col-span-2'}
										/>
									</div>
								)}
							/>
						</div>
						<div>
							<Typography tag={'h4'} variant={'content_16px_600'}>
								Trạng thái phòng
								<span className={'ml-2 text-red-500'}>*</span>
							</Typography>
							<Controller
								control={control}
								name={'status_room'}
								render={({ field }) => (
									<div className={'mt-4'}>
										<RadioGroup
											defaultValue={field.value}
											onChange={field.onChange}
											className={
												'grid grid-cols-2 gap-4'
											}>
											<div className="flex items-center space-x-2">
												<RadioGroupItem
													value="open"
													id="status-open"
													className={
														'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
													}
												/>
												<Label
													htmlFor="status-open"
													containerClassName={'mb-0'}
													className={
														'cursor-pointer text-neutral-600'
													}>
													Mở phòng
												</Label>
											</div>
											<div className="flex items-center space-x-2">
												<RadioGroupItem
													value="close"
													id="status-close"
													className={
														'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
													}
												/>
												<Label
													htmlFor="status-close"
													containerClassName={'mb-0'}
													className={
														'cursor-pointer text-neutral-600'
													}>
													Đóng phòng
												</Label>
											</div>
										</RadioGroup>
									</div>
								)}
							/>
						</div>
						<ButtonActionGroup
							className={'grid grid-cols-2 gap-4'}
							actionCancel={_onClose}
							titleBtnCancel={'Hủy'}
							titleBtnConfirm={'Áp dụng'}
						/>
					</form>
				</Form>
			</SheetContent>
		</Sheet>
	);
};

export default QuickRoomToggle;
