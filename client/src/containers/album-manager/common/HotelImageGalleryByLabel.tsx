'use client';
import React, { useEffect, useState } from 'react';
import { formatRoomImagesForImageUpload } from '@/containers/album-manager/data';
import ImageGallerySection from '@/containers/album-manager/common/ImageGallerySection';
import { useAlbumHotelStore } from '@/store/album/store';
import { RoomImage } from '@/services/album/getAlbumHotel';
import SkeletonAlbumImage from '@/containers/album-manager/common/SkeletonAlbumImage';

const HotelImageGalleryByLabel = ({ label_id }: { label_id: number }) => {
	const albumHotel = useAlbumHotelStore((state) => state.albumHotel);
	const [albumImages, setAlbumImages] = useState<RoomImage[]>([]);
	useEffect(() => {
		if (
			albumHotel &&
			albumHotel?.hotel &&
			albumHotel.hotel.length > 0 &&
			label_id > 0
		) {
			setAlbumImages(
				albumHotel.hotel.filter(
					(item) => item.label?.parent_id === label_id
				)
			);
		}
	}, [albumHotel, label_id]);

	return albumHotel ? (
		<ImageGallerySection
			labelParentId={label_id}
			imageList={
				albumImages ? formatRoomImagesForImageUpload(albumImages) : []
			}
		/>
	) : (
		<SkeletonAlbumImage />
	);
};

export default HotelImageGalleryByLabel;
