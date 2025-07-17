import { priceConvert } from '@/utils/string/priceConvert';
import { z } from 'zod';

export const createDialogPricingSettingSchema = (data: {
	price_min: number;
	price_max: number;
	price_standard: number;
	standard_capacity: number;
}) => {
	const { price_min, price_max, price_standard, standard_capacity } = data;
	const roomCapacitySchema = z
		.object({
			status: z.string(),
			price: z.union([z.number(), z.nan()]),
			capacity: z.number(),
		})
		.refine((val) => val.status === 'inactive' || !isNaN(val.price), {
			message: `Vui lòng nhập giá`,
			path: ['price'],
		})
		.refine(
			(val) =>
				val.status === 'inactive' ||
				val.capacity >= standard_capacity ||
				price_standard - val.price >= price_min,
			{
				message: `Giá không được lớn hơn ${priceConvert(price_standard - price_min)}`,
				path: ['price'],
			}
		)
		.refine(
			(val) =>
				val.status === 'inactive' ||
				val.capacity <= standard_capacity ||
				val.price + price_standard <= price_max,
			{
				message: `Giá không được lớn hơn ${priceConvert(price_max - price_standard)}`,
				path: ['price'],
			}
		);

	const dialogPricingSettingSchema = z.object({
		room_id: z.number(),
		price_type_id: z.number(),
		data: z.array(roomCapacitySchema.optional()),
	});

	return dialogPricingSettingSchema;
};

export type DialogPricingSettingType = z.infer<
	ReturnType<typeof createDialogPricingSettingSchema>
>;
