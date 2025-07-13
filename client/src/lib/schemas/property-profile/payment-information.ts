import { z } from 'zod';

export enum EPaymentInformationType {
	PERSONAL = 'personal',
	BUSINESS = 'business',
}

export enum EPaymentInformationStatus {
	NEW = 'new',
	PROCESSING = 'processing',
	VERIFIED = 'verified',
	REQUIRES_UPDATE = 'requires_update',
	FAILED = 'failed',
}

export const PaymentInformationSchema = z.object({
	id: z.number().optional(),
	bank_id: z
		.number({ message: 'Vui lòng chọn ngân hàng' })
		.min(1, 'Vui lòng chọn ngân hàng'),
	bank_branch: z.string().optional(),
	name_account: z
		.string({
			message: 'Vui lòng nhập tên tài khoản',
		})
		.min(1, 'Vui lòng nhập tên tài khoản'),
	number: z
		.string({ message: 'Vui lòng nhập số tài khoản' })
		.min(1, 'Vui lòng nhập số tài khoản'),
	type: z.nativeEnum(EPaymentInformationType, {
		message: 'Vui lòng chọn loại tài khoản',
	}),
	status: z.nativeEnum(EPaymentInformationStatus).optional(),
	is_default: z.number().optional(),
	name_company: z
		.string()
		.min(1, { message: 'Vui lòng nhập tên công ty' })
		.optional(),
	contact_person: z
		.string()
		.min(1, { message: 'Vui lòng nhập tên liên hệ' })
		.optional(),
	address: z.string().min(1, { message: 'Vui lòng nhập địa chỉ' }).optional(),
	tax_code: z
		.string()
		.min(1, { message: 'Vui lòng nhập mã số thuế' })
		.optional(),
	email: z
		.string()
		.email({ message: 'Email không đúng định dạng' })
		.optional(),
	phone: z
		.string()
		.min(8, { message: 'Vui lòng nhập số điện thoại hợp lệ' })
		.optional(),
});

export type PaymentInformationForm = z.infer<typeof PaymentInformationSchema>;
