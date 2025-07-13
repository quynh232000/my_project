import { MAX_AGE_VALUE } from '@/containers/setting-room/RoomGeneralSetting/common/RoomExtraBeds';
import { z } from 'zod';

export enum EDepositAmountType {
	'fixed' = 'fixed',
	'percent' = 'percent',
}
export const EDepositMethod = z.enum(['cash', 'credit_card', 'banking']);

export const depositPolicySchema = z
	.object({
		amount: z
			.number({ message: 'Vui lòng nhập số tiền cọc' })
			.min(1, 'Vui lòng nhập số tiền cọc hợp lệ'),
		type_deposit: z
			.nativeEnum(EDepositAmountType)
			.default(EDepositAmountType.fixed),
		method_deposit: z
			.array(EDepositMethod, {
				required_error:
					'Vui lòng chọn ít nhất 1 phương thức đặt cọc được chấp nhận',
			})
			.min(
				1,
				'Vui lòng chọn ít nhất 1 phương thức đặt cọc được chấp nhận'
			),
	})
	.refine(
		(val) =>
			!(
				val.type_deposit === EDepositAmountType.percent &&
				val.amount > 100
			),
		{
			message: 'Số tiền cọc theo phần trăm vượt quá 100%',
			path: ['amount'],
		}
	)
	.refine(
		(val) =>
			!(
				val.type_deposit === EDepositAmountType.fixed &&
				val.amount > 999999999
			),
		{
			message: 'Số tiền cọc quá lớn',
			path: ['amount'],
		}
	);

export const agePolicySchema = z.object({
	age: z
		.number({ message: 'Vui lòng nhập độ tuổi tối thiểu nhận phòng' })
		.min(1, 'Vui lòng nhập độ tuổi tối thiểu nhận phòng hợp lệ'),
	adult_require: z
		.array(z.string())
		.min(1, 'Vui lòng chọn ít nhất một đối tượng đi kèm người lớn'),
	duccument_require: z
		.array(z.string())
		.min(1, 'Vui lòng chọn ít nhất một loại giấy tờ'),
	accompanying_adult_proof: z.boolean(),
});

const BreakfastFeeSchema = z
	.object({
		age_from: z.number(),
		age_to: z.number().gt(0, 'Bạn phải chọn tuổi').nullable(),
		fee_type: z.string().min(1, 'Loại phí không được để trống'),
		fee: z.union([z.number().lt(1000000000, 'Mức phí quá lớn'), z.nan()]),
	})
	.superRefine((val, ctx) => {
		if (val.fee_type !== 'free' && isNaN(val.fee)) {
			return ctx.addIssue({
				code: z.ZodIssueCode.custom,
				message: 'Loại phí không được để trống',
				path: ['fee'],
			});
		}
		if (val.fee_type === 'free' && val.fee > 0) {
			return ctx.addIssue({
				code: z.ZodIssueCode.custom,
				message: '',
				path: ['fee'],
			});
		}
		if (val.fee_type !== 'free' && val.fee < 1) {
			return ctx.addIssue({
				code: z.ZodIssueCode.custom,
				message: 'Vui lòng nhập mức phí hợp lệ',
				path: ['fee'],
			});
		}
		return true;
	});

export enum EUseBreakfastType {
	no = 'no',
	yes = 'yes',
}

export const breakfastServiceSchema = z
	.object({
		is_active: z.boolean(),
		time_from: z.string().optional(),
		time_to: z.string().optional(),
		breakfast_type: z.number().optional(),
		serving_type: z.number().optional(),
		isBreakfast: z
			.nativeEnum(EUseBreakfastType)
			.default(EUseBreakfastType.no),
		extra_breakfast: z
			.array(BreakfastFeeSchema)
			.superRefine((data, ctx) => {
				for (let i = 1; i < data.length; i++) {
					const prevAgeTo = data[i - 1].age_to;
					const currAgeTo = data[i].age_to;
					if (
						prevAgeTo !== null &&
						currAgeTo !== null &&
						+currAgeTo <= +prevAgeTo
					) {
						ctx.addIssue({
							code: z.ZodIssueCode.custom,
							message: 'Vui lòng chọn độ tuổi tăng dần',
							path: [`${i}.age_to`],
						});
					}
				}
			})
			.superRefine((data, ctx) => {
				if (
					data?.length > 0 &&
					data[data.length - 1].age_to !== Number(MAX_AGE_VALUE)
				) {
					return ctx.addIssue({
						code: z.ZodIssueCode.custom,
						message:
							'Vui lòng cài đặt giá bổ sung để bao gồm toàn bộ khung tuổi đi kèm',
						path: [`${data.length - 1}.age_to`],
					});
				}
			})
			.optional(),
	})
	.superRefine((data, ctx) => {
		if (data.is_active) {
			if (!data.time_from) {
				ctx.addIssue({
					path: ['time_from'],
					code: z.ZodIssueCode.custom,
					message: 'Vui lòng nhập thời gian bắt đầu',
				});
			}
			if (!data.time_to) {
				ctx.addIssue({
					path: ['time_to'],
					code: z.ZodIssueCode.custom,
					message: 'Vui lòng nhập thời gian kết thúc',
				});
			}
			if (
				data.breakfast_type === undefined ||
				data.breakfast_type === null
			) {
				ctx.addIssue({
					path: ['breakfast_type'],
					code: z.ZodIssueCode.custom,
					message: 'Vui lòng chọn kiểu',
				});
			}
			if (data.serving_type === undefined || data.serving_type === null) {
				ctx.addIssue({
					path: ['serving_type'],
					code: z.ZodIssueCode.custom,
					message: 'Vui lòng chọn loại',
				});
			}

			if (data.time_to && data.time_from) {
				const [fromHours, fromMinutes] = data.time_from.split(':');
				const [toHours, toMinutes] = data.time_to.split(':');

				const fromTotalMinutes = +fromHours * 60 + +fromMinutes;
				const toTotalMinutes = +toHours * 60 + +toMinutes;

				if (fromTotalMinutes > toTotalMinutes) {
					ctx.addIssue({
						path: ['time_to'],
						code: z.ZodIssueCode.custom,
						message: 'Giờ kết thúc không thể bé hơn giờ bắt đầu',
					});
				}
			}
		}
	});

export const otherPolicySchema = z.object({
	extraBed: z.boolean().default(false),
	deposit: depositPolicySchema.optional(),
	age: agePolicySchema,
	breakfast: breakfastServiceSchema.optional(),
});

export const depositPolicyObject = z.object({
	isActive: z.boolean({ message: 'Vui lòng chọn chính sách đặt cọc' }),
	deposit: depositPolicySchema.optional(),
});

export const breakfastServiceObject = z.object({
	breakfast: breakfastServiceSchema.optional(),
});

export type OtherPolicyFormValue = z.infer<typeof otherPolicySchema>;
export type DepositPolicyFormValue = z.infer<typeof depositPolicyObject>;
export type AgePolicyFormValue = z.infer<typeof agePolicySchema>;
export type BreakFastServiceFormValue = z.infer<typeof breakfastServiceObject>;
