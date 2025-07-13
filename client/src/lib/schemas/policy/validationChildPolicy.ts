import { z } from 'zod';

export enum ROBB {
	RO = 'ro',
	BB = 'bb',
}

const policyRowSchema = z.object({
	age_from: z.number(),
	age_to: z
		.number({ message: 'Vui lòng chọn độ tuổi' })
		.min(1, 'Vui lòng chọn độ tuổi'),
	fee_type: z.enum(['free', 'charged', 'limit']),
	quantity_child: z
		.union([
			z.nan(),
			z.number({ message: 'Vui lòng nhập số trẻ em miễn phí' }),
		])
		.optional(),
	fee: z
		.union([
			z.nan(),
			z
				.number({ message: 'Vui lòng nhập phí' })
				.max(1000000000, 'Vui lòng nhập phí hợp lệ'),
		])
		.optional(),
	meal_type: z.nativeEnum(ROBB),
});

export const policySchema = z
	.object({
		ageLimit: z.number().min(1, 'Vui lòng chọn độ tuổi tối đa cho trẻ em'),
		rows: z.array(policyRowSchema).superRefine((rows, ctx) => {
			rows.every((row, index) => {
				switch (row.fee_type) {
					case 'charged': {
						if (!row.fee || row.fee <= 0) {
							return ctx.addIssue({
								code: z.ZodIssueCode.custom,
								message: 'Vui lòng nhập phụ phí trẻ em',
								path: [`${index}.fee`],
							});
						}
						return true;
					}
					case 'limit': {
						if (!row.quantity_child || row.quantity_child <= 0) {
							return ctx.addIssue({
								code: z.ZodIssueCode.custom,
								message: 'Vui lòng nhập số trẻ em miễn phí',
								path: [`${index}.quantity_child`],
							});
						}
						if (!row.fee || row.fee <= 0) {
							return ctx.addIssue({
								code: z.ZodIssueCode.custom,
								message: 'Vui lòng nhập phụ phí trẻ em',
								path: [`${index}.fee`],
							});
						}
						return true;
					}
					default:
						return true;
				}
			});
		}),
	})
	.superRefine((val, ctx) => {
		if (val.rows[val.rows.length - 1].age_to < val.ageLimit) {
			return ctx.addIssue({
				code: z.ZodIssueCode.custom,
				message:
					'Vui lòng cài đặt giá bổ sung để bao gồm toàn bộ khung tuổi trẻ em đi kèm',
				path: [`rows.${val.rows.length - 1}.age_to`],
			});
		}
	});

export type PolicyFormValues = z.infer<typeof policySchema>;
export type PolicyRowValues = z.infer<typeof policyRowSchema>;
