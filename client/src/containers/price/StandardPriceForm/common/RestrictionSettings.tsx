import React from 'react';
import { useFormContext, useWatch } from 'react-hook-form';
import { TPriceType } from '@/lib/schemas/type-price/standard-price';
import Typography from '@/components/shared/Typography';
import { NumberInput } from '@/components/ui/number-input';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';

export default function RestrictionSettings() {
	const { control } = useFormContext<TPriceType>();

	const [minDay, maxDay, minNight, maxNight] = useWatch({
		control,
		name: ['date_min', 'date_max', 'night_min', 'night_max'],
	});

	return (
		<div className={'rounded-2xl bg-white p-5'}>
			<Typography
				tag={'h2'}
				variant={'caption_18px_700'}
				className={'text-neutral-600'}
				text={'Thiết lập hạn chế'}
			/>
			<div className={'mt-4 grid grid-cols-2 gap-4'}>
				<FormField
					name="date_min"
					control={control}
					rules={maxDay ? { deps: ['date_max'] } : {}}
					render={({ field: { onChange, value, ...props } }) => (
						<FormItem className="col-span-2 lg:col-span-1">
							<FormLabel required>
								Số ngày đặt trước tối thiểu
							</FormLabel>
							<div className="relative mt-2">
								<FormControl>
									<NumberInput
										placeholder="0"
										inputMode="numeric"
										suffix=""
										maxLength={3}
										endAdornment="Ngày"
										className="h-10 py-2 leading-6 outline-none"
										{...props}
										value={value}
										onValueChange={(e) => {
											onChange(
												e.value.length === 0
													? NaN
													: Number(e.value)
											);
										}}
									/>
								</FormControl>
							</div>
							<FormMessage />
							<Typography
								tag="p"
								variant="caption_12px_500"
								className="mt-2 text-neutral-400">
								Số ngày tối thiểu trước ngày nhận phòng mà khách
								có thể đặt loại giá này.
							</Typography>
						</FormItem>
					)}
				/>

				<FormField
					name="date_max"
					control={control}
					rules={minDay ? { deps: ['date_min'] } : {}}
					render={({ field: { onChange, value, ...props } }) => (
						<FormItem className="col-span-2 lg:col-span-1">
							<FormLabel required>
								Số ngày đặt trước tối đa
							</FormLabel>

							<div className="relative mt-2">
								<FormControl>
									<NumberInput
										placeholder="0"
										inputMode="numeric"
										maxLength={3}
										suffix=""
										endAdornment="Ngày"
										className="h-10 py-2 leading-6 outline-none"
										{...props}
										value={value}
										onValueChange={(e) => {
											onChange(
												e.value.length === 0
													? NaN
													: Number(e.value)
											);
										}}
									/>
								</FormControl>
							</div>
							<FormMessage />

							<Typography
								tag="p"
								variant="caption_12px_500"
								className="mt-2 text-neutral-400">
								Số ngày tối đa trước ngày nhận phòng mà khách có
								thể đặt loại giá này.
							</Typography>
						</FormItem>
					)}
				/>

				<FormField
					name="night_min"
					control={control}
					rules={maxNight ? { deps: ['night_max'] } : {}}
					render={({ field: { onChange, value, ...props } }) => (
						<FormItem className="col-span-2 lg:col-span-1">
							<FormLabel required>Số đêm tối thiểu</FormLabel>
							<div className="relative mt-2">
								<FormControl>
									<NumberInput
										placeholder="0"
										inputMode="numeric"
										suffix=""
										maxLength={3}
										endAdornment="Đêm"
										className="h-10 py-2 leading-6 outline-none"
										{...props}
										value={value}
										onValueChange={(e) => {
											onChange(
												e.value.length === 0
													? NaN
													: Number(e.value)
											);
										}}
									/>
								</FormControl>
							</div>
							<FormMessage />
							<Typography
								tag="p"
								variant="caption_12px_500"
								className="mt-2 text-neutral-400">
								Số đêm tối thiểu khách phải ở lại để đủ tiêu
								chuẩn cho gói giá này.
							</Typography>
						</FormItem>
					)}
				/>

				<FormField
					name="night_max"
					control={control}
					rules={minNight ? { deps: ['night_min'] } : {}}
					render={({ field: { onChange, value, ...props } }) => (
						<FormItem className="col-span-2 lg:col-span-1">
							<FormLabel required>Số đêm tối đa</FormLabel>
							<div className="relative mt-2">
								<FormControl>
									<NumberInput
										placeholder="0"
										inputMode="numeric"
										suffix=""
										maxLength={3}
										endAdornment="Đêm"
										className="h-10 py-2 leading-6 outline-none"
										{...props}
										value={value}
										onValueChange={(e) => {
											onChange(
												e.value.length === 0
													? NaN
													: Number(e.value)
											);
										}}
									/>
								</FormControl>
							</div>
							<FormMessage />
							<Typography
								tag="p"
								variant="caption_12px_500"
								className="mt-2 text-neutral-400">
								Số đêm tối đa khách có thể ở lại để đủ tiêu
								chuẩn cho gói giá này.
							</Typography>
						</FormItem>
					)}
				/>
			</div>
		</div>
	);
}
