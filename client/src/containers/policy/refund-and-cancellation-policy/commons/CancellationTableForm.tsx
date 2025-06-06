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
import IconTrash from '@/assets/Icons/outline/IconTrash';
import React, { useMemo } from 'react';
import IconPlus from '@/assets/Icons/outline/IconPlus';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import Typography from '@/components/shared/Typography';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import { NumberInput } from '@/components/ui/number-input';
import {
	CancelPolicyFormValues,
	ECancelFeeType,
} from '@/lib/schemas/policy/cancelPolicy';
import { GlobalUI } from '@/themes/type';
import { CancellationTimeline } from '@/containers/policy/refund-and-cancellation-policy/commons/CancellationTimeline';
import IconExclamationCircle from '@/assets/Icons/outline/IconExclamationCircle';

interface Props {
	className?: string;
}

const cancelType = [
	{ value: ECancelFeeType.FREE, label: 'Miễn phí' },
	{ value: ECancelFeeType.FEE, label: 'Theo % giá phòng' },
];

export default function CancellationTableForm({ className }: Props) {
	const {
		control,
		formState: { errors },
	} = useFormContext<CancelPolicyFormValues>();

	const { fields, append, remove } = useFieldArray({ control, name: 'rows' });

	const rows = useWatch({ control, name: 'rows' });

	const handlerAddRow = () => {
		if (fields.length > 4) return;
		append({
			fee: NaN,
			day: NaN,
			fee_type: fields.length === 1 ? ECancelFeeType.FREE : ECancelFeeType.FEE,
		});
	};

	const errorMessage = useMemo(() => {
		const errs = errors?.rows;
		const firstError = errs?.find?.((err) => !!err);
		if (firstError) {
			return firstError?.day?.message || firstError?.fee?.message || '';
		} else {
			return '';
		}
	}, [errors.rows]);

	const lastDay = useMemo(
		() => (rows?.length > 1 ? rows?.[rows?.length - 1]?.day : 999),
		[rows]
	);

	return (
		<>
			<div className={cn('flex flex-col', className)}>
				<div>
					<Table className={'w-full border-separate border-spacing-0'}>
						<TableHeader className="bg-[#FCFCFD]">
							<TableRow>
								<TableHead
									className={`w-1/4 min-w-[200px] rounded-tl-xl border-b border-l border-t px-2 md:px-4 py-3 ${TextVariants.caption_14px_700}`}>
									Hủy trước
								</TableHead>
								<TableHead
									className={`w-1/5 border-b border-l border-r border-t px-2 md:px-4 py-3 ${TextVariants.caption_14px_700}`}>
									Phí hủy
								</TableHead>
								<TableHead
									className={`rounded-tr-xl min-w-[80px] border-b border-r border-t px-2 md:px-4 py-3 ${TextVariants.caption_14px_700}`}>
									Phí
								</TableHead>
							</TableRow>
						</TableHeader>
						<TableBody>
							{fields.map((row, index) => (
								<TableRow key={row.id} className="hover:bg-transparent">
									<TableCell
										className={`w-1/4 border-b border-l px-2 md:px-4 py-3 font-medium ${index === fields.length - 1 ? 'rounded-bl-xl' : ''}`}>
										{index === 0 ? (
											<Typography
												tag="p"
												variant={'caption_14px_400'}
												className="text-neutral-600">
												Vắng mặt (No-show)
											</Typography>
										) : (
											<Controller
												control={control}
												name={`rows.${index}.day`}
												render={({ field: { value, onChange, ...props } }) => (
													<div className={'relative'}>
														<NumberInput
															placeholder="30"
															maxLength={2}
															suffix={''}
															inputMode={'numeric'}
															value={value}
															{...props}
															className={cn(
																'h-6 rounded-none border-none p-0 leading-6 text-neutral-600 outline-none',
																TextVariants.caption_14px_400
															)}
															endAdornment={'Ngày trước check-in'}
															endAdornmentClassname={`${TextVariants.caption_14px_400} text-neutral-600`}
															onValueChange={(e) => {
																onChange(
																	e.value.length === 0 ? NaN : Number(e.value)
																);
															}}
														/>
													</div>
												)}
											/>
										)}
									</TableCell>

									<TableCell
										className={'w-1/4 border-b border-l border-r px-2 md:px-4 py-3'}>
										<Controller
											control={control}
											name={`rows.${index}.fee_type`}
											rules={{ deps: `rows.${index}.fee` }}
											render={({ field }) => (
												<SelectPopup
													placeholder={'Loại phí'}
													searchInput={false}
													data={cancelType}
													selectedValue={field.value}
													onChange={field.onChange}
													classItemList={'w-full h-auto'}
													className="h-6 w-full rounded-lg border-none bg-neutral-50 px-2 py-0"
												/>
											)}
										/>
									</TableCell>

									<TableCell
										className={`px-2 md:px-4 py-3 ${index === fields.length - 1 ? 'rounded-br-xl border-b border-r' : 'border-b border-r'}`}>
										<Controller
											control={control}
											name={`rows.${index}.fee`}
											render={({ field: { value, onChange, ...props } }) =>
												rows?.[index]?.fee_type === ECancelFeeType.FREE ? (
													<Typography
														tag="p"
														variant={'caption_14px_400'}
														className="text-green-500">
														Miễn phí
													</Typography>
												) : (
													<div className="relative w-full">
														<NumberInput
															placeholder="20"
															inputMode={'numeric'}
															suffix={''}
															maxLength={3}
															value={value}
															{...props}
															className={cn(
																'h-6 rounded-none border-none p-0 leading-6 text-neutral-600 outline-none',
																TextVariants.caption_14px_400
															)}
															onValueChange={(e) => {
																onChange(
																	e.value.length === 0 ? NaN : Number(e.value)
																);
															}}
															endAdornment={'%'}
															endAdornmentClassname={`${TextVariants.caption_14px_400} text-neutral-600`}
														/>
													</div>
												)
											}
										/>
									</TableCell>

									{index > 0 && (
										<TableCell className={'w-[50px]'}>
											<IconTrash
												onClick={() => remove(index)}
												className={'cursor-pointer'}
											/>
										</TableCell>
									)}
								</TableRow>
							))}
						</TableBody>
						{errorMessage && (
							<TableFooter>
								<TableRow className={'!bg-white'}>
									<TableCell colSpan={9999} className='pl-0'>
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
				{fields.length < 5 && (isNaN(lastDay) || lastDay > 1) && (
					<button
						type="button"
						onClick={handlerAddRow}
						className={'flex w-fit items-center px-4 py-3'}>
						<IconPlus
							width={16}
							height={16}
							color={GlobalUI.colors.secondary['500']}
						/>
						<Typography
							tag="p"
							variant={'caption_14px_400'}
							className={'ml-2 text-secondary-500'}>
							Thêm hàng
						</Typography>
					</button>
				)}
			</div>
			<div className="mt-4">
				<CancellationTimeline
					cancelable={true}
					policyRow={rows}
					errors={errors}
				/>
			</div>
		</>
	);
}
