import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { TPriceType } from '@/lib/schemas/type-price/standard-price';
import { cn } from '@/lib/utils';
import { ERoomStatus } from '@/services/room/getRoomList';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomStore } from '@/store/room/store';
import { useEffect } from 'react';
import { Controller, useFormContext } from 'react-hook-form';
import { useShallow } from 'zustand/react/shallow';

const RoomTypeSelection = () => {
	const { control, setValue, getValues, formState } =
		useFormContext<TPriceType>();

	const { roomList, fetchRoomList } = useRoomStore(
		useShallow((state) => ({
			roomList: state.roomList,
			fetchRoomList: state.fetchRoomList,
		}))
	);
	const setLoading = useLoadingStore((state) => state.setLoading);

	const activeRoomList =
		roomList?.filter((room) => room.status === ERoomStatus.active) ?? [];

	useEffect(() => {
		setLoading(true);
		fetchRoomList().finally(() => setLoading(false));
	}, []);

	const toggleCheckAllTypeRoom = () => {
		const currentSelected = getValues('room_ids');
		const isAllChecked = currentSelected.length === activeRoomList?.length;
		const newArr = isAllChecked
			? []
			: (activeRoomList?.map((room) => room.id) ?? []);
		setValue('room_ids', newArr, { shouldValidate: true });
	};

	return (
		<Controller
			control={control}
			name={'room_ids'}
			render={({ field }) => (
				<div className={'space-y-4 rounded-2xl bg-white p-5'}>
					<h2 className={cn(TextVariants.caption_18px_700)}>
						Loại phòng áp dụng
						<span className={'ml-1 text-red-500'}>*</span>
					</h2>
					<CheckBoxView
						id={'all'}
						value={
							activeRoomList?.length > 0 &&
							activeRoomList?.length === field?.value?.length
						}
						onValueChange={toggleCheckAllTypeRoom}>
						<Typography
							tag={'p'}
							variant={'caption_14px_700'}
							className={'text-neutral-600'}>
							Áp dụng cho tất cả loại phòng{' '}
							<span className={'text-neutral-300'}>
								({activeRoomList?.length})
							</span>
						</Typography>
					</CheckBoxView>

					<div className={'grid grid-cols-3 gap-4 pl-7'}>
						<input ref={field.ref} className={'absolute h-0 w-0'} />
						{/*For trigger scrolling*/}
						{activeRoomList.map((room, index) => (
							<CheckBoxView
								key={index}
								id={String(room.id)}
								value={field.value.includes(room.id)}
								onValueChange={(val) => {
									if (val) {
										field.onChange([...field.value, room.id]);
									} else {
										field.onChange(
											field.value.filter((item) => item !== room.id)
										);
									}
								}}>
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
						className={'mt-4 block'}
					/>
				</div>
			)}
		/>
	);
};

export default RoomTypeSelection;
