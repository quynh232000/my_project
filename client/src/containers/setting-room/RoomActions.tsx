'use client';
import React from 'react';
import { Button } from '@/components/ui/button';
import { useRouter } from 'next/navigation';
import { DashboardRouter } from '@/constants/routers';
import { initialState, useRoomDetailStore } from '@/store/room-detail/store';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { IconDownload } from '@/assets/Icons/outline';
import SelectDisplayColumn from '@/components/shared/Select/SelectDisplayColumn';
import IconGrid from '@/assets/Icons/outline/IconGrid';
import { gridViewData } from '@/containers/setting-room/data';
import { GlobalUI } from '@/themes/type';
import { useRoomStore } from '@/store/room/store';
import { useShallow } from 'zustand/react/shallow';
import { IRoomItem } from '@/services/room/getRoomList';

const RoomActions = () => {
	const router = useRouter();
	const setRoomDetailState = useRoomDetailStore(
		(state) => state.setRoomDetailState
	);
	const { visibleFields, setVisibleFields } = useRoomStore(
		useShallow((state) => ({
			visibleFields: state.visibleFields,
			setVisibleFields: state.setVisibleFields,
		}))
	);
	// const [gridView, setGridView] = useState<TSelectCheckbox[]>(gridViewData)

	return (
		<div className={'flex items-center gap-2'}>
			<Button
				className={'h-7 rounded-lg px-3 py-1'}
				variant={'secondary'}
				onClick={() => {
					router.push(DashboardRouter.roomCreate);
					setRoomDetailState(initialState.roomDetail);
				}}>
				Thêm phòng mới
			</Button>
			<Button
				className={cn(
					'h-7 rounded-lg bg-white px-3 py-1 text-neutral-700 hover:opacity-80',
					TextVariants.caption_14px_600
				)}>
				<IconDownload
					color={GlobalUI.colors.neutrals['400']}
					className={'size-4'}
				/>
				Xuất file (.csv)
			</Button>
			<SelectDisplayColumn<keyof IRoomItem>
				containerWidthDefault={320}
				displayLabel={<IconGrid color={'#000'} className={'size-5'} />}
				className={'h-7 bg-white'}
				data={gridViewData}
				handleChangeData={(data) => setVisibleFields(data)}
				columns={visibleFields}
			/>
		</div>
	);
};

export default RoomActions;
