import { useEffect, useMemo } from 'react';
import { RoomImage } from '@/services/album/getAlbumHotel';
import { useAlbumHotelStore } from '@/store/album/store';
import { useAttributeStore } from '@/store/attributes/store';
import { useLoadingStore } from '@/store/loading/store';
import { useShallow } from 'zustand/react/shallow';

function capitalizeFirstWord(str: string): string {
	const lower = str.toLowerCase();
	return lower.charAt(0).toUpperCase() + lower.slice(1);
}

export function useImageCount() {
	const { albumHotel, fetchAlbumHotel } = useAlbumHotelStore(
		useShallow((state) => ({
			albumHotel: state.albumHotel,
			fetchAlbumHotel: state.fetchAlbumHotel,
		}))
	);
	const { imageTypeParentList, fetchImageTypeParentList } = useAttributeStore(
		useShallow((state) => ({
			imageTypeParentList: state.imageTypeParentList,
			fetchImageTypeParentList: state.fetchImageTypeParentList,
		}))
	);

	const setLoading = useLoadingStore((state) => state.setLoading);

	useEffect(() => {
		(async () => {
			setLoading(true);
			await Promise.all([
				fetchAlbumHotel(),
				fetchImageTypeParentList(),
			]).finally(() => setLoading(false));
		})();
	}, []);

	return useMemo(() => {
		const allImages: RoomImage[] = [
			...(albumHotel?.hotel || []),
			...Object.values(albumHotel?.rooms || {}).flatMap(
				(room) => room.images || []
			),
		];

		const counts: Record<
			string,
			{
				count: number;
				id: number;
				title: string;
			}
		> = {};

		if (imageTypeParentList) {
			for (const type of imageTypeParentList) {
				const name = type.name.replace(/^Ảnh\s*/i, ''); // Bỏ "Ảnh" đầu tiên nếu có
				counts[type.slug] = {
					count: 0,
					id: +type.id,
					title: capitalizeFirstWord(name),
				};
			}
		}

		for (const img of allImages) {
			const slug = img?.label?.parents?.slug;
			if (slug && counts.hasOwnProperty(slug)) {
				counts[slug] = {
					...counts[slug],
					count: counts[slug].count + 1,
				};
			}
		}

		const totalCount = allImages.length;
		return {
			totalCount,
			imageTypeParent: counts,
		};
	}, [albumHotel, imageTypeParentList]);
}
