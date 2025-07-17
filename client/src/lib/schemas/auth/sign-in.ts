import { z } from 'zod';

export const signInSchema = z.object({
	email: z.string().email({ message: 'Email không đúng định dạng' }),
	password: z
		.string()
		.min(6, { message: 'Mật khẩu phải có ít nhất 6 ký tự' })
		.max(20, { message: 'Mật khẩu có tối đa 20 kí tự' }),
	remember: z.boolean(),
});

export type SignInSchema = z.infer<typeof signInSchema>;
