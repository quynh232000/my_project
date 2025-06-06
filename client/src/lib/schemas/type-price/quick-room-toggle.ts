import { z as validate } from 'zod';
import {
	dateRangeSchema,
	roomTypesSchema,
} from '@/lib/schemas/type-price/room-availability-setting';

export const quickRoomToggleSchema = validate.object({
	...dateRangeSchema,
	...roomTypesSchema,
	status_room: validate.enum(['open', 'close']),
	day_of_week: validate
		.array(validate.number())
		.min(1, 'Vui lòng chọn ít nhất 1 ngày'),
});

export type QuickRoomToggleType = validate.infer<typeof quickRoomToggleSchema>;

export const quickRoomToggleValue: Partial<QuickRoomToggleType> = {
	room_ids: [],
	status_room: 'open' as 'close' | 'open',
	day_of_week: [],
};
