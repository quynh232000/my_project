import React from 'react';
import { useFormContext } from 'react-hook-form';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { cn } from '@/lib/utils';
import { Input } from '@/components/ui/input';
import { TPriceType } from '@/lib/schemas/type-price/standard-price';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
export default function RateGeneralInfo() {
	const { control } = useFormContext<TPriceType>();
	return (
		<div className={'grid grid-cols-2 gap-4 rounded-2xl bg-white p-5'}>
			<FormField
				name="name"
				control={control}
				render={({ field: { onChange, value, ...props } }) => (
					<FormItem className="col-span-2 lg:col-span-1">
						<FormLabel
							className={cn(TextVariants.caption_14px_500)}>
							Tên loại giá
							<span className={'ml-1 text-red-500'}>*</span>
						</FormLabel>
						<FormControl>
							<Input
								placeholder={'Giá tiêu chuẩn'}
								className={cn(
									'h-10 px-3 py-2 text-neutral-600',
									TextVariants.caption_14px_400
								)}
								{...props}
								value={value}
								onChange={onChange}
							/>
						</FormControl>
						<FormMessage />
					</FormItem>
				)}
			/>

			<FormField
				name="rate_type"
				control={control}
				render={({ field: { onChange, value, ...props } }) => (
					<FormItem className="col-span-2 lg:col-span-1">
						<FormLabel
							className={cn(TextVariants.caption_14px_500)}>
							Rate type
							<span className={'ml-1 text-red-500'}>*</span>
						</FormLabel>
						<FormControl>
							<Input
								placeholder="OTA"
								className={cn(
									'h-10 px-3 py-2 text-neutral-600',
									TextVariants.caption_14px_400
								)}
								{...props}
								value={value}
								onChange={onChange}
							/>
						</FormControl>
						<FormMessage />
					</FormItem>
				)}
			/>
		</div>
	);
}
