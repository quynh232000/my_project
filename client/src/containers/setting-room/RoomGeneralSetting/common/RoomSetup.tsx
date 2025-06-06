import React, { useEffect, useState } from 'react';
import Typography from '@/components/shared/Typography';
import { useFormContext, useWatch } from 'react-hook-form';
import SelectPopup, {
	OptionType,
} from '@/components/shared/Select/SelectPopup';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { RoomConfiguration } from '@/lib/schemas/setting-room/general-setting';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { NumberInput } from '@/components/ui/number-input';
import { Switch } from '@/components/ui/switch';
import { mapToLabelValue } from '@/containers/setting-room/helpers';
import { useAttributeStore } from '@/store/attributes/store';
import { useRoomDetailStore } from '@/store/room-detail/store';
import { useShallow } from 'zustand/react/shallow';

export default function RoomSetup() {
	const { control, setValue } = useFormContext<RoomConfiguration>();
	const { roomTypeList, directionList } = useAttributeStore(
		useShallow((state) => ({
			roomTypeList: state.roomTypeList,
			directionList: state.directionList,
		}))
	);
	const roomDetail = useRoomDetailStore((state) => state.roomDetail);
	const [roomNameList, setRoomNameList] = useState<OptionType[]>([]);
	const watchRoomType = useWatch({ control, name: 'setup.type_id' });
	useEffect(() => {
		if (roomTypeList && watchRoomType > 0 && roomTypeList.length > 0) {
			setRoomNameList(
				roomTypeList
					.find((roomType) => +roomType.id === watchRoomType)
					?.room_names.map((item) => ({
						label: item.name,
						value: item.id,
					})) ?? []
			);
		}
	}, [watchRoomType, roomTypeList]);

	return (
		<div className={'space-y-4 rounded-lg bg-white p-4'}>
			<div className={'flex items-center justify-between gap-2 rounded-lg'}>
				<Typography
					tag={'h3'}
					variant="content_16px_600"
					className={'flex-1 text-neutral-600'}>
					Thiết lập phòng
				</Typography>
				{roomDetail?.id > 0 && (
					<Typography
						tag={'p'}
						variant="caption_12px_600"
						className={'bg-green-50 px-4 py-1 text-accent-02'}>
						ID: #{roomDetail?.id}
					</Typography>
				)}
			</div>
			<div className={'grid grid-cols-3 gap-4'}>
				<FormField
					name="setup.type_id"
					control={control}
					render={({ field: { value, onChange, ...fieldProps } }) => (
						<FormItem className="col-span-12 w-full lg:col-span-1">
							<FormLabel required>Loại phòng</FormLabel>
							<FormControl>
								<SelectPopup
									placeholder="Chọn loại phòng"
									labelClassName="mb-2"
									className="h-[44px] rounded-lg bg-white py-2"
									controllerRenderProps={fieldProps}
									data={roomTypeList ? mapToLabelValue(roomTypeList) : []}
									selectedValue={value}
									onChange={(val) => {
										onChange(Number(val));
										setValue('setup.name_id', NaN);
									}}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>
				<FormField
					name="setup.name_id"
					control={control}
					render={({ field: { value, onChange, ...fieldProps } }) => (
						<FormItem className="col-span-12 w-full lg:col-span-1">
							<FormLabel required>Tên phòng</FormLabel>
							<FormControl>
								<SelectPopup
									placeholder="Chọn tên phòng"
									labelClassName="mb-2"
									className="h-[44px] rounded-lg bg-white py-2"
									controllerRenderProps={fieldProps}
									data={roomNameList}
									selectedValue={value}
									onChange={(val) => onChange(Number(val))}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>
				<FormField
					name={'setup.name_custom'}
					control={control}
					render={({ field }) => (
						<FormItem className="col-span-12 lg:col-span-1">
							<FormLabel>Tên tùy chọn (không bắt buộc)</FormLabel>
							<FormControl>
								<Input
									type="text"
									placeholder="Superior Double"
									className={'h-[44px] py-2 leading-6'}
									{...field}
									value={field.value ?? ''}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>
			</div>

			<div className={'grid grid-cols-3 items-start gap-4'}>
				<FormField
					name="setup.direction_id"
					control={control}
					render={({ field: { value, onChange, ...fieldProps } }) => (
						<FormItem className="col-span-12 w-full lg:col-span-1">
							<FormLabel required>Hướng phòng</FormLabel>
							<FormControl>
								<SelectPopup
									placeholder="Chọn hướng phòng"
									labelClassName="mb-2"
									className="h-[44px] rounded-lg bg-white py-2"
									controllerRenderProps={fieldProps}
									data={directionList ? mapToLabelValue(directionList) : []}
									selectedValue={value}
									onChange={(val) => onChange(Number(val))}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>
				<FormField
					name="setup.quantity"
					control={control}
					render={({ field: { value, onChange, ...fieldProps } }) => (
						<FormItem className="col-span-12 space-y-2 lg:col-span-1">
							<FormLabel required>Số lượng phòng</FormLabel>
							<FormControl>
								<NumberInput
									placeholder="20"
									inputMode="numeric"
									suffix=""
									className="h-[44px] py-2 leading-6"
									{...fieldProps}
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
					name="setup.area"
					control={control}
					render={({ field: { value, onChange, ...fieldProps } }) => (
						<FormItem className="col-span-12 space-y-2 lg:col-span-1">
							<FormLabel required>Diện tích phòng</FormLabel>
							<div className={'relative'}>
								<FormControl>
									<NumberInput
										placeholder="20"
										inputMode="numeric"
										suffix=""
										endAdornment={'m2'}
										className="h-[44px] py-2 leading-6"
										{...fieldProps}
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
			<div className={'grid grid-cols-3 items-start gap-4'}>
				<FormField
					name="setup.status"
					control={control}
					render={({ field: { value, onChange, ...fieldProps } }) => (
						<div className="col-span-12 flex flex-col lg:col-span-1">
							<Label required className="text-neutral-600">
								Trạng thái
							</Label>
							<div className="mt-2 flex flex-1 items-center gap-3">
								<label className="relative inline-block h-6 w-10">
									<Switch
										checked={value}
										onCheckedChange={onChange}
										{...fieldProps}
									/>
								</label>
								<Typography
									variant="caption_14px_400"
									className="text-neutral-600"
									text="Hoạt động"
								/>
							</div>
						</div>
					)}
				/>
			</div>
		</div>
	);
}
