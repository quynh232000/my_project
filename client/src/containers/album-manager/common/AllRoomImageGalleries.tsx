'use client';
import React, { useEffect, useState } from 'react';
import ImageGallerySection from '@/containers/album-manager/common/ImageGallerySection';
import { formatRoomImagesForImageUpload } from '@/containers/album-manager/data';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomStore } from '@/store/room/store';
import { IRoomItem } from '@/services/room/getRoomList';
import { useAttributeStore } from '@/store/attributes/store';
import { useAlbumHotelStore } from '@/store/album/store';
import { useShallow } from 'zustand/react/shallow';

const AllRoomImageGalleries = () => {
	const albumHotel = useAlbumHotelStore((state) => state.albumHotel);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { roomList, fetchRoomList } = useRoomStore(
		useShallow((state) => ({
			roomList: state.roomList,
			fetchRoomList: state.fetchRoomList,
		}))
	);
	const [roomImage, setRoomImage] = useState<IRoomItem[]>([]);
	const fetchImageRoomList = useAttributeStore(
		(state) => state.fetchImageRoomList
	);

	useEffect(() => {
		(async () => {
			setLoading(true);
			await Promise.all([fetchRoomList(), fetchImageRoomList()]).finally(
				() => setLoading(false)
			);
		})();
	}, []);

	useEffect(() => {
		if (albumHotel && roomList && roomList.length > 0) {
			setRoomImage(
				roomList.filter(
					(item) =>
						!Object.keys(albumHotel?.rooms).includes(
							String(item.id)
						)
				)
			);
		}
	}, [albumHotel, roomList]);
	return (
		<>
			{albumHotel &&
				albumHotel.rooms &&
				Object.values(albumHotel.rooms).length > 0 &&
				Object.values(albumHotel.rooms).map((item, index) => (
					<ImageGallerySection
						key={index}
						roomId={item.room.id}
						title={item.room.name}
						imageList={formatRoomImagesForImageUpload(item.images)}
					/>
				))}
			{roomImage.length > 0 &&
				roomImage.map((item, index) => (
					<ImageGallerySection
						key={index}
						roomId={item.id}
						title={item.name}
						imageList={[]}
					/>
				))}
		</>
	);
};

export default AllRoomImageGalleries;
