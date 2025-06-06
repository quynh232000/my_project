import React, { useEffect } from 'react';
import Typography from '@/components/shared/Typography';
import { useFormContext, useWatch } from 'react-hook-form';
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { RoomConfiguration } from '@/lib/schemas/setting-room/general-setting';
import IconQuestion from '@/assets/Icons/outline/IconQuestion';

import { NumberInput } from '@/components/ui/number-input';
import { AppTooltip } from '@/components/shared/AppTooltip/AppTooltip';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';

export default function RoomCapacity() {
	const { control, unregister } = useFormContext<RoomConfiguration>();

	const allowGuestType = useWatch({
		control: control,
		name: 'capacity.allow_extra_guests',
	});

	useEffect(() => {
		if (allowGuestType === 'one') {
			unregister('capacity.max_capacity');
		}
	}, [allowGuestType]);

	return (
		<div className={'space-y-4 rounded-lg bg-white p-4'}>
			<Typography
				tag={'h3'}
				variant="content_16px_600"
				className={'text-neutral-600'}>
				Sức chứa
			</Typography>

			<FormField
				name="capacity.allow_extra_guests"
				control={control}
				render={({ field }) => (
					<div className="flex flex-wrap items-center gap-8 lg:flex-nowrap">
						<Label className="flex cursor-pointer items-center gap-2">
							<input
								type="radio"
								className="peer hidden"
								{...field}
								value="both"
								checked={allowGuestType === 'both'}
							/>
							<div className="relative flex h-5 w-5 items-center justify-center rounded-full border-2 border-other-divider before:absolute before:h-[10px] before:w-[10px] before:rounded-full before:bg-transparent before:transition-all before:duration-300 before:content-[''] peer-checked:border-blue-500 peer-checked:before:bg-blue-500" />
							<Typography
								tag="span"
								variant="caption_14px_400"
								className="text-neutral-600"
								text="Cho phép ở thêm cả người lớn và trẻ em"
							/>
						</Label>

						<Label className="flex cursor-pointer items-center gap-2">
							<input
								type="radio"
								className="peer hidden"
								{...field}
								value="one"
								checked={allowGuestType === 'one'}
							/>
							<div className="relative flex h-5 w-5 items-center justify-center rounded-full border-2 border-other-divider before:absolute before:h-[10px] before:w-[10px] before:rounded-full before:bg-transparent before:transition-all before:duration-300 before:content-[''] peer-checked:border-blue-500 peer-checked:before:bg-blue-500" />
							<Typography
								tag="span"
								variant="caption_14px_400"
								className="text-neutral-600"
								text="Cho phép ở thêm một trong hai: Người lớn hoặc trẻ em"
							/>
						</Label>
					</div>
				)}
			/>

			<div
				className={`grid grid-cols-1 gap-4 md:grid-cols-2 ${allowGuestType === 'both' ? 'xl:grid-cols-4' : 'xl:grid-cols-3'}`}>
				<FormField
					name="capacity.standard_guests"
					control={control}
					render={({ field: { value, onChange, ...props } }) => (
						<FormItem className="col-span-2 space-y-2 lg:col-span-1">
							<FormLabel>
								<span className="truncate text-nowrap">
									Số khách tiêu chuẩn
								</span>
								<span className="text-red-500">*</span>
								<AppTooltip icon={<IconQuestion />} content="Tooltip" />
							</FormLabel>
							<FormControl>
								<NumberInput
									placeholder="2"
									inputMode="numeric"
									suffix=""
									className="h-[44px] py-2 leading-6"
									{...props}
									value={value}
									onValueChange={(e) => {
										onChange(e.value.length === 0 ? '' : Number(e.value));
									}}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>

				<FormField
					name="capacity.max_extra_adults"
					control={control}
					render={({ field: { value, onChange, ...props } }) => (
						<FormItem className="col-span-2 space-y-2 lg:col-span-1">
							<FormLabel>
								<span className="truncate text-nowrap">
									Số người lớn phụ thu tối đa
								</span>
								<span className="text-red-500">*</span>
								<AppTooltip icon={<IconQuestion />} content="Tooltip" />
							</FormLabel>
							<FormControl>
								<NumberInput
									placeholder="1"
									inputMode="numeric"
									suffix=""
									className="h-[44px] py-2 leading-6"
									{...props}
									value={value}
									onValueChange={(e) => {
										onChange(e.value.length === 0 ? '' : Number(e.value));
									}}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>

				<FormField
					name="capacity.max_extra_children"
					control={control}
					render={({ field: { value, onChange, ...props } }) => (
						<FormItem className="col-span-2 space-y-2 lg:col-span-1">
							<FormLabel>
								<span className="truncate text-nowrap">
									Số trẻ em phụ thu tối đa
								</span>
								<span className="text-red-500">*</span>
								<AppTooltip icon={<IconQuestion />} content="Tooltip" />
							</FormLabel>
							<FormControl>
								<NumberInput
									placeholder="1"
									inputMode="numeric"
									suffix=""
									className="h-[44px] py-2 leading-6"
									{...props}
									value={value}
									onValueChange={(e) => {
										onChange(e.value.length === 0 ? '' : Number(e.value));
									}}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>

				{allowGuestType === 'both' && (
					<FormField
						name="capacity.max_capacity"
						control={control}
						render={({ field: { value, onChange, ...props } }) => (
							<FormItem className="col-span-2 space-y-2 lg:col-span-1">
								<FormLabel>
									<span className="truncate text-nowrap">Sức chứa tối đa</span>
									<span className="text-red-500">*</span>
									<AppTooltip icon={<IconQuestion />} content="Tooltip" />
								</FormLabel>
								<FormControl>
									<NumberInput
										placeholder="1"
										inputMode="numeric"
										suffix=""
										className="h-[44px] py-2 leading-6"
										{...props}
										value={value}
										onValueChange={(e) => {
											onChange(e.value.length === 0 ? '' : Number(e.value));
										}}
									/>
								</FormControl>
								<FormMessage />
							</FormItem>
						)}
					/>
				)}
			</div>
			{allowGuestType === 'both' && (
				<div
					className={'flex items-start gap-2 rounded-xl bg-secondary-00 p-3'}>
					<div className={'mt-[3px]'}>
						<IconQuestion color={'#2A85FF'} />
					</div>
					<div>
						<Typography
							tag={'span'}
							variant={'caption_12px_600'}
							className={'text-secondary-500'}
							text={'Lưu ý'}
						/>
						<ul
							className={cn(
								'list-inside list-disc text-neutral-500',
								TextVariants.caption_12px_400
							)}>
							<li>
								Sức chứa tối đa không được phép lớn hơn tổng của số khách tiêu
								chuẩn + số người lớn phụ thu tối đa + Số trẻ em phụ thu tối đa.
							</li>
							<li>
								Sức chứa tối đa không được phép nhỏ hơn số khách tiêu chuẩn.
							</li>
						</ul>
					</div>
				</div>
			)}
		</div>
	);
}
