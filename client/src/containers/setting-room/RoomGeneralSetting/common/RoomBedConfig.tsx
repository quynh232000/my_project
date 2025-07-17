import React, { useEffect } from 'react';
import Typography from '@/components/shared/Typography';
import { Controller, useFormContext, useWatch } from 'react-hook-form';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import { RoomConfiguration } from '@/lib/schemas/setting-room/general-setting';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import { NumberInput } from '@/components/ui/number-input';
import { Switch } from '@/components/ui/switch';
import { mapToLabelValue } from '@/containers/setting-room/helpers';
import { useAttributeStore } from '@/store/attributes/store';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';

const RoomBedConfig = () => {
	const { setValue, watch, formState, control } =
		useFormContext<RoomConfiguration>();
	const bedTypeList = useAttributeStore((state) => state.bedTypeList);
	const watchHasAlternativeBed = useWatch({
		control,
		name: 'bedInfo.hasAlternativeBed',
	});

	useEffect(() => {
		if (!watchHasAlternativeBed) {
			setValue('bedInfo.sub_bed_type_id', null);
			setValue('bedInfo.sub_bed_quantity', null);
		}
	}, [watchHasAlternativeBed]);

	return (
		<div className={'space-y-4 rounded-lg bg-white p-4'}>
			<Typography
				tag={'h3'}
				variant="content_16px_600"
				className={'text-neutral-600'}>
				Loại giường
			</Typography>
			<div className={'grid grid-cols-2 gap-4'}>
				<FormField
					name="bedInfo.bed_type_id"
					control={control}
					rules={{
						deps: ['bedInfo.sub_bed_type_id'],
					}}
					render={({ field: { value, onChange, ...props } }) => (
						<FormItem className={'col-span-12 lg:col-span-1'}>
							<FormLabel required>Loại giường chính</FormLabel>
							<FormControl>
								<SelectPopup
									className="h-[44px] rounded-lg bg-white py-2"
									labelClassName="mb-2"
									placeholder={'Chọn loại giường chính'}
									controllerRenderProps={props}
									data={
										bedTypeList
											? mapToLabelValue(bedTypeList)
											: []
									}
									selectedValue={value}
									onChange={(value) => {
										onChange(Number(value));
									}}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>
				<FormField
					name="bedInfo.bed_quantity"
					control={control}
					render={({ field: { value, onChange, ...props } }) => (
						<FormItem
							className={'col-span-12 space-y-2 lg:col-span-1'}>
							<FormLabel required>Số lượng</FormLabel>
							<FormControl>
								<NumberInput
									className={'h-[44px] py-2 leading-6'}
									inputMode={'numeric'}
									suffix={''}
									placeholder="4"
									{...props}
									value={value}
									onValueChange={(e) => {
										onChange(
											e.value.length === 0
												? ''
												: Number(e.value)
										);
									}}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>
			</div>
			<Controller
				control={control}
				name="bedInfo.hasAlternativeBed"
				render={({ field: { value, onChange, name } }) => (
					<div className={'space-y-2'}>
						<div className={'flex flex-1 items-center gap-3'}>
							<label className="relative inline-block h-6 w-10">
								<Switch
									checked={value}
									onCheckedChange={(val) => {
										onChange(val);
									}}
								/>
							</label>

							<Typography
								tag={'p'}
								variant={'caption_14px_400'}
								className={'text-neutral-600'}
								text={'Kiểu giường thay thế'}
							/>
						</div>
						<FieldErrorMessage
							errors={formState.errors}
							name={name}
						/>
					</div>
				)}
			/>
			{watch('bedInfo.hasAlternativeBed') && (
				<div className={'grid grid-cols-2 gap-4'}>
					<FormField
						name="bedInfo.sub_bed_type_id"
						control={control}
						render={({ field: { value, onChange, ...props } }) => (
							<FormItem
								className={
									'col-span-2 space-y-2 lg:col-span-1'
								}>
								<FormLabel required>
									Kiểu giường thay thế
								</FormLabel>
								<FormControl>
									<SelectPopup
										className="h-[44px] rounded-lg bg-white py-2"
										labelClassName="mb-2"
										placeholder={
											'Chọn kiểu giường thay thế'
										}
										controllerRenderProps={props}
										data={
											bedTypeList
												? mapToLabelValue(bedTypeList)
												: []
										}
										selectedValue={value ?? undefined}
										onChange={(value) => {
											onChange(Number(value));
										}}
									/>
								</FormControl>
								<FormMessage />
							</FormItem>
						)}
					/>

					<FormField
						name="bedInfo.sub_bed_quantity"
						control={control}
						render={({ field: { value, onChange, ...props } }) => (
							<FormItem
								className={
									'col-span-2 space-y-2 lg:col-span-1'
								}>
								<FormLabel required>Số lượng</FormLabel>
								<FormControl>
									<NumberInput
										className={'h-[44px] py-2 leading-6'}
										inputMode={'numeric'}
										suffix={''}
										placeholder="4"
										{...props}
										value={String(value)}
										onValueChange={(e) => {
											onChange(
												e.value.length === 0
													? ''
													: Number(e.value)
											);
										}}
									/>
								</FormControl>
								<FormMessage />
							</FormItem>
						)}
					/>
				</div>
			)}
		</div>
	);
};

export default RoomBedConfig;
