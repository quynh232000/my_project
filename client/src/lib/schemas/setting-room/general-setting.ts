import { MAX_AGE_VALUE } from '@/containers/setting-room/RoomGeneralSetting/common/RoomExtraBeds';
import { z as validate } from 'zod';

const RoomSetupSchema = validate.object({
	type_id: validate.number({
		message: 'Loại phòng không được để trống',
	}),
	name_id: validate.number({ message: 'Tên phòng không được để trống' }),
	name: validate.string().optional(),
	direction_id: validate.number({
		message: 'Hướng phòng không được để trống',
	}),
	quantity: validate
		.number({
			message: 'Vui lòng nhập số lượng phòng',
		})
		.int('Vui lòng nhập số lượng phòng hợp lệ')
		.gt(0, 'Vui lòng nhập số lượng phòng hợp lệ')
		.lt(99999, 'Số lượng phòng quá lớn'),
	area: validate
		.number({
			message: 'Vui lòng nhập diện tích phòng',
		})
		.int('Vui lòng nhập diện tích phòng hợp lệ')
		.gt(0, 'Vui lòng nhập diện tích phòng hợp lệ')
		.lt(99999, 'Diện tích phòng quá lớn'),
	status: validate.boolean(),
});

const CapacitySchema = validate
	.object({
		allow_extra_guests: validate.enum(['both', 'one']), // Chỉ cho phép 2 lựa chọn
		standard_guests: validate
			.number({
				message: 'Vui lòng nhập số khách tiêu chuẩn',
			})
			.gt(0, 'Vui lòng nhập số khách tiêu chuẩn hợp lệ')
			.lt(100, 'Vui lòng nhập số khách tiêu chuẩn hợp lệ'),
		max_extra_adults: validate
			.number({
				message: 'Vui lòng nhập số người lớn phụ thu tối đa',
			})
			.gt(0, 'Vui lòng nhập số người lớn phụ thu tối đa hợp lệ')
			.lt(100, 'Vui lòng nhập số người lớn phụ thu tối đa hợp lệ'),
		max_extra_children: validate
			.number({
				message: 'Vui lòng nhập số trẻ em phụ thu tối đa',
			})
			.gt(0, 'Vui lòng nhập số trẻ em phụ thu tối đa hợp lệ')
			.lt(100, 'Vui lòng nhập số trẻ em phụ thu tối đa hợp lệ'),
		max_capacity: validate
			.number({
				message: 'Vui lòng nhập sức chứa tối đa',
			})
			.gt(0, 'Sức chứa tối đa phải lớn hơn 0')
			.optional()
			.nullable(),
	})
	.superRefine((data, ctx) => {
		if (data.allow_extra_guests === 'both') {
			const maxAllowed =
				data.standard_guests + data.max_extra_adults + data.max_extra_children;
			if (data.max_capacity === undefined) {
				return ctx.addIssue({
					code: validate.ZodIssueCode.custom,
					message: 'Vui lòng nhập sức chứa tối đa',
					path: ['max_capacity'],
				});
			}
			if ((data?.max_capacity ?? 0) < data.standard_guests) {
				return ctx.addIssue({
					code: validate.ZodIssueCode.custom,
					message: 'Sức chứa tối đa không được nhỏ hơn số khách tiêu chuẩn',
					path: ['max_capacity'],
				});
			}
			if ((data?.max_capacity ?? 0) > maxAllowed) {
				return ctx.addIssue({
					code: validate.ZodIssueCode.custom,
					message: 'Sức chứa tối đa không được vượt quá tổng số khách cho phép',
					path: ['max_capacity'],
				});
			}
		}
		return true;
	});

const BedTypeSchema = validate
	.object({
		bed_type_id: validate.number({
			message: 'Loại giường chính không được để trống',
		}),
		bed_quantity: validate
			.number({
				message: 'Vui lòng nhập số lượng giường',
			})
			.gt(0, 'Vui lòng nhập số lượng giường chính hợp lệ')
			.lt(99999, 'Số lượng giường chính quá lớn'),
		hasAlternativeBed: validate.boolean(),
		sub_bed_type_id: validate
			.number({ message: 'Loại giường thay thế không được để trống' })
			.optional()
			.nullable(),
		sub_bed_quantity: validate
			.number({
				message: 'Vui lòng nhập số lượng giường thay thế',
			})
			.gt(0, 'Vui lòng nhập số lượng giường thay thế hợp lệ')
			.lt(99999, 'Số lượng giường thay thế quá lớn')
			.optional()
			.nullable(),
	})
	.superRefine((data, ctx) => {
		if (data.hasAlternativeBed && !data.sub_bed_type_id) {
			ctx.addIssue({
				code: 'custom',
				message: 'Bạn cần phải chọn loại giường thay thế khi bật tùy chọn',
				path: ['sub_bed_type_id'],
			});
		}
		if (data.hasAlternativeBed && !data.sub_bed_quantity) {
			ctx.addIssue({
				code: 'custom',
				message: 'Cần nhập số lượng giường thay thế khi bật tùy chọn',
				path: ['sub_bed_quantity'],
			});
		}
		if (data.hasAlternativeBed && data.bed_type_id === data.sub_bed_type_id) {
			ctx.addIssue({
				code: 'custom',
				message: 'Loại giường thay thế không được trùng với giường chính',
				path: ['sub_bed_type_id'],
			});
		}
	});

