'use client';
import React, { useCallback, useEffect, useMemo, useState } from 'react';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Separator } from '@/components/ui/separator';
import HotelImageGalleries from '@/containers/album-manager/common/HotelImageGalleries';
import RoomImageGallery from '@/containers/album-manager/common/RoomImageGallery';
import HotelImageGalleryByLabel from '@/containers/album-manager/common/HotelImageGalleryByLabel';
import { useAttributeStore } from '@/store/attributes/store';
import { useLoadingStore } from '@/store/loading/store';
import { useImageCount } from '@/hooks/use-image-count';
import { useAlbumHotelStore } from '@/store/album/store';
import { useShallow } from 'zustand/react/shallow';

const AlbumManager = () => {
	const [selectedIndex, setSelectedIndex] = useState<number>(0);
	const updateTab = (index: number) => {
		setSelectedIndex(index);
	};
	const { totalCount, imageTypeParent } = useImageCount();
	const fetchImageTypeList = useAttributeStore(
		(state) => state.fetchImageTypeList
	);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { setDeletedAlbumIds, setSelectedTab } = useAlbumHotelStore(
		useShallow((state) => ({
			setDeletedAlbumIds: state.setDeletedAlbumIds,
			setSelectedTab: state.setSelectedTab,
		}))
	);

	useEffect(() => {
		setLoading(true);
		fetchImageTypeList().finally(() => setLoading(false));
	}, []);

	const tabs = useMemo(() => {
		const list = Object.entries(imageTypeParent).map(([key, value]) => ({
			title: `${value.title} (${value.count})`,
			key: key,
			component:
				key === 'image_room' ? (
					<RoomImageGallery />
				) : (
					<HotelImageGalleryByLabel label_id={value.id} />
				),
		}));
		return [
			{
				title: `Tất cả ảnh (${totalCount})`,
				key: 'general',
				component: <HotelImageGalleries />,
			},
			...list,
		];
	}, [totalCount, imageTypeParent]);

	const renderTabs = useCallback(() => {
		return tabs.map((tab, index) => (
			<button
				key={index}
				className={cn(
					`border-b-4 pb-3 text-neutral-300`,
					selectedIndex === index
						? 'border-primary-500 text-primary-500'
						: 'border-transparent',
					TextVariants.content_16px_500
				)}
				onClick={() => {
					updateTab(index);
					setDeletedAlbumIds([]);
					setSelectedTab(tab.key);
				}}>
				{tab.title}
			</button>
		));
	}, [tabs, selectedIndex, updateTab]);

	return (
		<>
			<div className="flex w-full flex-wrap justify-start gap-6 text-left">
				{renderTabs()}
			</div>
			<Separator />
			{selectedIndex !== null ? tabs[selectedIndex].component : null}
		</>
	);
};

export default AlbumManager;
