import { IRoomDetail } from '@/services/room/getRoomDetail';
import { RoomConfiguration } from '@/lib/schemas/setting-room/general-setting';
import { MAX_AGE_VALUE } from '@/containers/setting-room/RoomGeneralSetting/common/RoomExtraBeds';

export const mapToLabelValue = (
	items: { id: string | number; name: string }[]
) =>
	items && items.map((item) => ({
		label: item.name,
		value: item.id,
	}));

export function mapRoomDetailToRoomConfiguration(
	data: IRoomDetail
): RoomConfiguration {
	return {
		setup: {
			type_id: data.type_id,
			name_id: data.name_id,
			name_custom: data.name_custom ?? "",
			direction_id: data.direction_id,
			quantity: data.quantity,
			status: data.status === 'active', // 'active' => true, 'inactive' => false
			area: data.area,
		},
		capacity: {
			allow_extra_guests: data.allow_extra_guests === 1 ? 'both' : 'one',
			standard_guests: data.standard_guests,
			max_extra_adults: data.max_extra_adults,
			max_extra_children: data.max_extra_children,
			max_capacity: data.max_capacity,
		},
		bedInfo: {
			bed_type_id: data.bed_type_id,
			bed_quantity: data.bed_quantity,
			hasAlternativeBed: !!data.sub_bed_type_id,
			sub_bed_type_id: data.sub_bed_type_id,
			sub_bed_quantity: data.sub_bed_quantity,
		},
		pricing: {
			price_min: data.price_min,
			price_standard: data.price_standard,
			price_max: data.price_max,
		},
		extras: {
			breakfast: data.breakfast === 1,
			smoking: data.smoking === 1,
			hasExtraBed: data.extra_beds.length > 0,
			extra_beds: data.extra_beds.map((item) => ({
				...item,
				age_to: item.age_to === null ? Number(MAX_AGE_VALUE) : item.age_to,
			})),
		},
	};
}
