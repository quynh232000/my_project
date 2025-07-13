import React, { useState } from 'react';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import { IconStarFill } from '@/assets/Icons/outline';
import Image from 'next/image';
import { useFormContext } from 'react-hook-form';
import { AccommodationInfo } from '@/lib/schemas/property-profile/general-information';
import Typography from '@/components/shared/Typography';
import { NumberInput } from '@/components/ui/number-input';
import TimePicker from '@/components/ui/time-picker';
import { ALLOW_FILE_SIZE, ALLOW_FILE_TYPE } from '@/constants/common';
import { ImageDropzone } from '@/components/shared/ImageDropzone';
import { useAttributeStore } from '@/store/attributes/store';
import { mapToLabelValue } from '@/containers/setting-room/helpers';
import { useShallow } from 'zustand/react/shallow';

export default function GeneralInfo() {
	const [hoverIndex, setHoverIndex] = useState<number | null>(null);
	const { control } = useFormContext<AccommodationInfo>();
	const { accommodationTypeList, chainList } = useAttributeStore(
		useShallow((state) => ({
			accommodationTypeList: state.accommodationTypeList,
			chainList: state.chainList,
		}))
	);

	return (
		<div className={'space-y-6'}>
			<Typography
				tag={'h1'}
				text={'Thông tin chung'}
				variant="content_16px_600"
				className={'text-neutral-700'}
			/>
			<div className={'grid grid-cols-3 gap-6'}>
				<div className={'col-span-12 space-y-4 lg:col-span-2'}>
					<div className={'grid grid-cols-2 gap-4'}>
						<FormField
							name={'generalInfo.name'}
							control={control}
							render={({ field }) => (
								<FormItem
									className={
										'col-span-12 space-y-2 lg:col-span-1'
									}>
									<FormLabel required>Tên chỗ nghỉ</FormLabel>
									<FormControl>
										<Input
											type="text"
											placeholder="Sheraton Saigon Grand Opera Hotel"
											className={
												'h-[44px] py-2 leading-6'
											}
											{...field}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>
						<FormField
							name={'generalInfo.avg_price'}
							control={control}
							render={({
								field: { onChange, value, ...props },
							}) => (
								<FormItem
									className={
										'col-span-12 space-y-2 lg:col-span-1'
									}>
									<FormLabel required>
										Giá trung bình
									</FormLabel>
									<FormControl>
										<NumberInput
											placeholder="1,200,000đ"
											inputMode={'numeric'}
											suffix={'đ'}
											value={value}
											className={
												'h-[44px] py-2 leading-6'
											}
											{...props}
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
					<div className={'grid grid-cols-2 gap-4'}>
						<div className={'col-span-12 lg:col-span-1'}>
							<FormField
								name="generalInfo.accommodation_id"
								control={control}
								render={({
									field: { onChange, value, ...props },
								}) => (
									<FormItem
										className={
											'col-span-12 space-y-2 lg:col-span-1'
										}>
										<FormLabel required>
											Loại chỗ nghỉ
										</FormLabel>
										<FormControl>
											<SelectPopup
												required
												placeholder="Chọn loại chỗ nghỉ"
												onChange={onChange}
												selectedValue={value}
												data={
													accommodationTypeList
														? mapToLabelValue(
																accommodationTypeList
															)
														: []
												}
												labelClassName="mb-2"
												controllerRenderProps={props}
												className="h-[44px] rounded-lg bg-white py-2"
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
						</div>
						<div className={'col-span-12 space-y-2 lg:col-span-1'}>
							<FormField
								name={'generalInfo.stars'}
								control={control}
								render={({ field }) => (
									<FormItem
										className={'col-span-1 space-y-2'}>
										<FormLabel required>Hạng sao</FormLabel>
										<FormControl>
											<div
												className={
													'flex h-[44px] items-center'
												}>
												{[...Array(5)].map(
													(_, index) => (
														<IconStarFill
															key={index}
															width={24}
															height={24}
															className={`cursor-pointer transition-colors`}
															onMouseEnter={() =>
																setHoverIndex(
																	index
																)
															}
															onMouseLeave={() =>
																setHoverIndex(
																	null
																)
															}
															onClick={() =>
																field.onChange(
																	index + 1
																)
															}
															color={
																index + 1 <=
																	(field.value ??
																		-1) ||
																index <=
																	(hoverIndex ??
																		-1)
																	? '#F5D93D'
																	: '#E6E8EC'
															}
														/>
													)
												)}
											</div>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
						</div>
					</div>
					<div className={'grid grid-cols-2 gap-4'}>
						<div className={'col-span-12 lg:col-span-1'}>
							<FormField
								name={'generalInfo.chain_id'}
								control={control}
								render={({
									field: { onChange, value, ...props },
								}) => (
									<FormItem
										className={'col-span-1 space-y-2'}>
										<FormLabel>Thuộc chuỗi</FormLabel>
										<FormControl>
											<SelectPopup
												clearable
												required
												placeholder="Chọn chuỗi"
												onChange={onChange}
												selectedValue={value ?? ''}
												data={
													chainList
														? mapToLabelValue(
																chainList
															)
														: []
												}
												labelClassName="mb-2"
												controllerRenderProps={props}
												className="h-[44px] rounded-lg bg-white py-2"
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
						</div>
						<FormField
							name={'generalInfo.room_number'}
							control={control}
							render={({
								field: { value, onChange, ...props },
							}) => (
								<FormItem
									className={
										'col-span-12 space-y-2 lg:col-span-1'
									}>
									<FormLabel required>
										Số lượng phòng
									</FormLabel>
									<FormControl>
										<NumberInput
											placeholder="20"
											inputMode={'numeric'}
											suffix={''}
											value={value}
											{...props}
											className={
												'h-[44px] py-2 leading-6'
											}
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
					<div className={'grid grid-cols-2 gap-4'}>
						<div className={'col-span-12 lg:col-span-1'}>
							<FormField
								name={'generalInfo.time_checkin'}
								control={control}
								render={({ field }) => (
									<FormItem
										className={'col-span-1 space-y-2'}>
										<FormControl>
											<TimePicker
												required
												label={'Giờ nhận phòng'}
												triggerLabel={
													field.value
														? field.value?.slice(
																0,
																5
															)
														: ''
												}
												onChange={field.onChange}
												className={
													'h-[44px] rounded-lg bg-white py-2'
												}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
						</div>
						<div className={'col-span-12 lg:col-span-1'}>
							<FormField
								name={'generalInfo.time_checkout'}
								control={control}
								render={({ field }) => (
									<FormItem
										className={'col-span-1 space-y-2'}>
										<FormControl>
											<TimePicker
												required
												label={'Giờ trả phòng'}
												triggerLabel={
													field.value
														? field.value?.slice(
																0,
																5
															)
														: ''
												}
												onChange={field.onChange}
												className={
													'h-[44px] rounded-lg bg-white py-2'
												}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
						</div>
					</div>
				</div>
				<div className={'col-span-12 lg:col-span-1'}>
					<FormField
						name="generalInfo.image"
						control={control}
						render={({ field: { value, onChange, ref } }) => (
							<FormItem
								className={
									'col-span-12 space-y-2 lg:col-span-1'
								}>
								<FormLabel required>Ảnh đại diện</FormLabel>
								<div className="overflow-hidden rounded-xl">
									<FormControl>
										<ImageDropzone
											hoverEffect
											ref={ref}
											defaultImage={
												typeof value === 'string'
													? value
													: undefined
											}
											dropzoneClassName={
												'h-[212px] w-full cursor-pointer rounded-xl border-2 border-dashed border-inherit'
											}
											dimension={{
												width: 684,
												height: 456,
											}}
											placeholder={
												<div
													className={
														'flex flex-col items-center justify-center gap-2'
													}>
													<Image
														width={78}
														height={86}
														alt={'Image Upload'}
														priority
														src={
															'/images/pages/general-information/image-upload.png'
														}
														className={
															'h-[86px] w-[78px] object-cover'
														}
													/>
													<Typography
														tag="p"
														variant={
															'caption_12px_600'
														}
														className={
															'text-neutral-700'
														}>
														Kéo và thả tệp vào đây,
														hoặc duyệt
													</Typography>
												</div>
											}
											onSubmit={(file) =>
												onChange(file[0])
											}
										/>
									</FormControl>
								</div>
								<FormMessage />
							</FormItem>
						)}
					/>

					<ul
						className={
							'mt-4 list-inside list-disc space-y-2 text-sm font-medium leading-4 text-neutral-400'
						}>
						<li>
							Giữ hình ảnh dưới {ALLOW_FILE_SIZE / (1024 * 1024)}
							MB và định dạng {ALLOW_FILE_TYPE.join(', ')}
						</li>
						<li>Kích thước tối thiểu: 684px x 456px</li>
					</ul>
				</div>
			</div>
		</div>
	);
}