const PricingSchema = validate
	.object({
		price_min: validate
			.number({
				message: 'Vui lòng nhập giá tối thiểu',
			})
			.gt(0, 'Vui lòng nhập Giá tối thiểu hợp lệ')
			.lt(999999999, 'Giá tối thiểu quá lớn'),
		price_standard: validate
			.number({
				message: 'Vui lòng nhập giá cơ bản',
			})
			.gt(0, 'Vui lòng nhập giá cơ bản/phòng/đêm hợp lệ')
			.lt(999999999, 'Giá cơ bản/phòng/đêm quá lớn'),
		price_max: validate
			.number({
				message: 'Vui lòng nhập giá tối đa',
			})
			.gt(0, 'Vui lòng nhập Giá tối đa hợp lệ')
			.lt(999999999, 'Giá tối đa quá lớn'),
	})
	.superRefine((val, ctx) => {
		if (val.price_min > val.price_max) {
			ctx.addIssue({
				code: validate.ZodIssueCode.custom,
				message: 'Giá tối thiểu không được lớn hơn giá tối đa',
				path: ['price_min'],
			});
			ctx.addIssue({
				code: validate.ZodIssueCode.custom,
				message: 'Giá tối đa không được nhỏ hơn giá tối thiểu',
				path: ['price_max'],
			});
		}
		if (
			val.price_min > val.price_standard ||
			val.price_max < val.price_standard
		) {
			ctx.addIssue({
				code: validate.ZodIssueCode.custom,
				message:
					'Giá cơ bản không được nhỏ hơn giá tối thiểu và lớn hơn giá tối đa',
				path: ['price_standard'],
			});
		}
		return true;
	});

const FeeSchema = validate
	.object({
		age_from: validate.number(),
		age_to: validate.number().gt(0, 'Bạn phải chọn tuổi').nullable(),
		type: validate.string().min(1, 'Loại phí không được để trống'),
		price: validate.number().nullable(),
	})
	.superRefine((val, ctx) => {
		if (val.type !== 'free') {
			if (val.price === null || isNaN(val.price)) {
				ctx.addIssue({
					code: validate.ZodIssueCode.custom,
					message: 'Phí không được để trống',
					path: ['price'],
				});
			} else if (val.price < 1) {
				ctx.addIssue({
					code: validate.ZodIssueCode.custom,
					message: 'Vui lòng nhập mức phí hợp lệ',
					path: ['price'],
				});
			} else if (val.price >= 1000000000) {
				ctx.addIssue({
					code: validate.ZodIssueCode.custom,
					message: 'Mức phí quá lớn',
					path: ['price'],
				});
			}
		}

		if (val.type === 'free' && val.price && val.price > 0) {
			ctx.addIssue({
				code: validate.ZodIssueCode.custom,
				message: 'Phí phải là 0 khi chọn miễn phí',
				path: ['price'],
			});
		}
	});

export type FeeExtraBedType = validate.infer<typeof FeeSchema>;

const ExtraOptionsSchema = validate.object({
	breakfast: validate.boolean(),
	smoking: validate.boolean(),
	hasExtraBed: validate.boolean(),
	extra_beds: validate
		.array(FeeSchema)
		.superRefine((data, ctx) => {
			for (let i = 1; i < data.length; i++) {
				if (
					data[i].age_to !== null &&
					typeof data[i].age_to === 'number' &&
					+(data[i].age_to as number) <= +(data[i - 1].age_to as number)
				)
					return ctx.addIssue({
						code: validate.ZodIssueCode.custom,
						message: 'Vui lòng khung độ tuổi tăng dần',
						path: [`${i}.age_to`],
					});
			}
		})
		.superRefine((data, ctx) => {
			if (
				data?.length > 0 &&
				data[data.length - 1].age_to !== null &&
				typeof data[data.length - 1].age_to === 'number' &&
				data[data.length - 1].age_to !== Number(MAX_AGE_VALUE)
			) {
				return ctx.addIssue({
					code: validate.ZodIssueCode.custom,
					message:
						'Vui lòng cài đặt giá bổ sung để bao gồm toàn bộ khung tuổi đi kèm',
					path: [`${data.length - 1}.age_to`],
				});
			}
		})
		.superRefine((data, ctx) => {
			if (data?.length > 0 && data[data.length - 1].age_to === null) {
				return ctx.addIssue({
					code: validate.ZodIssueCode.custom,
					message: 'Bạn phải chọn tuổi',
					path: [`${data.length - 1}.age_to`],
				});
			}
		}),
});

const RoomConfigurationSchema = validate.object({
	setup: RoomSetupSchema,
	capacity: CapacitySchema,
	bedInfo: BedTypeSchema,
	pricing: PricingSchema,
	extras: ExtraOptionsSchema,
});

export const initialRoomConfiguration: RoomConfiguration = {
	setup: {
		type_id: NaN,
		name_id: NaN,
		name: '',
		direction_id: NaN,
		quantity: NaN,
		status: false,
		area: NaN,
	},
	capacity: {
		allow_extra_guests: 'both',
		standard_guests: NaN,
		max_extra_adults: NaN,
		max_extra_children: NaN,
		max_capacity: NaN,
	},
	bedInfo: {
		bed_type_id: NaN,
		bed_quantity: NaN,
		hasAlternativeBed: false,
	},
	pricing: {
		price_min: NaN,
		price_standard: NaN,
		price_max: NaN,
	},
	extras: {
		breakfast: false,
		smoking: false,
		hasExtraBed: false,
		extra_beds: [],
	},
};

export type RoomConfiguration = validate.infer<typeof RoomConfigurationSchema>;
export {
	RoomSetupSchema,
	CapacitySchema,
	BedTypeSchema,
	PricingSchema,
	FeeSchema,
	ExtraOptionsSchema,
	RoomConfigurationSchema,
};
