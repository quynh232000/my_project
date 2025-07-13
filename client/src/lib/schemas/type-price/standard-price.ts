import { z } from 'zod';
import { policySchema } from '@/lib/schemas/policy/validationChildPolicy';

export enum EPriceSetting {
	'new',
	'based_on_existing',
}

export enum ECancellationPolicy {
	'general',
	'custom',
}

export enum EExtraFee {
	'free',
	'charged',
}

export const StandardPriceSchema = z
	.object({
		id: z.number().optional(),
		name: z
			.string()
			.min(1, 'Vui lòng nhập tên loại giá')
			.max(50, 'Tên loại giá có tối đa 50 kí tự')
			.trim(),
		rate_type: z
			.string()
			.min(1, 'Vui lòng nhập rate type')
			.max(50, 'Rate type có tối đa 50 kí tự')
			.trim(),
		room_ids: z
			.array(z.number())
			.min(1, 'Phải chọn ít nhất một loại phòng'),
		priceSetting: z.nativeEnum(EPriceSetting, {
			required_error: 'Vui lòng chọn cách cài đặt giá',
		}),
		cancellationPolicy: z
			.object({
				type: z.nativeEnum(ECancellationPolicy, {
					required_error: 'Vui lòng chọn chính sách hoàn hủy',
				}),
				policy_cancel_id: z.number().optional(), // Chỉ cần nếu chọn custom
			})
			.refine(
				(data) =>
					data.type === ECancellationPolicy.general ||
					(data.type === ECancellationPolicy.custom &&
						!!data.policy_cancel_id),
				{
					message: 'Vui lòng chọn chính sách hoàn hủy riêng',
					path: ['policy_cancel_id'],
				}
			),
		extraChildFeeType: z.nativeEnum(EExtraFee, {
			required_error: 'Vui lòng chọn phí phụ thu người lớn',
		}),
		policy: policySchema.optional(),
		date_min: z
			.union([
				z.nan(),
				z
					.number({
						message: 'Vui lòng nhập số ngày đặt trước tối thiểu',
					})
					.gt(0, 'Vui lòng nhập số ngày đặt trước tối thiểu hợp lệ')
					.lt(365, 'Số ngày đặt trước tối thiểu không hợp lệ'),
			])
			.refine((val) => !isNaN(val), {
				message: 'Vui lòng nhập số ngày đặt trước tối thiểu',
			}),
		date_max: z
			.union([
				z.nan(),
				z
					.number({
						message: 'Vui lòng nhập số ngày đặt trước tối đa',
					})
					.gt(0, 'Vui lòng nhập số ngày đặt trước tối đa hợp lệ')
					.lt(365, 'Số ngày đặt trước tối đa không hợp lệ'),
			])
			.refine((val) => !isNaN(val), {
				message: 'Vui lòng nhập số ngày đặt trước tối đa',
			}),
		night_min: z
			.union([
				z.nan(),
				z
					.number({ message: 'Vui lòng nhập số đêm tối thiểu' })
					.gt(0, 'Vui lòng nhập số đêm tối thiểu hợp lệ')
					.lt(365, 'Số đêm tối thiểu tối thiểu không hợp lệ'),
			])
			.refine((val) => !isNaN(val), {
				message: 'Vui lòng nhập số đêm tối thiểu',
			}),
		night_max: z
			.union([
				z.nan(),
				z
					.number({ message: 'Vui lòng nhập số đêm tối đa' })
					.gt(0, 'Vui lòng nhập số đêm tối đa hợp lệ')
					.lt(365, 'Số đêm tối thiểu tối đa không hợp lệ'),
			])
			.refine((val) => !isNaN(val), {
				message: 'Vui lòng nhập số đêm tối đa',
			}),
		created_at: z.string().optional(),
		status: z.string().optional(),
		user: z
			.object({
				id: z.number(),
				full_name: z.string(),
			})
			.optional(),
	})
	.refine(
		(data) =>
			!data.date_min || !data.date_max || data.date_min <= data.date_max,
		{
			message:
				'Số ngày đặt trước tối thiểu không thể lớn hơn số ngày tối đa',
			path: ['date_min'],
		}
	)
	.refine(
		(data) =>
			!data.night_min ||
			!data.night_max ||
			data.night_min <= data.night_max,
		{
			message: 'Số đêm tối thiểu không thể lớn hơn số đêm tối đa',
			path: ['night_min'],
		}
	);

export type TPriceType = z.infer<typeof StandardPriceSchema>;

export const defaultStandardPriceData: TPriceType = {
	name: '',
	rate_type: '',
	room_ids: [],
	priceSetting: EPriceSetting.new,
	cancellationPolicy: {
		type: ECancellationPolicy.general,
		policy_cancel_id: 0,
	},
	extraChildFeeType: EExtraFee.free,
	policy: undefined,
	date_min: NaN,
	date_max: NaN,
	night_min: NaN,
	night_max: NaN,
};
