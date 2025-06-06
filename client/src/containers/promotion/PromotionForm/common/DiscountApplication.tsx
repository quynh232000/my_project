import React from 'react';
import Typography from '@/components/shared/Typography';
import { Controller, useFormContext } from 'react-hook-form';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Label } from '@/components/ui/label';
import { PromotionType } from '@/lib/schemas/discount/discount';
import { discountOptions } from '@/containers/promotion/data';
import { weekDays } from '@/lib/schemas/type-price/room-availability-setting';
import { Input } from '@/components/ui/input';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import {
	FormControl,
	FormField,
	FormItem,
	FormMessage,
} from '@/components/ui/form';

const DiscountApplication = () => {
	const { control, formState, unregister, register, setValue, watch } =
		useFormContext<PromotionType>();
	const formatPercent = (value: string) => {
		const val = value.replace(/\D/g, '');
		if (Number(val) < 0) return 0;
		if (Number(val) > 100) return 100;
		console.log(val);
		return Number(val);
	};
	return (
		<div className={'rounded-lg border border-blue-100 bg-white p-4'}>
			<Typography
				tag={'h2'}
				variant={'content_16px_600'}
				className={'text-neutral-600'}>
				Áp dụng giảm giá cho:
			</Typography>
			<Controller
				control={control}
				name={'discountType.type'}
				render={({ field }) => (
					<div className={'mt-4'}>
						<RadioGroup
							value={field.value}
							onValueChange={(val) => {
								field.onChange(val);
								if (val === 'day_of_weeks') {
									unregister('discountType.discount');
									register('discountType.specificDaysDiscount');
									const defaultDays = Array.from(weekDays, (day) => ({
										day_of_week: day,
										value: null,
									}));
									setValue('discountType.specificDaysDiscount', defaultDays);
								} else {
									unregister('discountType.specificDaysDiscount');
									register('discountType.discount');
								}
							}}>
							{discountOptions.map((option, index) => (
								<div key={index} className={'space-y-2'}>
									<div className="flex items-center space-x-2">
										<RadioGroupItem
											value={option.value}
											id={`type_room_${option.value}`}
											className={
												'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
											}
										/>
										<Label
											htmlFor={`type_room_${option.value}`}
											containerClassName={'mb-0'}
											className={'cursor-pointer text-neutral-600'}>
											{option.label}
										</Label>
									</div>
									{field.value === option.value &&
										(field.value === 'day_of_weeks' ? (
											<FormField
												control={control}
												name={'discountType.specificDaysDiscount'}
												render={({}) => (
													<FormItem>
														<div
															className={
																'ml-7 grid grid-cols-1 gap-4 lg:grid-cols-7'
															}>
															{weekDays.map((day, i) => {
																const currentValue =
																	watch(
																		'discountType.specificDaysDiscount'
																	)?.find((item) => item.day_of_week === day)
																		?.value ?? '';

																return (
																	<div key={i} className={'space-y-1'}>
																		<Typography
																			tag={'p'}
																			variant={'caption_14px_400'}
																			className={'text-neutral-600'}>
																			{day + 1 <= 7
																				? `Thứ ${day + 1}`
																				: 'Chủ nhật'}
																		</Typography>
																		<Input
																			value={currentValue}
																			onChange={(e) => {
																				if (formatPercent(e.target.value) > 0) {
																					setValue(
																						`discountType.specificDaysDiscount.${i}.value`,
																						formatPercent(e.target.value)
																					);
																				} else {
																					setValue(
																						`discountType.specificDaysDiscount.${i}.value`,
																						null
																					);
																				}
																			}}
																			placeholder={'% giảm giá'}
																			className={'h-10 px-3 py-2'}
																		/>
																		<FieldErrorMessage
																			errors={formState.errors}
																			name={field.name}
																		/>
																	</div>
																);
															})}
														</div>
														<FormMessage />
													</FormItem>
												)}
											/>
										) : (
											<FormField
												control={control}
												name={`discountType.discount`}
												render={({
													field: { value, onChange, ...fieldProps },
												}) => (
													<FormItem>
														<FormControl>
															<div className={'relative lg:w-[368px]'}>
																<Input
																	className={'h-[44px] w-full py-2 leading-6'}
																	inputMode={'numeric'}
																	placeholder="Nhập số % giảm giá"
																	endAdornment={'%'}
																	{...fieldProps}
																	value={value}
																	onChange={(e) => {
																		onChange(formatPercent(e.target.value));
																	}}
																/>
															</div>
														</FormControl>
														<FormMessage />
													</FormItem>
												)}
											/>
										))}
								</div>
							))}
						</RadioGroup>
						<FieldErrorMessage errors={formState.errors} name={field.name} />
					</div>
				)}
			/>
		</div>
	);
};

export default DiscountApplication;
