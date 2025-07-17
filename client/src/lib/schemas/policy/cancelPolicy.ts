import { z } from 'zod';

export const ABSENT_VALUE = 0;

export enum ECancelFeeType {
	FREE = 'free',
	FEE = 'percent_price',
}

const cancelPolicyRowItemSchema = z
	.object({
		day: z
			.number({ message: 'Vui lòng nhập số ngày' })
			.max(30, 'Số ngày không được vượt quá 30 ngày'),
		fee: z.union([z.nan(), z.number({ message: 'Vui lòng nhập phí' })]),
		fee_type: z.nativeEnum(ECancelFeeType),
	})
	.refine(
		(val) => {
			return !(
				val.fee_type === ECancelFeeType.FEE &&
				(isNaN(val.fee) || val.fee <= 0 || val.fee > 100)
			);
		},
		{
			message: 'Vui lòng nhập phí hợp lệ (0% < phí ≤ 100%)',
			path: ['fee'],
		}
	);

const cancelPolicyRowSchema = z
	.array(cancelPolicyRowItemSchema)
	.superRefine((val, ctx) => {
		val.every((row, index) => {
			if (index > 0 && row.day <= 0) {
				return ctx.addIssue({
					code: z.ZodIssueCode.custom,
					message: 'Vui lòng nhập ngày lớn hơn 0',
					path: [`${index}.day`],
				});
			}
			if (index > 1) {
				if (row.day >= val[index - 1].day) {
					return ctx.addIssue({
						code: z.ZodIssueCode.custom,
						message:
							'Vui lòng nhập giảm dần ngày trước ngày check-in',
						path: [`${index}.day`],
					});
				}
				return true;
			}
			return true;
		});
	});

export const cancelPolicySchema = z.object({
	cancelable: z.boolean().default(false),
	rows: cancelPolicyRowSchema,
});

export const separatelyPolicySchema = z.object({
	id: z.number().optional(),
	code: z
		.string({ message: 'Vui lòng nhập mã chính sách' })
		.min(1, 'Vui lòng nhập mã chính sách')
		.max(20, 'Mã chính sách không được vượt quá 20 ký tự'),
	name: z
		.string({ message: 'Vui lòng nhập tên chính sách' })
		.min(1, 'Vui lòng tên chính sách')
		.max(50, 'Tên chính sách không được vượt quá 50 ký tự'),
	status: z.boolean().default(true),
	rows: cancelPolicyRowSchema,
});

export type CancelPolicyFormValues = z.infer<typeof cancelPolicySchema>;
export type CancelPolicyRowItem = z.infer<typeof cancelPolicyRowItemSchema>;
export type SeparatelyPolicyRow = z.infer<typeof separatelyPolicySchema>;
