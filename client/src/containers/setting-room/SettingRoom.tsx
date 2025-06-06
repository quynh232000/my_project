'use client';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Separator } from '@/components/ui/separator';
import RoomAmenities from '@/containers/setting-room/RoomAmenities/RoomAmenities';
import RoomGeneralSetting from '@/containers/setting-room/RoomGeneralSetting/RoomGeneralSetting';
import RoomImageSetting from '@/containers/setting-room/RoomImageSetting/RoomImageSetting';
import { cn } from '@/lib/utils';
import { IRoomDetail } from '@/services/room/getRoomDetail';
import { initialState, useRoomDetailStore } from '@/store/room-detail/store';
import { useRouter, useSearchParams, usePathname } from 'next/navigation';
import { useCallback, useEffect, useMemo, useState } from 'react';
import { useShallow } from 'zustand/react/shallow';

interface SettingRoomProps {
	isEdit: boolean;
	roomDetail: IRoomDetail | null;
}

export default function SettingRoom({ isEdit, roomDetail }: SettingRoomProps) {
	const router = useRouter();
	const pathname = usePathname();
	const searchParams = useSearchParams();
	const [selectedIndex, setSelectedIndex] = useState<number | null>(null);
	const [isParsedParams, setIsParsedParams] = useState<boolean>(false);
	const { setRoomDetailState, setAlbum, setServices } = useRoomDetailStore(
		useShallow((state) => ({
			setRoomDetailState: state.setRoomDetailState,
			setAlbum: state.setAlbum,
			setServices: state.setServices,
		}))
	);

	const updateUrlWithTab = useCallback(
		(newTabKey: string) => {
			const params = new URLSearchParams(searchParams.toString());
			params.set('tab', newTabKey);
			window.history.replaceState(
				{},
				'',
				`${pathname}?${params.toString()}`
			);
		},
		[searchParams, pathname]
	);

	const updateTab = (index: number) => {
		setSelectedIndex(index);
	};

	const handleNext = useCallback(() => {
		if (!roomDetail || !roomDetail?.id || selectedIndex === tabs.length - 1) {
			return router.back();
		}
		updateTab(selectedIndex !== null ? selectedIndex + 1 : 0);
	}, [roomDetail, selectedIndex, router, updateTab]);

	const tabs = useMemo(
		() => [
			{
				title: 'Thiết lập chung',
				key: 'general',
				component: <RoomGeneralSetting onNext={handleNext} />,
			},
			{
				title: 'Hình ảnh phòng',
				key: 'image',
				component: <RoomImageSetting onNext={handleNext} />,
			},
			{
				title: 'Tiện ích phòng',
				key: 'amenities',
				component: <RoomAmenities onNext={handleNext} />,
			},
		],
		[handleNext]
	);

	const renderTabs = useCallback(() => {
		return tabs.map((tab, index) =>
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
	}, [tabs, isEdit, selectedIndex, updateTab]);

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

	useEffect(() => {
		if (!isParsedParams) {
			const tabKey = searchParams.get('tab');
			const foundIndex = tabs.findIndex((tab) => tab.key === tabKey);
			if (
				(!isEdit && (tabKey === 'image' || tabKey === 'amenities')) ||
				foundIndex === -1
			) {
				updateTab(0);
			} else {
				updateTab(foundIndex);
			}
			setIsParsedParams(true);
		}
	}, [searchParams, isEdit, tabs, isParsedParams]);

	useEffect(() => {
		if (selectedIndex !== null) {
			const newTabKey = tabs[selectedIndex].key;
			updateUrlWithTab(newTabKey);
		}
	}, [selectedIndex]);

	return (
		<>
			<div className="flex w-full justify-start gap-6 text-left">
				{renderTabs()}
			</div>
			<Separator />
			{selectedIndex !== null ? tabs[selectedIndex].component : null}
		</>
	);
}
