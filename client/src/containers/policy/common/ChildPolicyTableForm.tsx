'use client';
import {
	Controller,
	useFieldArray,
	useFormContext,
	useWatch,
} from 'react-hook-form';
import {
	Table,
	TableBody,
	TableCell,
	TableFooter,
	TableHead,
	TableHeader,
	TableRow,
} from '@/components/ui/table';
import Typography from '@/components/shared/Typography';
import IconQuestion from '@/assets/Icons/outline/IconQuestion';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Label } from '@/components/ui/label';
import IconTrash from '@/assets/Icons/outline/IconTrash';
import {
	PolicyFormValues,
	ROBB,
} from '@/lib/schemas/policy/validationChildPolicy';
import { cn } from '@/lib/utils';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import React, { useEffect, useMemo } from 'react';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { AppTooltip } from '@/components/shared/AppTooltip/AppTooltip';
import { IconExclamationCircle, IconPlus } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import { NumberInput } from '@/components/ui/number-input';

export const childrenAge = [
	{ label: '1', value: 1 },
	{ label: '2', value: 2 },
	{ label: '3', value: 3 },
	{ label: '4', value: 4 },
	{ label: '5', value: 5 },
	{ label: '6', value: 6 },
	{ label: '7', value: 7 },
	{ label: '8', value: 8 },
	{ label: '9', value: 9 },
	{ label: '10', value: 10 },
	{ label: '11', value: 11 },
	{ label: '12', value: 12 },
	{ label: '13', value: 13 },
	{ label: '14', value: 14 },
	{ label: '15', value: 15 },
	{ label: '16', value: 16 },
	{ label: '17', value: 17 },
];

const childFeeTypes = [
	{ label: 'Miễn phí', value: 'free' },
	{ label: 'Có phí', value: 'charged' },
	{ label: 'Miễn phí có giới hạn', value: 'limit' },
];

interface ChildPolicyTableFormProps {
	prefix: 'policy' | '';
	className?: string;
}

type FormValues = PolicyFormValues | { policy: PolicyFormValues };

