import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import Typography from '@/components/shared/Typography';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { PromotionType } from '@/lib/schemas/discount/discount';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomStore } from '@/store/room/store';
import { GlobalUI } from '@/themes/type';
import { InfoIcon } from 'lucide-react';
import { useEffect } from 'react';
import { Controller, useFormContext } from 'react-hook-form';
import { useShallow } from 'zustand/react/shallow';

const PromotionRoomSelection = () => {
	const { control, formState, watch, setValue } =
		useFormContext<PromotionType>();
	const { roomList, fetchRoomList } = useRoomStore(
		useShallow((state) => ({
			roomList: state.roomList,
			fetchRoomList: state.fetchRoomList,
		}))
	);
	const setLoading = useLoadingStore((state) => state.setLoading);

	useEffect(() => {
		if (roomList?.length === 0) {
			setLoading(true);
			fetchRoomList().finally(() => setLoading(false));
		}
	}, [roomList]);

	return (
		<div className={'rounded-lg border border-blue-100 bg-white p-4'}>
			<Typography
				tag={'h2'}
				variant={'content_16px_600'}
				className={'text-neutral-600'}>
				Phòng nào sẽ được áp dụng khuyến mãi này?
			</Typography>
			<div className={'mt-4'}>
				<Controller
					control={control}
					name={'roomType.type'}
					render={({ field }) => (
						<RadioGroup
							value={field.value}
							onValueChange={(val) => {
								field.onChange(val);
								if (val === 'all') {
									setValue(
										'roomType.room_ids',
										roomList?.map((room) => room.id) ?? []
									);
								}
							}}>
							<div className="flex items-center space-x-2">
								<RadioGroupItem
									value="all"
									id="type_room_all"
									className={
										'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
									}
								/>
								<Label
									htmlFor="type_room_all"
									containerClassName={'mb-0'}
									className={
										'cursor-pointer text-neutral-600'
									}>
									Tất cả loại phòng có loại giá đã chọn
								</Label>
							</div>
							<div className="flex items-center space-x-4">
								<div className={'flex items-center space-x-2'}>
									<RadioGroupItem
										value="specific"
										id="type_room_specific"
										className={
											'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
										}
									/>
									<Label
										htmlFor="type_room_specific"
										containerClassName={'mb-0'}
										className={
											'cursor-pointer text-neutral-600'
										}>
										Chọn phòng
									</Label>
								</div>
								<Typography
									tag={'span'}
									variant={'caption_12px_600'}
									className={
										'flex items-center gap-2 rounded-lg bg-secondary-00 px-3 py-2 text-secondary-500'
									}>
									<InfoIcon
										className={'size-4'}
										color={GlobalUI.colors.secondary['500']}
									/>
									Chọn ít nhất một phòng
								</Typography>
							</div>
						</RadioGroup>
					)}
				/>
				{watch('roomType.type') === 'specific' && (
					<Controller
						control={control}
						name={'roomType.room_ids'}
						render={({ field }) => (
							<div className={'mt-4 pl-7'}>
								<div
									className={
										'flex flex-wrap items-center gap-6'
									}>
									{roomList?.map((room, index) => (
										<CheckBoxView
											value={field.value?.includes(
												room.id
											)}
											onValueChange={(val) => {
												const newArr = val
													? [
															...(field?.value ||
																[]),
															room.id,
														]
													: (
															field.value || []
														).filter(
															(val) =>
																val !== room.id
														);
												setValue(field.name, newArr, {
													shouldValidate: true,
												});
											}}
											id={String(room.id)}
											key={index}>
											<Typography
												tag={'p'}
												variant={'caption_14px_400'}
												className={'text-neutral-600'}>
												{room.name}
											</Typography>
										</CheckBoxView>
									))}
								</div>
								<FieldErrorMessage
									errors={formState.errors}
									name={field.name}
								/>
							</div>
						)}
					/>
				)}
			</div>
		</div>
	);
};

export default PromotionRoomSelection;
