import Typography from '@/components/shared/Typography';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { useFormContext, useWatch } from 'react-hook-form';
import {
	DepositPolicyFormValue,
	EDepositAmountType,
} from '@/lib/schemas/policy/otherPolicy';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { NumberInput } from '@/components/ui/number-input';
import React from 'react';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import { DepositMethod } from '@/store/other-policy/type';
import { useAttributeStore } from '@/store/attributes/store';

export default function DepositPolicyForm() {
	const {
		control,
		setValue,
		formState: { errors },
	} = useFormContext<DepositPolicyFormValue>();

	const methodDepositList = useAttributeStore(
		(state) => state.methodDepositList
	);

	const [depositType, selectedMethods] = useWatch({
		control,
		name: ['deposit.type_deposit', 'deposit.method_deposit'],
	});

	return (
		<div className={'mt-6 flex flex-col gap-4'}>
			<Typography
				tag={'p'}
				text={'Số tiền cọc'}
				className={'text-md font-semibold leading-6'}
			/>

			<FormField
				name="deposit.type_deposit"
				control={control}
				rules={{ deps: ['deposit.amount'] }}
				render={({ field }) => (
					<FormItem className="space-y-2">
						<FormLabel required>Số tiền cọc</FormLabel>
						<FormControl>
							<RadioGroup
								className="flex gap-4"
								value={String(field.value)}
								onValueChange={field.onChange}>
								<div className="flex items-center space-x-2">
									<RadioGroupItem
										id="fixedAmount"
										value={`${EDepositAmountType.fixed}`}
										className="border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-white data-[state=checked]:text-secondary-500"
									/>
									<Label
										htmlFor="fixedAmount"
										className="mt-2 cursor-pointer text-base font-normal leading-6">
										Số tiền cố định
									</Label>
								</div>

								<div className="flex items-center space-x-2">
									<RadioGroupItem
										id="byOfRoomRate"
										value={`${EDepositAmountType.percent}`}
										className="border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-white data-[state=checked]:text-secondary-500"
									/>
									<Label
										htmlFor="byOfRoomRate"
										className="mt-2 cursor-pointer text-base font-normal leading-6">
										Theo % giá phòng
									</Label>
								</div>
							</RadioGroup>
						</FormControl>
						<FormMessage />
					</FormItem>
				)}
			/>

			<FormField
				name="deposit.amount"
				control={control}
				render={({ field: { value, onChange, ...props } }) => (
					<FormItem>
						<div className={'relative max-w-[367px]'}>
							<FormControl>
								<NumberInput
									placeholder={
										depositType === EDepositAmountType.fixed
											? `Nhập số tiền cọc`
											: 'Nhập số % theo giá phòng'
									}
									inputMode={'numeric'}
									suffix={''}
									className={cn(
										'h-[44px] py-2 leading-6',
										TextVariants.caption_14px_400
									)}
									value={value}
									maxLength={depositType === EDepositAmountType.fixed ? 11 : 3}
									{...props}
									onValueChange={(e) => {
										onChange(e.value.length === 0 ? NaN : Number(e.value));
									}}
									endAdornment={
										depositType === EDepositAmountType.fixed ? 'VND' : '%'
									}
								/>
							</FormControl>
						</div>
						<FormMessage />
					</FormItem>
				)}
			/>

			<div className="mt-2">
				<Typography
					tag={'p'}
					text={'Phương thức đặt cọc được chấp nhận'}
					className={'cursor-pointer text-md font-semibold leading-6'}
				/>

				<div className="mt-4 flex flex-col gap-2">
					{methodDepositList && methodDepositList.map((item, index) => {
						const isChecked = selectedMethods?.includes(
							item.slug as DepositMethod
						);
						return (
							<div key={index} className="flex items-center space-x-2">
								<Checkbox
									id={item.slug}
									checked={isChecked}
									onCheckedChange={(checked) => {
										if (checked) {
											setValue(
												'deposit.method_deposit',
												selectedMethods
													? ([...selectedMethods, item.slug] as DepositMethod[])
													: ([item.slug] as DepositMethod[]),
												{ shouldValidate: true }
											);
										} else {
											setValue(
												'deposit.method_deposit',
												selectedMethods.filter(
													(method: string) => method !== item.slug
												),
												{ shouldValidate: true }
											);
										}
									}}
								/>
								<Label
									htmlFor={item.slug}
									containerClassName={'m-0 ml-2'}
									className="cursor-pointer text-base font-normal leading-6">
									{item.name}
								</Label>
							</div>
						);
					})}
					<FieldErrorMessage errors={errors} name={'deposit.method_deposit'} />
				</div>
			</div>
		</div>
	);
}