export default function ChildPolicyTableForm({
	prefix = '',
	className,
}: ChildPolicyTableFormProps) {
	const {
		control,
		getValues,
		setValue,
		formState: { errors },
	} = useFormContext<FormValues>();

	const rowErrorField =
		'policy' in errors
			? errors?.policy?.rows
			: 'rows' in errors
				? errors?.rows
				: undefined;

	const ageLimitField: 'policy.ageLimit' | 'ageLimit' = prefix
		? `${prefix}.ageLimit`
		: 'ageLimit';

	const rowsField: 'policy.rows' | 'rows' = prefix ? `${prefix}.rows` : 'rows';

	const { fields, append, remove } = useFieldArray({
		control,
		name: rowsField,
	});

	const ageLimit = useWatch({
		control,
		name: ageLimitField,
	});

	const rowsWatch = useWatch({
		control,
		name: rowsField,
	}) as PolicyFormValues['rows'];

	const maxAge = useMemo(
		() => Math.max(...rowsWatch.map((item) => item.age_to)),
		[rowsWatch]
	);

	useEffect(() => {
		const rows = getValues(rowsField);
		let addRow = true;
		rows.forEach((row, index) => {
			if (row.age_to > ageLimit) {
				rows[index].age_to = NaN;
			}
			addRow = row.age_to < ageLimit;
		});
		if (addRow) {
			rows.push({
				age_from: rows[rows.length - 1].age_to,
				age_to: NaN,
				fee_type: 'charged',
				fee: NaN,
				meal_type: ROBB.RO,
			});
		}
		setValue(rowsField, rows);
	}, [ageLimit, getValues, setValue, rowsField]);

	useEffect(() => {
		const ageLimit = getValues(ageLimitField);

		const isGapInvalid = rowsWatch.some((row, index, arr) => {
			if (index === 0) return false;
			const prevAgeTo = arr[index - 1]?.age_to ?? 0;
			return !isNaN(row.age_from) && row.age_from !== prevAgeTo;
		});

		const rows = rowsWatch.filter(
			(row, index) =>
				index === 0 ||
				(!row.age_to && rowsWatch[index - 1].age_to < ageLimit) ||
				rowsWatch[index - 1].age_to < row.age_to
		);

		if (rows.length !== rowsWatch.length) {
			setValue(rowsField, rows as [(typeof rows)[0], ...typeof rows]);
		} else if (isGapInvalid) {
			const newRows = rowsWatch.map((row, index, arr) => {
				const prevAgeTo = index === 0 ? 0 : (arr[index - 1]?.age_to ?? 0);
				return {
					...row,
					age_from: prevAgeTo,
				};
			});
			setValue(rowsField, newRows as [(typeof newRows)[0], ...typeof newRows]);
		}
	}, [rowsWatch]);

	const errorMessage = useMemo(() => {
		const firstError = rowErrorField?.find?.((err) => !!err);
		if (firstError) {
			return (
				firstError?.age_to?.message ||
				firstError?.fee_type?.message ||
				firstError?.quantity_child?.message ||
				firstError?.fee?.message ||
				''
			);
		} else {
			return '';
		}
	}, [JSON.stringify(rowErrorField)]);

	const handlerAddRow = () => {
		append({
			age_from: rowsWatch[rowsWatch.length - 1].age_to,
			age_to: NaN,
			fee_type: 'charged',
			fee: NaN,
			meal_type: ROBB.RO,
		});
	};

	const getValidOption = (index: number) => {
		const [ageLimit, rows] = getValues([ageLimitField, rowsField]);
		const data = [...rows].slice(0, index);
		const maxAge = Math.max(...data.map((item) => item.age_to));
		return childrenAge.filter(
			(item) => item.value > maxAge && item.value <= ageLimit
		);
	};

	return (
		<div className={className}>
			<div>
				<Typography
					tag={'p'}
					text={'Giá trẻ em bổ sung'}
					className={'text-md font-semibold leading-6'}
				/>
				<Table className="mt-4 w-full table-auto border-separate border-spacing-0">
					<TableHeader>
						<TableRow className="bg-neutral-00">
							<TableHead className="w-1/4 rounded-tl-lg border px-4 py-3 text-base font-bold leading-6">
								Tuổi trẻ em
							</TableHead>
							<TableHead className="w-1/4 border-b border-r border-t px-4 py-3 text-base font-bold leading-6">
								Loại phí
							</TableHead>
							<TableHead className="w-1/4 border-b border-t px-4 py-3 text-base font-bold leading-6">
								Phí phụ thu thêm
							</TableHead>
							<TableHead className="w-1/4 rounded-tr-lg border px-4 py-3">
								<div className={'flex items-center justify-between'}>
									<Typography
										tag={'p'}
										text={'RO/BB'}
										className={'text-base font-bold leading-6'}
									/>
									<AppTooltip icon={<IconQuestion />} content={'Tooltip'} />
								</div>
							</TableHead>
						</TableRow>
					</TableHeader>
					<TableBody>
						{fields.map((row, index) => {
							const options = getValidOption(index);
							const fromAge =
								index <= 0 ? 0 : getValues(`${rowsField}.${index - 1}.age_to`);
							return (
								<TableRow key={row.id} className={'!bg-white'}>
									<TableCell
										className={cn(
											'w-1/4 border border-t-0 px-4 py-3 font-medium',
											index + 1 === fields.length && 'rounded-bl-lg'
										)}>
										<div className="flex flex-1 justify-items-start">
											<div className="flex items-center justify-center gap-4">
												<Typography
													tag="p"
													variant={'caption_14px_400'}
													className={'text-neutral-600'}
													text={'Từ'}
												/>
												<Typography
													tag={'span'}
													variant={'caption_14px_400'}
													text={`${isNaN(fromAge) ? '-' : fromAge}`}
													className={'min-w-[15px] text-neutral-600'}
												/>
											</div>

											<div className="ml-4 flex flex-1 items-center justify-center gap-2">
												<Typography
													tag="p"
													variant={'caption_14px_400'}
													className={'text-neutral-600'}
													text={'Đến'}
												/>
												<Controller
													name={`${rowsField}.${index}.age_to`}
													control={control}
													{...(index > 0
														? {
																rules: {
																	deps: [`${rowsField}.${index - 1}.age_to`],
																},
															}
														: {})}
													render={({ field }) => (
														<SelectPopup
															searchInput={false}
															className="h-6 flex-1 overflow-hidden rounded-lg border-none bg-neutral-50 px-2 py-0"
															labelClassName="hidden"
															label=""
															placeholder={'Chọn tuổi'}
															data={options}
															selectedValue={String(field.value)}
															onChange={(val) => field.onChange(Number(val))}
															classItemList={`${options.length <= 4 ? 'h-auto' : ''}`}
														/>
													)}
												/>
											</div>
										</div>
									</TableCell>

									<TableCell className="w-1/4 border border-l-0 border-t-0 px-4 py-3">
										<Controller
											name={`${rowsField}.${index}.fee_type`}
											control={control}
											rules={{
												deps: [`${rowsField}.${index}.quantity_child`],
											}}
											render={({ field }) => (
												<SelectPopup
													searchInput={false}
													className="h-6 w-full overflow-hidden rounded-lg border-none bg-neutral-50 px-2 py-0"
													labelClassName="hidden"
													placeholder={'Loại phí'}
													data={childFeeTypes}
													selectedValue={String(field.value)}
													onChange={(value) => {
														field.onChange(value);
														if (value === 'free') {
															setValue(`${rowsField}.${index}.fee`, NaN);
														}
														if (value !== 'limit') {
															setValue(
																`${rowsField}.${index}.quantity_child`,
																NaN
															);
														}
													}}
													classItemList={'h-auto'}
												/>
											)}
										/>

										{rowsWatch?.[index]?.fee_type === 'limit' && (
											<div
												className={
													'flex flex-row items-center justify-center px-2 pt-3'
												}>
												<Typography
													tag="p"
													className={'w-full text-neutral-600'}
													variant={'caption_14px_400'}>
													Trẻ miễn phí
												</Typography>
												<Controller
													name={`${rowsField}.${index}.quantity_child`}
													control={control}
													render={({
														field: { onChange, value, ...props },
													}) => (
														<div className={'relative'}>
															<NumberInput
																className={cn(
																	'h-6 rounded-none border-none p-0 text-right leading-6 text-neutral-600 outline-none',
																	TextVariants.caption_14px_400
																)}
																inputMode={'numeric'}
																placeholder="Nhập số trẻ"
																suffix={''}
																maxLength={3}
																{...props}
																value={value}
																onValueChange={(e) => {
																	onChange(
																		e.value.length === 0 ? NaN : Number(e.value)
																	);
																}}
															/>
														</div>
													)}
												/>
											</div>
										)}
									</TableCell>

									<TableCell className="w-1/4 border-b border-t-0 px-4 py-3 align-top">
										{rowsWatch?.[index]?.fee_type === 'free' ? (
											<Typography
												variant={'caption_14px_400'}
												className="text-green-600">
												Miễn phí
											</Typography>
										) : (
											<Controller
												name={`${rowsField}.${index}.fee`}
												control={control}
												render={({ field: { onChange, value, ...props } }) => (
													<div className={'relative'}>
														<NumberInput
															className={cn(
																'h-6 rounded-none border-none p-0 leading-6 text-neutral-600 outline-none',
																TextVariants.caption_14px_400
															)}
															inputMode={'numeric'}
															placeholder="300,000"
															suffix={''}
															maxLength={11}
															{...props}
															value={value}
															onValueChange={(e) => {
																onChange(
																	e.value.length === 0 ? NaN : Number(e.value)
																);
															}}
															endAdornment={'đ/người'}
															endAdornmentClassname={`${TextVariants.caption_14px_400} text-neutral-600`}
														/>
													</div>
												)}
											/>
										)}
									</TableCell>

									<TableCell
										className={cn(
											'w-1/4 border border-t-0 px-4 py-3',
											index + 1 === fields.length && 'rounded-br-lg'
										)}>
										<Controller
											name={`${rowsField}.${index}.meal_type`}
											control={control}
											render={({ field }) => (
												<RadioGroup
													className="flex items-center gap-4"
													onValueChange={field.onChange}
													value={field.value}>
													<div className="flex items-center space-x-2">
														<RadioGroupItem
															id={`fee-${index}-ro`}
															value={ROBB.RO}
															className="border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-white data-[state=checked]:text-secondary-500"
														/>
														<Label
															htmlFor={`fee-${index}-ro`}
															containerClassName={'mb-0'}
															className="text-base font-normal leading-6">
															RO
														</Label>
													</div>
													<div className="flex items-center space-x-2">
														<RadioGroupItem
															id={`fee-${index}-bb`}
															value={ROBB.BB}
															className="border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-white data-[state=checked]:text-secondary-500"
														/>
														<Label
															htmlFor={`fee-${index}-bb`}
															containerClassName={'mb-0'}
															className="text-base font-normal leading-6">
															BB
														</Label>
													</div>
												</RadioGroup>
											)}
										/>
									</TableCell>

									<TableCell className="px-4 py-3">
										{index > 0 && (
											<IconTrash
												className="cursor-pointer"
												onClick={() => remove(index)}
											/>
										)}
									</TableCell>
								</TableRow>
							);
						})}
					</TableBody>
					{errorMessage && (
						<TableFooter>
							<TableRow className={'!bg-white'}>
								<TableCell colSpan={9999} className="pl-0">
									<div className="flex flex-row items-center gap-2 rounded-lg bg-red-50 px-4 py-3">
										<IconExclamationCircle
											color={GlobalUI.colors.red['500']}
											className={'h-4 w-4'}
										/>
										<Typography
											tag="span"
											variant="caption_12px_500"
											className={'text-red-500'}>
											{errorMessage}
										</Typography>
									</div>
								</TableCell>
							</TableRow>
						</TableFooter>
					)}
				</Table>
			</div>
			{!Number.isNaN(rowsWatch[rowsWatch.length - 1].age_to) &&
				(ageLimit > maxAge || !maxAge) && (
					<button
						type="button"
						onClick={handlerAddRow}
						className={`flex flex-row items-center gap-2 py-3 text-secondary-500 ${TextVariants.caption_14px_400} w-fit`}>
						<IconPlus
							color={GlobalUI.colors.secondary['500']}
							className={'h-4 w-4'}
						/>
						Thêm hàng
					</button>
				)}
		</div>
	);
}
