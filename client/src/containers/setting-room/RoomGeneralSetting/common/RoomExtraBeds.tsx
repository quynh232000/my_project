'use client';
import React, { useEffect } from 'react';
import Typography from '@/components/shared/Typography';
import { Controller, useFormContext, useWatch } from 'react-hook-form';
import { Label } from '@/components/ui/label';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import { cn } from '@/lib/utils';
import { ageRanges, feeTypes } from '@/containers/setting-room/data';
import IconTrash from '@/assets/Icons/outline/IconTrash';
import { RoomConfiguration } from '@/lib/schemas/setting-room/general-setting';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import {
	Table,
	TableBody,
	TableCell,
	TableFooter,
	TableHead,
	TableHeader,
	TableRow,
} from '@/components/ui/table';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { NumberInput } from '@/components/ui/number-input';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import { IconPlus } from '@/assets/Icons/outline';
import { FormControl, FormField, FormItem } from '@/components/ui/form';

export const MAX_AGE_VALUE = '9999';

const RoomExtraBeds = () => {
	const { formState, control, setValue, getValues } =
		useFormContext<RoomConfiguration>();

	const useExtraBeds = useWatch({
		control,
		name: 'extras.hasExtraBed',
	});

	const extraBedFees = useWatch({
		control,
		name: 'extras.extra_beds',
	});

	useEffect(() => {
		const fees = getValues('extras.extra_beds');
		if (!useExtraBeds) {
			setValue('extras.extra_beds', []);
		} else if (fees && fees.length === 0) {
			setValue('extras.extra_beds', [
				{
					age_from: 0,
					age_to: null,
					type: 'free',
					price: null,
				},
			]);
		}
	}, [useExtraBeds]);

	const onAdd = (index: number) => {
		setValue('extras.extra_beds', [
			...extraBedFees,
			{
				age_from: Number(extraBedFees[index].age_to),
				age_to: null,
				type: 'free',
				price: null,
			},
		]);
	};

	const getValidOption = (index: number) => {
		const data = [...extraBedFees].slice(0, index);
		const maxAge = Math.max(...data.map((item) => +(item.age_to as number)));
		return [...ageRanges, { label: 'Trở lên', value: MAX_AGE_VALUE }].filter(
			(item) => +item.value > maxAge
		);
	};

	const onRemove = (index: number) => {
		const data = [...extraBedFees];
		data.splice(index, 1);
		setValue('extras.extra_beds', data, { shouldValidate: true });
	};

	useEffect(() => {
		const isGapInvalid = extraBedFees.some((row, index, arr) => {
			if (index === 0) return false;
			const prevAgeTo = arr[index - 1]?.age_to ?? 0;
			return row.age_from !== prevAgeTo;
		});

		if (isGapInvalid) {
			const newRows = extraBedFees.map((row, index, arr) => {
				const prevAgeTo = index === 0 ? 0 : (arr[index - 1]?.age_to ?? 0);
				return {
					...row,
					age_from: prevAgeTo,
				};
			});

			setValue(
				'extras.extra_beds',
				newRows as [(typeof newRows)[0], ...typeof newRows]
			);
		}
	}, [extraBedFees]);

	const getErrorMessage = () => {
		const errs = formState.errors?.extras?.extra_beds;
		const getErrors = errs?.find?.((error) => !!error);
		if (getErrors) {
			return (
				getErrors?.message ||
				getErrors?.age_to?.message ||
				getErrors?.price?.message ||
				''
			);
		} else {
			return '';
		}
	};

	const errorMessage = getErrorMessage();

	return (
		<div className={'space-y-4 rounded-lg bg-white p-4'}>
			<Typography
				tag={'h3'}
				variant="content_16px_600"
				className={'text-neutral-600'}>
				Nôi/cũi và giường phụ
			</Typography>

			<Controller
				control={control}
				name="extras.hasExtraBed"
				render={({ field }) => (
					<RadioGroup
						onValueChange={(value) => field.onChange(value === 'true')}
						value={String(field.value)}
						className="space-y-2">
						<div className="flex items-center space-x-2">
							<RadioGroupItem
								value="false"
								id="extraBeds-no"
								className={
									'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
								}
							/>
							<Label
								htmlFor="extraBeds-no"
								containerClassName={'mb-0'}
								className="cursor-pointer text-neutral-600">
								Không
							</Label>
						</div>
						<div className="flex items-center space-x-2">
							<RadioGroupItem
								value="true"
								id="extraBeds-yes"
								className={
									'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
								}
							/>
							<Label
								htmlFor="extraBeds-yes"
								containerClassName={'mb-0'}
								className="cursor-pointer text-neutral-600">
								Có
							</Label>
						</div>
					</RadioGroup>
				)}
			/>
			{useExtraBeds && (
				<div className={'mt-6 overflow-hidden'}>
					<Table className={'border-separate border-spacing-0'}>
						<TableHeader>
							<TableRow>
								<TableHead
									className={cn(
										'rounded-tl-lg border px-4 py-3 text-neutral-600',
										TextVariants.caption_14px_700
									)}>
									Tuổi
								</TableHead>
								<TableHead
									className={cn(
										'border-b border-t px-4 py-3 text-neutral-600',
										TextVariants.caption_14px_700
									)}>
									Loại phí
								</TableHead>
								<TableHead
									className={cn(
										'rounded-tr-lg border px-4 py-3 text-neutral-600',
										TextVariants.caption_14px_700
									)}>
									Phí
								</TableHead>
								<TableHead className={cn('px-4 py-3')}></TableHead>
							</TableRow>
						</TableHeader>
						<TableBody>
							{extraBedFees?.map((_, index, array) => (
								<TableRow className={'h-12 !bg-white'} key={index}>
									<TableCell
										className={cn(
											'grid w-full grid-cols-2 gap-4 border border-t-0 py-3',
											index + 1 === array.length && 'rounded-bl-lg'
										)}>
										<div className={'space-y-2'}>
											<div className={'flex items-center gap-2'}>
												<Typography
													tag={'span'}
													variant={'caption_14px_400'}
													text={'Từ'}
													className={'text-neutral-600'}
												/>

												<Typography
													tag={'span'}
													variant={'caption_14px_400'}
													text={
														index === 0
															? '0'
															: `${+(getValues(`extras.extra_beds.${index - 1}.age_to`) as number) === +MAX_AGE_VALUE ? '' : +(getValues(`extras.extra_beds.${index - 1}.age_to`) as number)}`
													}
													className={'text-neutral-600'}
												/>
											</div>
										</div>

										<FormField
											control={control}
											name={`extras.extra_beds.${index}.age_to`}
											{...(index > 0
												? {
														rules: {
															deps: [`extras.extra_beds.${index - 1}.age_to`],
														},
													}
												: {})}
											render={({ field: { value, onChange, ...props } }) => (
												<FormItem className={'space-y-2'}>
													<div className={'flex items-center gap-2'}>
														<Typography
															tag={'span'}
															variant={'caption_14px_400'}
															text={'Đến'}
															className={'text-neutral-600'}
														/>
														<FormControl>
															<SelectPopup
																searchInput={false}
																className="h-6 overflow-hidden rounded-lg border-none bg-neutral-50 px-2 py-0"
																labelClassName="hidden"
																data={getValidOption(index)}
																selectedValue={value ?? undefined}
																onChange={(value) => onChange(Number(value))}
																classItemList={'h-auto'}
																placeholder="Chọn độ tuổi"
																controllerRenderProps={props}
															/>
														</FormControl>
													</div>
												</FormItem>
											)}
										/>
									</TableCell>
									<TableCell className={'w-[190px] border-b border-t-0 py-3'}>
										<Controller
											control={control}
											name={`extras.extra_beds.${index}.type`}
											rules={{
												deps: [`extras.extra_beds.${index}.price`],
											}}
											render={({ field: { value, onChange, name } }) => (
												<div className={'flex-1 space-y-2'}>
													<SelectPopup
														searchInput={false}
														className="h-6 rounded-lg border-none bg-neutral-50 px-2 py-0"
														labelClassName="hidden"
														data={feeTypes}
														selectedValue={value}
														onChange={onChange}
														classItemList={'h-auto'}
													/>
													<FieldErrorMessage
														errors={formState.errors}
														name={name}
													/>
												</div>
											)}
										/>
									</TableCell>
									<TableCell
										className={cn(
											'w-[175px] border border-t-0 py-3',
											index + 1 === array.length && 'rounded-br-lg'
										)}>
										{getValues(`extras.extra_beds.${index}.type`) === 'free' ? (
											<Typography
												tag={'span'}
												variant={'caption_14px_400'}
												className={'text-green-500'}
												text={'Miễn phí'}
											/>
										) : (
											<FormField
												control={control}
												name={`extras.extra_beds.${index}.price`}
												render={({ field: { value, onChange, ...props } }) => (
													<FormItem
														className={
															'flex items-center justify-between gap-2 space-y-0'
														}>
														<FormControl>
															<NumberInput
																className={cn(
																	'h-6 rounded-none border-none px-0 py-2 leading-6 text-neutral-600 outline-none',
																	TextVariants.caption_14px_400
																)}
																inputMode={'numeric'}
																placeholder="1,200,000đ"
																suffix={''}
																maxLength={11}
																{...props}
																value={value}
																onValueChange={(e) => {
																	onChange(
																		e.value.length === 0
																			? null
																			: Number(e.value)
																	);
																}}
															/>
														</FormControl>
														<Typography
															tag={'span'}
															variant={'caption_14px_400'}
															className={'text-neutral-600'}>
															đ/người
														</Typography>
													</FormItem>
												)}
											/>
										)}
									</TableCell>
									<TableCell className={'w-[50px] !bg-white py-3'}>
										<div className={'flex flex-row items-center gap-3'}>
											{index > 0 && (
												<IconTrash
													onClick={() => onRemove(index)}
													className={'cursor-pointer'}
												/>
											)}
											{index === array.length - 1 &&
												extraBedFees[index].age_to !== null &&
												getValidOption(index + 1).length > 0 && (
													<IconPlus
														onClick={() => onAdd(index)}
														className={'cursor-pointer'}
													/>
												)}
										</div>
									</TableCell>
								</TableRow>
							))}
						</TableBody>
						{errorMessage && (
							<TableFooter>
								<TableRow className={'!bg-white'}>
									<TableCell colSpan={9999}>
										<Typography
											tag="span"
											variant="caption_12px_500"
											className={'mt-2 text-red-500'}>
											{errorMessage}
										</Typography>
									</TableCell>
								</TableRow>
							</TableFooter>
						)}
					</Table>
				</div>
			)}
		</div>
	);
};

export default RoomExtraBeds;
