import React from 'react';
import { useAlbumHotelStore } from '@/store/album/store';
import SkeletonAlbumImage from '@/containers/album-manager/common/SkeletonAlbumImage';
import AllRoomImageGalleries from '@/containers/album-manager/common/AllRoomImageGalleries';

const RoomImageGallery = () => {
	const albumHotel = useAlbumHotelStore((state) => state.albumHotel);

	return (
		<div className={'space-y-8'}>
			{albumHotel ? <AllRoomImageGalleries /> : <SkeletonAlbumImage />}
		</div>
	);
};

export default RoomImageGallery;
