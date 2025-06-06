import React, { useEffect } from 'react';
import Typography from '@/components/shared/Typography';
import { useFormContext, useWatch } from 'react-hook-form';
import IconQuestion from '@/assets/Icons/outline/IconQuestion';
import { RoomConfiguration } from '@/lib/schemas/setting-room/general-setting';
import { NumberInput } from '@/components/ui/number-input';
import { GlobalUI } from '@/themes/type';
import useDebounce from '@/hooks/use-debounce';
import { AppTooltip } from '@/components/shared/AppTooltip/AppTooltip';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';

export default function RoomPricing() {
	const { control, trigger } = useFormContext<RoomConfiguration>();
	const pricing = useWatch({
		control,
		name: 'pricing',
	});

	useEffect(() => {
		if (
			!isNaN(pricing.price_min) &&
			!isNaN(pricing.price_max) &&
			!isNaN(pricing.price_standard)
		) {
			checkMinMaxPrice();
		}
	}, [pricing]);

	const checkMinMaxPrice = useDebounce(() => {
		trigger('pricing').then();
	}, 200);

	return (
		<div className={'space-y-4 rounded-lg bg-white p-4'}>
			<Typography
				tag={'h3'}
				variant="content_16px_600"
				className={'text-neutral-600'}>
				Giá phòng
			</Typography>
			<div className={'grid grid-cols-3 gap-4'}>
				<FormField
					name="pricing.price_min"
					control={control}
					render={({ field: { value, onChange, ...props } }) => (
						<FormItem className={'col-span-3 space-y-2 lg:col-span-1'}>
							<FormLabel>
								Giá tối thiểu <span className={'text-red-500'}>*</span>
								<AppTooltip icon={<IconQuestion />} content={'Tooltip'} />
							</FormLabel>
							<div className={'relative'}>
								<FormControl>
									<NumberInput
										placeholder="1,200,000đ"
										inputMode={'numeric'}
										suffix={''}
										endAdornment={'đ'}
										className={'h-[44px] py-2 leading-6'}
										{...props}
										value={value}
										onValueChange={(e) => {
											onChange(e.value.length === 0 ? '' : Number(e.value));
										}}
									/>
								</FormControl>
							</div>
							<FormMessage />
						</FormItem>
					)}
				/>

				<FormField
					name="pricing.price_standard"
					control={control}
					render={({ field: { value, onChange, ...props } }) => (
						<FormItem className={'col-span-3 space-y-2 lg:col-span-1'}>
							<FormLabel>
								Giá cơ bản/phòng/đêm <span className={'text-red-500'}>*</span>
								<AppTooltip icon={<IconQuestion />} content={'Tooltip'} />
							</FormLabel>
							<div className={'relative'}>
								<FormControl>
									<NumberInput
										placeholder="1,200,000đ"
										inputMode={'numeric'}
										suffix={''}
										endAdornment={'đ'}
										className={'h-[44px] py-2 leading-6'}
										{...props}
										value={value}
										onValueChange={(e) => {
											onChange(e.value.length === 0 ? '' : Number(e.value));
										}}
									/>
								</FormControl>
							</div>
							<FormMessage />
						</FormItem>
					)}
				/>

				<FormField
					name="pricing.price_max"
					control={control}
					render={({ field: { value, onChange, ...props } }) => (
						<FormItem className={'col-span-3 space-y-2 lg:col-span-1'}>
							<FormLabel>
								Giá tối đa <span className={'text-red-500'}>*</span>
								<AppTooltip icon={<IconQuestion />} content={'Tooltip'} />
							</FormLabel>
							<div className={'relative'}>
								<FormControl>
									<NumberInput
										placeholder="1,200,000đ"
										inputMode={'numeric'}
										suffix={''}
										endAdornment={'đ'}
										className={'h-[44px] py-2 leading-6'}
										{...props}
										value={value}
										onValueChange={(e) => {
											onChange(e.value.length === 0 ? '' : Number(e.value));
										}}
									/>
								</FormControl>
							</div>
							<FormMessage />
						</FormItem>
					)}
				/>
			</div>
			<div
				className={
					'flex items-center gap-2 rounded-xl bg-secondary-00 px-3 py-2'
				}>
				<IconQuestion color={GlobalUI.colors.secondary['500']} />
				<Typography
					tag={'p'}
					variant={'caption_12px_600'}
					className={'text-secondary-500'}
					text={'Giá phòng tối đa phải lớn hơn giá phòng tối thiểu'}
				/>
			</div>
		</div>
	);
}
