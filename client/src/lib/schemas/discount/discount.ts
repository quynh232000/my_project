import { z as validate } from 'zod';

export const discountTypes = [
	'each_nights',
	'day_of_weeks',
	'first_night',
] as const;
export type DiscountType = typeof discountTypes;
export const selectionTypes = ['all', 'specific'] as const;
export type SelectionType = typeof selectionTypes;

export const promotionSchema = validate.object({
	name: validate.string().min(1, 'Tên khuyến mãi không được để trống'),
	priceType: validate
		.object({
			type: validate.enum(selectionTypes), // Chọn tất cả hoặc chọn loại giá cụ thể
			price_type_ids: validate.array(validate.number()), // Danh sách loại giá được chọn nếu chọn "specific"
		})
		.refine(
			(data) => {
				if (
					data.type === 'specific' &&
					(!data.price_type_ids || data.price_type_ids.length === 0)
				) {
					return false;
				}
				return true;
			},
			{
				message: 'Bạn phải chọn ít nhất 1 loại giá',
				path: ['price_type_ids'],
			}
		),

	roomType: validate
		.object({
			type: validate.enum(selectionTypes), // Chọn tất cả hoặc chọn loại phòng cụ thể
			room_ids: validate.array(validate.number()), // Danh sách loại phòng được chọn nếu chọn "specific"
		})
		.refine(
			(data) => {
				if (
					data.type === 'specific' &&
					(!data.room_ids || data.room_ids.length === 0)
				) {
					return false;
				}
				return true;
			},
			{
				message: 'Bạn phải chọn ít nhất 1 loại phòng',
				path: ['room_ids'],
			}
		),
	discountType: validate
		.object({
			type: validate.enum(discountTypes),
			discount: validate
				.number({ required_error: 'Vui lòng nhập % giảm giá' })
				.min(0, 'Tối thiểu 0%')
				.max(100, 'Tối đa 100%')
				.optional(),
			specificDaysDiscount: validate
				.array(
					validate.object({
						day_of_week: validate.number(),
						value: validate
							.number({
								required_error:
									'Vui lòng nhập % giảm giá cho từng ngày',
							})
							.min(0, 'Tối thiểu 0%')
							.max(100, 'Tối đa 100%')
							.nullable(),
					})
				)
				.optional(),
		})
		.refine(
			(data) => {
				return !(
					(data.type === 'each_nights' ||
						data.type === 'first_night') &&
					data.discount === undefined
				);
			},
			{
				message: 'Vui lòng nhập % giảm giá',
				path: ['discount'],
			}
		)
		.refine(
			(data) =>
				!(
					data.type === 'day_of_weeks' &&
					(!data.specificDaysDiscount ||
						data.specificDaysDiscount.filter(
							(d) => d.value !== null
						).length === 0)
				),
			{
				message: 'Phải nhập ít nhất 1 ngày có giảm giá',
				path: ['specificDaysDiscount'],
			}
		),
	discountDuration: validate
		.object({
			start_date: validate.date(),
			end_date: validate.date().nullable(),
			noExpiry: validate.boolean(),
		})
		.refine(
			(data) => {
				return !(!data.noExpiry && !data.end_date);
			},
			{
				message: 'Bạn phải chọn ngày kết thúc',
				path: ['end_date'],
			}
		)
		.refine(
			(data) => {
				return !(
					data.end_date &&
					data.end_date?.getTime() < data.start_date?.getTime()
				);
			},
			{
				message: 'Ngày kết thúc phải lớn hơn ngày bắt đầu',
				path: ['end_date'],
			}
		),
	is_stackable: validate.boolean(), // Cho phép cộng dồn khuyến mãi hay không
});

export const defaultDiscountValues: PromotionType = {
	name: '',
	priceType: { type: selectionTypes[0], price_type_ids: [] },
	roomType: { type: selectionTypes[0], room_ids: [] },
	discountType: {
		type: discountTypes[0],
		discount: undefined,
		specificDaysDiscount: [],
	},
	discountDuration: {
		end_date: new Date(),
		start_date: new Date(),
		noExpiry: false,
	},
	is_stackable: false,
};

export type PromotionType = validate.infer<typeof promotionSchema>;
