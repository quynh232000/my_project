'use client';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Separator } from '@/components/ui/separator';
import RoomAmenities from '@/containers/setting-room/RoomAmenities/RoomAmenities';
import RoomGeneralSetting from '@/containers/setting-room/RoomGeneralSetting/RoomGeneralSetting';
import RoomImageSetting from '@/containers/setting-room/RoomImageSetting/RoomImageSetting';
import { cn } from '@/lib/utils';
import { IRoomDetail } from '@/services/room/getRoomDetail';
import { initialState, useRoomDetailStore } from '@/store/room-detail/store';
import { useRouter } from 'next/navigation';
import { useCallback, useEffect, useMemo } from 'react';
import { useShallow } from 'zustand/react/shallow';
import useTabStateWithQueryParam from '@/hooks/use-tab-state-with-query-param';
import { tabDefs } from '@/containers/setting-room/data';

interface SettingRoomProps {
	isEdit: boolean;
	roomDetail: IRoomDetail | null;
}

export default function SettingRoom({ isEdit, roomDetail }: SettingRoomProps) {
	const router = useRouter();
	const { setRoomDetailState, setAlbum, setServices } = useRoomDetailStore(
		useShallow((state) => ({
			setRoomDetailState: state.setRoomDetailState,
			setAlbum: state.setAlbum,
			setServices: state.setServices,
		}))
	);
	const { updateTab, selectedIndex } = useTabStateWithQueryParam(tabDefs);

	const handleNext = useCallback(() => {
		if (
			!roomDetail ||
			!roomDetail?.id ||
			selectedIndex === tabDefs.length - 1
		) {
			return router.back();
		}
		updateTab(selectedIndex !== null ? selectedIndex + 1 : 0);
	}, [roomDetail, selectedIndex, router, updateTab]);

	const components = useMemo(
		() => [
			<RoomGeneralSetting key={1} onNext={handleNext} />,
			<RoomImageSetting key={2} onNext={handleNext} />,
			<RoomAmenities key={3} onNext={handleNext} />,
		],
		[handleNext]
	);

	const renderTabs = useCallback(() => {
		return tabDefs.map((tab, index) =>
			!isEdit && index > 0 ? (
				<button
					key={index}
					disabled={true}
					className={cn(
						`cursor-not-allowed border-b-4 border-transparent pb-3 text-neutral-300 opacity-70`,
						TextVariants.content_16px_500
					)}>
					{tab.title}
				</button>
			) : (
				<button
					key={index}
					className={cn(
						`pb-3 text-neutral-300`,
						selectedIndex === index
							? 'border-b-4 border-primary-500 text-primary-500'
							: 'border-b-4 border-transparent',
						TextVariants.content_16px_500
					)}
					onClick={() => updateTab(index)}>
					{tab.title}
				</button>
			)
		);
	}, [tabDefs, isEdit, selectedIndex, updateTab]);

	useEffect(() => {
		if (!isEdit) {
			setRoomDetailState(initialState.roomDetail);
		} else if (roomDetail) {
			setRoomDetailState(roomDetail);
		}
	}, [isEdit, roomDetail, setRoomDetailState]);

	useEffect(() => {
		return () => {
			setAlbum(undefined);
			setServices(undefined);
		};
	}, [setAlbum, setServices]);

	return (
		<>
			<div className="flex w-full justify-start gap-6 text-left">
				{renderTabs()}
			</div>
			<Separator />
			{selectedIndex !== null ? components[selectedIndex] : null}
		</>
	);
}
