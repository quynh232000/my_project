import React, { useEffect } from 'react';
import { Controller, useFormContext } from 'react-hook-form';
import { PromotionType } from '@/lib/schemas/discount/discount';
import Typography from '@/components/shared/Typography';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Label } from '@/components/ui/label';
import { InfoIcon } from 'lucide-react';
import { GlobalUI } from '@/themes/type';
import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import { usePricesStore } from '@/store/prices/store';
import { useLoadingStore } from '@/store/loading/store';

const PromotionPriceType = () => {
	const { control, formState, watch, setValue } =
		useFormContext<PromotionType>();
	const { data: priceTypeList, fetchPrices } = usePricesStore();
	const setLoading = useLoadingStore((state) => state.setLoading);
	useEffect(() => {
		if (!priceTypeList) {
			setLoading(true);
			fetchPrices().finally(() => setLoading(false));
		}
	}, [priceTypeList]);
	return (
		<div className={'rounded-lg border border-blue-100 bg-white p-4'}>
			<Typography
				tag={'h2'}
				variant={'content_16px_600'}
				className={'text-neutral-600'}>
				Loại giá nào sẽ được áp dụng khuyến mãi này?
			</Typography>
			<div className={'mt-4'}>
				<Controller
					control={control}
					name={'priceType.type'}
					render={({ field }) => (
						<RadioGroup
							value={field.value}
							onValueChange={(value) => {
								field.onChange(value);
								if (value === 'all' && priceTypeList) {
									setValue(
										'priceType.price_type_ids',
										priceTypeList.map((priceType) => priceType.id) as number[]
									);
								}
							}}>
							<div className="flex items-center space-x-2">
								<RadioGroupItem
									value="all"
									id="type_price_all"
									className={
										'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
									}
								/>
								<Label
									htmlFor="type_price_all"
									containerClassName={'mb-0'}
									className={'cursor-pointer text-neutral-600'}>
									Tất cả loại giá
								</Label>
							</div>
							<div className="flex items-center space-x-4">
								<div className={'flex items-center space-x-2'}>
									<RadioGroupItem
										value="specific"
										id="type_price_specific"
										className={
											'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
										}
									/>
									<Label
										htmlFor="type_price_specific"
										containerClassName={'mb-0'}
										className={'cursor-pointer text-neutral-600'}>
										Chọn loại giá
									</Label>
								</div>
								<Typography
									tag={'span'}
									variant={'caption_12px_600'}
									className={
										'flex items-center gap-2 rounded-lg bg-secondary-00 px-3 py-2 text-secondary-500'
									}>
									<InfoIcon
										className={'size-4'}
										color={GlobalUI.colors.secondary['500']}
									/>
									Chọn ít nhất một loại giá
								</Typography>
							</div>
						</RadioGroup>
					)}
				/>
				{watch('priceType.type') === 'specific' && (
					<Controller
						control={control}
						name={'priceType.price_type_ids'}
						render={({ field }) => (
							<div className={'mt-4 pl-7'}>
								<div
									className={
										'flex flex-wrap items-center gap-6 md:flex-nowrap'
									}>
									{priceTypeList &&
										priceTypeList.map((priceType, index) => (
											<CheckBoxView
												value={field.value?.includes(priceType.id as number)}
												onValueChange={(val) => {
													const newArr = val
														? [...(field?.value || []), priceType.id]
														: (field.value || []).filter(
																(val) => val !== priceType.id
															);
													setValue(field.name, newArr as number[], {
														shouldValidate: true,
													});
												}}
												id={priceType.name}
												key={index}>
												<Typography
													tag={'p'}
													variant={'caption_14px_400'}
													className={'text-neutral-600'}>
													{priceType.name}
												</Typography>
											</CheckBoxView>
										))}
								</div>
								<FieldErrorMessage
									errors={formState.errors}
									name={field.name}
								/>
							</div>
						)}
					/>
				)}
			</div>
		</div>
	);
};

export default PromotionPriceType;
