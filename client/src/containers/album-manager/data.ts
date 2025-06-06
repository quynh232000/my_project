import { v4 as uuidv4 } from 'uuid';
import { RoomImage } from '@/services/album/getAlbumHotel';

export type TImageGalleryData = {
	id: string | number;
	tag: string;
	url: string;
	file: string | File;
	image_id: number;
	priority: number;
};

export const formatRoomImagesForImageUpload = (data: RoomImage[]): TImageGalleryData[] => {
	return data.map(item => ({
		id: uuidv4(),
		tag: String(item.label_id),
		url: item.image_url,
		file: '',
		image_id: item.id,
		priority: item.priority ?? 0,
	}))
}
