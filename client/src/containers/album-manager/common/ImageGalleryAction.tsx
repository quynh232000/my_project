'use client';
import React, { useMemo, useState } from 'react';
import { Button } from '@/components/ui/button';
import { useAlbumHotelStore } from '@/store/album/store';
import { TDeletedAlbumIds } from '@/store/album/type';
import DialogDeleteAllImage from '@/containers/album-manager/common/DialogDeleteAllImage';
import { useShallow } from 'zustand/react/shallow';

const ImageGalleryAction = () => {
	const { albumHotel, setDeletedAlbumIds, deletedAlbumIds, selectedTab } =
		useAlbumHotelStore(
			useShallow((state) => ({
				albumHotel: state.albumHotel,
				setDeletedAlbumIds: state.setDeletedAlbumIds,
				deletedAlbumIds: state.deletedAlbumIds,
				selectedTab: state.selectedTab,
			}))
		);

	const [openDialog, setOpenDialog] = useState(false);
	const hotelIds: TDeletedAlbumIds = useMemo(
		() =>
			albumHotel
				? albumHotel?.hotel?.map((item) => ({
						id: String(item.id),
						room_id: undefined,
					}))
				: [],
		[albumHotel]
	);
	const roomIds: TDeletedAlbumIds = useMemo(
		() =>
			albumHotel
				? Object?.values(albumHotel.rooms)
						.map((room) =>
							room.images.map((image) => ({
								id: String(image.id),
								room_id: String(image.point_id),
							}))
						)
						.flat(1)
				: [],
		[albumHotel]
	);
	return (
		(hotelIds.length > 0 || hotelIds.length > 0) && (
			<div className={'flex items-center gap-2'}>
				<Button
					variant={'secondary'}
					className={'h-10 rounded-lg'}
					onClick={() => {
						if (albumHotel) {
							let deletedIds = [];
							if (selectedTab === 'general') {
								deletedIds = hotelIds.concat(roomIds);
							} else if (selectedTab === 'image_room') {
								deletedIds = roomIds;
							} else {
								deletedIds = albumHotel.hotel
									.filter((image) => image.label?.parents?.slug === selectedTab)
									.map((image) => ({
										id: String(image.id),
										room_id: undefined,
									}));
							}
							deletedAlbumIds.length === deletedIds.length
								? setDeletedAlbumIds([])
								: setDeletedAlbumIds(deletedIds);
						}
					}}>
					{albumHotel
						? deletedAlbumIds.length < hotelIds.length + roomIds.length
							? 'Chọn tất cả ảnh'
							: 'Bỏ chọn tất cả ảnh'
						: 'Chọn tất cả ảnh'}
				</Button>
				<Button
					disabled={deletedAlbumIds.length === 0}
					variant={'destructive'}
					className={
						'h-10 rounded-lg bg-accent-03 text-white disabled:text-neutral-600'
					}
					onClick={() => setOpenDialog(true)}>
					Xóa ảnh đã chọn
				</Button>
				<DialogDeleteAllImage
					onClose={() => setOpenDialog(false)}
					open={openDialog}
				/>
			</div>
		)
	);
};

export default ImageGalleryAction;
