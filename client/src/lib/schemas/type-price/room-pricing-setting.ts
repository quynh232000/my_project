import { z as validate } from 'zod';
import {
	dateRangeSchema,
	roomTypesSchema,
	weekDays,
} from '@/lib/schemas/type-price/room-availability-setting';
import { priceConvert } from '@/utils/string/priceConvert';

export const roomPricingSettingSchema = validate.object({
	...dateRangeSchema,
	price_type: validate
		.array(validate.number())
		.min(1, 'Vui lòng chọn loại giá'),
	...roomTypesSchema,
	is_overwrite: validate.boolean(),
	day_of_week: validate
		.record(
			validate.string(),
			validate
				.object({
					price: validate.union([
						validate.nan(),
						validate
							.number()
							.min(1, 'Vui lòng nhập số tiền hợp lệ')
							.max(999999999, 'Số tiền quá lớn'),
					]),
					active: validate.boolean().default(false),
				})
				.refine(
					(val) => !val.active || !isNaN(val.price) || val.price <= 0,
					{
						message: 'Vui lòng nhập giá',
						path: ['price'],
					}
				)
		)
		.refine((val) => Object.values(val).some((item) => item.active), {
			message: 'Vui lòng thiết lập giá ít nhất 1 ngày',
		}),
});

export const createRoomPricingSettingSchema = (data: {
	price_min: number;
	price_max: number;
}) => {
	const { price_min, price_max } = data;

	return validate.object({
		...dateRangeSchema,
		price_type: validate
			.array(validate.number())
			.min(1, 'Vui lòng chọn loại giá'),
		...roomTypesSchema,
		is_overwrite: validate.boolean(),
		day_of_week: validate
			.record(
				validate.string(),
				validate
					.object({
						price: validate.union([
							validate.nan(),
							validate
								.number()
								.min(
									price_min,
									`Giá phải từ ${priceConvert(price_min)} trở lên`
								)
								.max(
									price_max,
									`Giá không được vượt quá ${priceConvert(price_max)}`
								),
						]),
						active: validate.boolean().default(false),
					})
					.refine(
						(val) =>
							!val.active || !isNaN(val.price) || val.price <= 0,
						{
							message: 'Vui lòng nhập giá',
							path: ['price'],
						}
					)
			)
			.refine((val) => Object.values(val).some((item) => item.active), {
				message: 'Vui lòng thiết lập giá ít nhất 1 ngày',
			}),
	});
};

export type RoomPricingSettingType = validate.infer<
	typeof roomPricingSettingSchema
>;

export const roomPricingDefaultValue: Partial<RoomPricingSettingType> = {
	is_overwrite: true,
	price_type: [],
	room_ids: [],
	day_of_week: Object.fromEntries(
		weekDays.map((key) => [key, { price: NaN, active: false }])
	),
};
