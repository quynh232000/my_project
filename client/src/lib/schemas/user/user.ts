import { z } from 'zod';

export const userSchema = z
	.object({
		full_name: z.string().min(1, 'Tên người dùng không được để trống'),
		email: z
			.string()
			.min(1, 'Email không được để trống')
			.email({ message: 'Email không đúng định dạng' }),
		password: z
			.string()
			.max(20, { message: 'Mật khẩu có tối đa 20 kí tự' }),
		password_confirmation: z
			.string()
			.max(20, { message: 'Mật khẩu có tối đa 20 kí tự' }),
		role: z.string({
			message: 'Vai trò không được để trống',
		}),
		status: z.string(),
	})
	.superRefine((data, ctx) => {
		if (data.password.length > 0 && data.password.length < 6) {
			ctx.addIssue({
				code: z.ZodIssueCode.custom,
				message: 'Mật khẩu phải có ít nhất 6 ký tự',
				path: ['password'],
			});
		}
		if (data.password !== data.password_confirmation) {
			ctx.addIssue({
				code: z.ZodIssueCode.custom,
				message: 'Mật khẩu không trùng khớp',
				path: ['password_confirmation'],
			});
		}
	});

export type UserInformationType = z.infer<typeof userSchema>;
