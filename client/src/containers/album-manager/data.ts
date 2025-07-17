import { v4 as uuidv4 } from 'uuid';
import { RoomImage } from '@/services/album/getAlbumHotel';
import { arrayMove } from '@dnd-kit/sortable';

export type TImageGalleryData = {
	id: string | number;
	tag: string;
	url: string;
	file: string | File;
	image_id: number;
	priority: number;
};

export const formatRoomImagesForImageUpload = (
	data: RoomImage[]
): TImageGalleryData[] => {
	return data.map((item) => ({
		id: uuidv4(),
		tag: String(item.label_id),
		url: item.image_url,
		file: '',
		image_id: item.id,
		priority: item.priority ?? 0,
	}));
};

export function reorderList<T extends { priority: number }>(
	list: T[],
	oldIndex: number,
	newIndex: number
): T[] {
	const newList = arrayMove(list, oldIndex, newIndex);

	const from = Math.min(oldIndex, newIndex);
	const to = Math.max(newIndex, oldIndex);
	const oldPriority = list.slice(from, to + 1).map((item) => item.priority);

	for (let i = from; i <= to; i++) {
		newList[i] = {
			...newList[i],
			priority: oldPriority[i - from],
		};
	}

	return newList;
}
