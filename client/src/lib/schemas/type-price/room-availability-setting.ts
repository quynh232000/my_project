import { z as validate } from 'zod';

export const weekDays = [1, 2, 3, 4, 5, 6, 7];
export const weekDaysStr = [
	'sunday',
	'monday',
	'tuesday',
	'wednesday',
	'thursday',
	'friday',
	'saturday',
];

export const dateRangeSchema = {
	date: validate.object(
		{
			from: validate.date({ message: 'Vui lòng chọn ngày bắt đầu' }),
			to: validate.date({ message: 'Vui lòng chọn ngày kết thúc' }),
		},
		{ message: 'Vui lòng chọn khoảng ngày' }
	),
};

export const roomTypesSchema = {
	room_ids: validate
		.array(validate.number())
		.min(1, 'Vui lòng chọn ít nhất một loại phòng'),
};

export const createRoomAvailabilitySettingSchema = (maxQuantity: number) => {
	return validate.object({
		...dateRangeSchema,
		...roomTypesSchema,
		day_of_week: validate
			.record(
				validate.string(),
				validate
					.object({
						count: validate.union([
							validate.nan(),
							validate
								.number()
								.min(0, 'Vui lòng nhập số phòng hợp lệ')
								.max(
									maxQuantity,
									`Số phòng không lớn hơn ${maxQuantity}`
								),
						]),
						active: validate.boolean().default(false),
					})
					.refine((val) => !val.active || !isNaN(val.count), {
						message: 'Vui lòng nhập số phòng',
						path: ['count'],
					})
			)
			.refine((val) => Object.values(val).some((item) => item.active), {
				message: 'Vui lòng thiết lập phòng ít nhất 1 ngày',
			}),
	});
};

export type RoomAvailabilitySettingType = validate.infer<
	ReturnType<typeof createRoomAvailabilitySettingSchema>
>;

export const roomAvailabilityDefaultValue: Partial<RoomAvailabilitySettingType> =
	{
		room_ids: [],
		day_of_week: Object.fromEntries(
			weekDays.map((key) => [key, { count: NaN, active: false }])
		),
	};
