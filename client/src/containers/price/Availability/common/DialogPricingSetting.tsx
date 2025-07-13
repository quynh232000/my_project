import React, { useEffect } from 'react';
import {
	Dialog,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import Typography from '@/components/shared/Typography';
import { IconClose, IconUser } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { useForm } from 'react-hook-form';
import {
	createDialogPricingSettingSchema,
	DialogPricingSettingType,
} from '@/lib/schemas/type-price/dialog-pricing-setting';
import { zodResolver } from '@hookform/resolvers/zod';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormMessage,
} from '@/components/ui/form';
import { IRoomPriceSetting } from '@/containers/price/Availability';
import { NumberInput } from '@/components/ui/number-input';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { Switch } from '@/components/ui/switch';
import { useLoadingStore } from '@/store/loading/store';
import { updateRoomOccupancyPrice } from '@/services/room-config/updateRoomOccupancyPrice';
import { toast } from 'sonner';
import { useAvailabilityCenterStore } from '@/store/availability-center/store';

const DialogPricingSetting = ({
	open,
	onClose,
	priceSetting,
}: {
	open: boolean;
	onClose: () => void;
	priceSetting?: IRoomPriceSetting;
}) => {
	const setLoading = useLoadingStore((state) => state.setLoading);
	const fetchListConfig = useAvailabilityCenterStore(
		(state) => state.fetchListConfig
	);

	const schema = createDialogPricingSettingSchema({
		price_min: priceSetting?.price_min ?? 0,
		price_max: priceSetting?.price_max ?? 0,
		price_standard: priceSetting?.price_standard ?? 0,
		standard_capacity: priceSetting?.standard_index ?? 0,
	});

	const form = useForm<DialogPricingSettingType>({
		mode: 'onChange',
		resolver: zodResolver(schema),
	});
	const { control, reset, setValue, watch, clearErrors } = form;

	const onSubmit = (values: DialogPricingSettingType) => {
		setLoading(true);
		updateRoomOccupancyPrice({
			...values,
			data: values?.data
				?.filter((dat) => !!dat)
				?.map((dat) => ({
					...dat,
					price: dat?.status === 'inactive' ? 0 : dat?.price,
				})),
		})
			.then(async (res) => {
				if (res.status) {
					toast.success('Thiết lập giá phụ thu thành công!');
					onClose();
					await fetchListConfig();
				} else {
					toast.error(res.message);
				}
			})
			.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
			.finally(() => setLoading(false));
	};

	useEffect(() => {
		if (!!priceSetting) {
			reset({
				room_id: priceSetting.room_id,
				price_type_id: priceSetting.price_type_id,
				data: Array.from({ length: priceSetting.max_capacity }).map(
					(_, i) => {
						return priceSetting.max_capacity - i ===
							priceSetting.standard_index
							? undefined
							: {
									capacity: priceSetting.max_capacity - i,
									price: NaN,
									status: 'inactive',
								};
					}
				),
			});
			priceSetting.data?.forEach((currentPrice) => {
				currentPrice.capacity !== priceSetting.standard_index &&
					setValue(
						`data.${priceSetting.max_capacity - currentPrice.capacity}`,
						currentPrice
					);
			});
		}
	}, [priceSetting, reset, setValue]);

	return (
		<Dialog open={open} onOpenChange={(open) => !open && onClose()}>
			<DialogHeader className={'hidden'}>
				<DialogTitle></DialogTitle>
				<DialogDescription></DialogDescription>
			</DialogHeader>
			<DialogContent
				className={'w-[80vw] overflow-y-auto p-0 md:min-w-[888px]'}
				hideButtonClose={true}>
				<ScrollArea className="max-h-[90vh] p-6">
					<div className={'flex items-center justify-between'}>
						<Typography tag={'h3'} variant={'headline_20px_700'}>
							Thiết lập giá
						</Typography>
						<span
							onClick={() => onClose()}
							className={
								'cursor-pointer rounded-full bg-neutral-50 p-2'
							}>
							<IconClose
								className={'size-4'}
								color={GlobalUI.colors.neutrals['5']}
							/>
						</span>
					</div>
					<Typography
						tag={'p'}
						variant={'caption_14px_400'}
						className={'mt-4 text-neutral-600'}>
						Giá có thể thay đổi theo số lượng khách. Bạn có thể đặt
						mức giảm giá cố định, theo phần trăm và quyết định cách
						tính giá cho từng nhóm khách.
					</Typography>
					<Form {...form}>
						<form onSubmit={form.handleSubmit(onSubmit)}>
							<div className={'mt-4 rounded-3xl bg-blue-200 p-4'}>
								<div className={'rounded-lg bg-white p-4'}>
									<Typography
										variant={'content_16px_700'}
										tag={'h4'}
										className={'text-neutral-600'}>
										{priceSetting?.room_name}
									</Typography>
									<Typography
										variant={'caption_14px_500'}
										tag={'p'}
										className={'text-neutral-600'}>
										{priceSetting?.price_name}
									</Typography>

									<div className={'mt-4 rounded-lg'}>
										<div
											className={
												'flex items-center px-6 py-3'
											}>
											<div className={'w-[144px]'}>
												<Typography
													tag={'span'}
													variant={'caption_14px_600'}
													className={
														'text-neutral-600'
													}>
													Sức chứa
												</Typography>
											</div>
											<div className={'flex-1 px-10'}>
												<Typography
													tag={'span'}
													variant={'caption_14px_600'}
													className={
														'text-neutral-600'
													}>
													Giá
												</Typography>
											</div>
										</div>
										{priceSetting?.max_capacity &&
											Array.from({
												length:
													priceSetting?.max_capacity ??
													0,
											})?.map((_, i) => {
												const isActive =
													priceSetting.max_capacity -
														i ===
														priceSetting.standard_index ||
													watch(
														`data.${i}.status`
													) === 'active';
												return (
													<div
														key={i}
														className={'flex py-4'}>
														<div
															className={
																'flex w-[208px] items-center gap-2'
															}>
															<IconUser
																className={
																	'size-4 text-neutral-400'
																}
															/>
															<Typography
																tag={'span'}
																variant={
																	'caption_12px_500'
																}
																className={`text-neutral-600 transition-[opacity] ${!isActive && 'opacity-50'}`}>
																x
																{priceSetting?.max_capacity -
																	i}
																{i === 0
																	? ' (Tối đa)'
																	: priceSetting.max_capacity -
																				i ===
																		  priceSetting.standard_index
																		? ' (Tiêu chuẩn)'
																		: ''}
															</Typography>
														</div>
														<div
															className={`flex flex-1 items-center gap-6 transition-[opacity] ${!isActive && 'opacity-50'}`}>
															<Typography
																tag={'span'}
																variant={
																	'caption_14px_400'
																}
																className={
																	'text-neutral-600'
																}>
																{priceSetting.max_capacity -
																	i >
																priceSetting?.standard_index
																	? 'Tăng thêm trên giá tiêu chuẩn'
																	: priceSetting.max_capacity -
																				i <
																		  priceSetting?.standard_index
																		? 'Giảm thêm trên giá tiêu chuẩn'
																		: 'Giá tiêu chuẩn'}
															</Typography>
															{priceSetting.max_capacity -
																i !==
																priceSetting.standard_index && (
																<FormField
																	name={`data.${i}.price`}
																	control={
																		control
																	}
																	rules={{}}
																	render={({
																		field: {
																			value,
																			onChange,
																			...props
																		},
																	}) => (
																		<FormItem
																			className={
																				'max-w-[218px] space-y-0'
																			}>
																			<div
																				className={
																					'relative'
																				}>
																				<FormControl>
																					<NumberInput
																						disabled={
																							!isActive
																						}
																						placeholder="1,200,000đ"
																						inputMode={
																							'numeric'
																						}
																						suffix={
																							'đ'
																						}
																						value={
																							value
																						}
																						maxLength={
																							11
																						}
																						className={
																							'h-10 py-2 leading-6'
																						}
																						{...props}
																						endAdornment={
																							'VND'
																						}
																						onValueChange={(
																							e
																						) => {
																							onChange(
																								e
																									.value
																									.length ===
																									0
																									? NaN
																									: Number(
																											e.value
																										)
																							);
																						}}
																					/>
																				</FormControl>
																			</div>
																			<FormMessage className="!mt-1" />
																		</FormItem>
																	)}
																/>
															)}
														</div>
														{priceSetting.max_capacity -
															i !==
															priceSetting.standard_index && (
															<FormField
																name={`data.${i}.status`}
																control={
																	control
																}
																render={({
																	field,
																}) => (
																	<FormItem
																		className={
																			'flex items-center'
																		}>
																		<FormControl>
																			<Switch
																				checked={
																					field.value ===
																					'active'
																				}
																				onCheckedChange={(
																					val
																				) => {
																					if (
																						!val
																					) {
																						clearErrors();
																						setValue(
																							`data.${i}.price`,
																							NaN
																						);
																					}
																					field.onChange(
																						val
																							? 'active'
																							: 'inactive'
																					);
																				}}
																			/>
																		</FormControl>
																	</FormItem>
																)}
															/>
														)}
													</div>
												);
											})}
									</div>
								</div>
							</div>
							<ButtonActionGroup
								className={'mt-4'}
								actionCancel={() => onClose()}
								titleBtnCancel={'Hủy bỏ'}
								titleBtnConfirm={'Áp dụng'}
							/>
						</form>
					</Form>
					<ScrollBar />
				</ScrollArea>
			</DialogContent>
		</Dialog>
	);
};

export default DialogPricingSetting;
