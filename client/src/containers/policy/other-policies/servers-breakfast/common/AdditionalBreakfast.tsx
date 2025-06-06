'use client';
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
import { Controller, useFormContext, useWatch } from 'react-hook-form';
import IconTrash from '@/assets/Icons/outline/IconTrash';
import IconPlus from '@/assets/Icons/outline/IconPlus';
import { BreakFastServiceFormValue } from '@/lib/schemas/policy/otherPolicy';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { MAX_AGE_VALUE } from '@/containers/setting-room/RoomGeneralSetting/common/RoomExtraBeds';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import { NumberInput } from '@/components/ui/number-input';
import { useEffect, useMemo } from 'react';
import { ageRanges, feeTypes } from '../../data';
import { GlobalUI } from '@/themes/type';
import IconExclamationCircle from '@/assets/Icons/outline/IconExclamationCircle';

export default function AdditionalBreakfast() {
	const { formState, control, setValue, getValues } =
		useFormContext<BreakFastServiceFormValue>();

	const extra_breakfast = useWatch({
		control,
		name: 'breakfast.extra_breakfast',
	});

	useEffect(() => {
		const ageLimit = +MAX_AGE_VALUE;

		if (!!extra_breakfast) {
			const isGapInvalid = extra_breakfast.some((row, index, arr) => {
				if (index === 0) return false;
				const prevAgeTo = arr[index - 1]?.age_to ?? 0;
				return !isNaN(row.age_from) && row.age_from !== prevAgeTo;
			});

			const rows = extra_breakfast.filter(
				(row, index) =>
					index === 0 ||
					(!row.age_to &&
						+(extra_breakfast?.[index - 1]?.age_to ?? 0) < ageLimit) ||
					+(extra_breakfast?.[index - 1]?.age_to ?? 0) < (row.age_to ?? 0)
			);

			if (rows.length !== extra_breakfast.length) {
				setValue(
					'breakfast.extra_breakfast',
					rows as [(typeof rows)[0], ...typeof rows]
				);
			} else if (isGapInvalid) {
				const newRows = extra_breakfast.map((row, index, arr) => {
					const prevAgeTo = index === 0 ? 0 : (arr[index - 1]?.age_to ?? 0);
					return {
						...row,
						age_from: prevAgeTo,
					};
				});
				setValue(
					'breakfast.extra_breakfast',
					newRows as [(typeof newRows)[0], ...typeof newRows]
				);
			}
		}
	}, [extra_breakfast]);

	const onAdd = () => {
		setValue('breakfast.extra_breakfast', [
			...(extra_breakfast ? [...extra_breakfast] : []),
			{
				age_from: Number(
					extra_breakfast && extra_breakfast[extra_breakfast.length - 1].age_to
				),
				age_to: null,
				fee_type: 'free',
				fee: NaN,
			},
		]);
	};

	const onRemove = (index: number) => {
		const data = extra_breakfast ? [...extra_breakfast] : [];
		data.splice(index, 1);
		setValue('breakfast.extra_breakfast', data, { shouldValidate: true });
	};

	const getValidOption = (index: number) => {
		const data = (extra_breakfast ? [...extra_breakfast] : []).slice(0, index);
		const maxAge = Math.max(...data.map((item) => +(item.age_to as number)));
		return [...ageRanges, { label: 'Trở lên', value: MAX_AGE_VALUE }].filter(
			(item) => +item.value > maxAge
		);
	};

	const errorMessages = useMemo(() => {
		const errors = formState.errors?.breakfast?.extra_breakfast;
		const getErrors = errors?.find?.((err) => !!err);
		if (getErrors) {
			return (
				getErrors?.message ||
				getErrors?.age_to?.message ||
				getErrors?.fee?.message ||
				getErrors?.fee_type?.message ||
				''
			);
		} else {
			return '';
		}
	}, [formState.errors.breakfast?.extra_breakfast]);

	return (
		<div className="mt-[16px]">
			<Typography
				tag={'p'}
				text={'Phí cho bữa sáng bổ sung'}
				className={'text-md font-semibold leading-6'}
			/>

			<Typography
				tag={'p'}
				text={
					'Phí cho bữa sáng bổ sung chưa bao gồm trong tổng giá và khách sẽ thanh toán tại chỗ nghỉ'
				}
				className={'text-base font-normal leading-6 text-neutral-400'}
			/>
			<div className="mt-4">
				<Table className={'border-separate border-spacing-0'}>
					<TableHeader>
						<TableRow className="bg-neutral-00">
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
						{extra_breakfast?.map((_, index, array) => (
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
												className={'text-neutral-600'}
												text={
													index === 0
														? '0'
														: `${+(getValues(`breakfast.extra_breakfast.${index - 1}.age_to`) as number) === +MAX_AGE_VALUE ? '' : +(getValues(`breakfast.extra_breakfast.${index - 1}.age_to`) as number)}`
												}
											/>
										</div>
									</div>

									<Controller
										name={`breakfast.extra_breakfast.${index}.age_to`}
										control={control}
										{...(index > 0
											? {
													rules: {
														deps: [
															`breakfast.extra_breakfast.${index - 1}.age_to`,
														],
													},
												}
											: {})}
										render={({ field: { value, onChange } }) => (
											<div className={'space-y-2'}>
												<div className={'flex items-center gap-2'}>
													<Typography
														tag={'span'}
														variant={'caption_14px_400'}
														text={'Đến'}
														className={'text-neutral-600'}
													/>
													<SelectPopup
														placeholder="Chọn độ tuổi"
														labelClassName="hidden"
														searchInput={false}
														className="h-6 overflow-hidden rounded-lg border-none bg-neutral-50 px-2 py-0"
														data={getValidOption(index)}
														selectedValue={value ?? undefined}
														onChange={(value) => onChange(Number(value))}
													/>
												</div>
											</div>
										)}
									/>
								</TableCell>
								<TableCell className={'w-[190px] border-b border-t-0 py-3'}>
									<Controller
										name={`breakfast.extra_breakfast.${index}.fee_type`}
										control={control}
										rules={{ deps: [`breakfast.extra_breakfast.${index}.fee`] }}
										render={({ field: { value, onChange, name } }) => (
											<div className={'flex-1 space-y-2'}>
												<SelectPopup
													labelClassName="hidden"
													classItemList={'h-auto'}
													className="h-6 rounded-lg border-none bg-neutral-50 px-2 py-0"
													searchInput={false}
													data={feeTypes}
													selectedValue={value}
													onChange={onChange}
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
									{getValues(`breakfast.extra_breakfast.${index}.fee_type`) ===
									'free' ? (
										<Typography
											tag={'span'}
											variant={'caption_14px_400'}
											className={'text-green-500'}
											text={'Miễn phí'}
										/>
									) : (
										<Controller
											name={`breakfast.extra_breakfast.${index}.fee`}
											control={control}
											render={({ field: { value, onChange, ...props } }) => (
												<div
													className={'flex items-center justify-between gap-2'}>
													<NumberInput
														inputMode={'numeric'}
														placeholder="1,200,000đ"
														suffix={''}
														maxLength={11}
														className={cn(
															'h-6 rounded-none border-none px-0 py-2 leading-6 text-neutral-600 outline-none',
															TextVariants.caption_14px_400
														)}
														{...props}
														value={value}
														onValueChange={(e) => {
															onChange(
																e.value.length === 0 ? NaN : Number(e.value)
															);
														}}
													/>
													<Typography
														tag={'span'}
														variant={'caption_14px_400'}
														className={'text-neutral-600'}>
														đ/người
													</Typography>
												</div>
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
									</div>
								</TableCell>
							</TableRow>
						))}
					</TableBody>
					{errorMessages && (
						<TableFooter>
							<TableRow>
								<TableCell colSpan={9999} className="!bg-white pl-0">
									<div className="flex flex-row items-center gap-2 rounded-lg bg-red-50 px-4 py-3">
										<IconExclamationCircle
											color={GlobalUI.colors.red['500']}
											className={'h-4 w-4'}
										/>
										<Typography
											tag="span"
											variant="caption_12px_500"
											className={'text-red-500'}>
											{errorMessages}
										</Typography>
									</div>
								</TableCell>
							</TableRow>
						</TableFooter>
					)}
				</Table>

				{extra_breakfast?.map((_, index, array) =>
					index === array.length - 1 &&
					extra_breakfast[index].age_to !== null &&
					getValidOption(index + 1).length > 0 ? (
						<button
							type="button"
							key={index}
							className={'mt-3 flex items-center'}
							onClick={onAdd}>
							<IconPlus color={'#2A85FF'} className="!h-[16px] !w-[16px]" />
							<Typography
								tag="p"
								className={'ml-2 text-left text-base text-secondary-500'}
								text="Thêm hàng"
							/>
						</button>
					) : null
				)}
			</div>
		</div>
	);
}
