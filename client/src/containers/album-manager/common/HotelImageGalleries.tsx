'use client';
import React from 'react';
import ImageGallerySection from '@/containers/album-manager/common/ImageGallerySection';
import { formatRoomImagesForImageUpload } from '@/containers/album-manager/data';
import { useAlbumHotelStore } from '@/store/album/store';
import SkeletonAlbumImage from '@/containers/album-manager/common/SkeletonAlbumImage';
import AllRoomImageGalleries from '@/containers/album-manager/common/AllRoomImageGalleries';

const HotelImageGalleries = () => {
	const albumHotel = useAlbumHotelStore((state) => state.albumHotel);
	return (
		<>
			{albumHotel ? (
				<>
					<ImageGallerySection
						title={'Tất cả ảnh'}
						imageList={
							albumHotel
								? formatRoomImagesForImageUpload(
										albumHotel.hotel
									)
								: []
						}
					/>
					<AllRoomImageGalleries />
				</>
			) : (
				<SkeletonAlbumImage />
			)}
		</>
	);
};

export default HotelImageGalleries;
