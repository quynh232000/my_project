import { TPriceHistoryAPI } from '@/services/room-config/getRoomPriceHistory';

export type TPriceHistory = {
	id: string | number;
	updated_date: string;
	created_by: string;
	room_name: string;
	type_price: string;
	old_price: string;
	new_price: string;
	apply_date: string;
};

export const mapPriceHistory = (data: TPriceHistoryAPI[]) => {
	return data?.map((item) => ({
		id: item.id,
		updated_date: new Date(item.created_at).toLocaleString('vi-VN'),
		created_by: item.created_by?.full_name,
		room_name: item.room.name,
		new_price: item.price.toLocaleString('vi-VN'),
		old_price: item.price.toLocaleString('vi-VN'),
		type_price: item?.price_type?.name || 'Giá tiêu chuẩn',
		apply_date: `${new Date(item.start_date).toLocaleDateString('vi-VN')} - ${new Date(item.end_date).toLocaleDateString('vi-VN')}`,
	}));
};
