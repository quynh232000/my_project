import { z as validate } from 'zod';
// Schema for deputy
export const generalInformationSchema = validate.object({
	name: validate
		.string({
			message: 'Vui lòng nhập tên chỗ nghỉ',
		})
		.min(1, 'Vui lòng nhập tên chỗ nghỉ')
		.max(50, 'Tên chỗ nghỉ có tối đa 50 kí tự')
		.trim(),
	avg_price: validate
		.number({
			message: 'Vui lòng nhập giá trung bình',
		})
		.gt(0, 'Vui lòng nhập giá trung bình hợp lệ')
		.lt(999999999, 'Giá trung bình quá lớn'),
	accommodation_id: validate.number({
		message: 'Bạn phải chọn loại chỗ nghỉ',
	}),
	stars: validate.number({
		message: 'Bạn phải chọn hạng sao',
	}),
	chain_id: validate.number().nullable(),
	room_number: validate
		.number({
			message: 'Vui lòng nhập số lượng phòng',
		})
		.int('Vui lòng nhập số lượng phòng hợp lệ')
		.gt(0, 'Vui lòng nhập số lượng phòng hợp lệ')
		.lt(99999, 'Số lượng phòng quá lớn'),
	time_checkin: validate
		.string({
			message: 'Bạn phải chọn giờ nhận phòng',
		})
		.min(1, 'Giờ nhận phòng không được để trống'),
	time_checkout: validate
		.string({
			message: 'Bạn phải chọn giờ trả phòng',
		})
		.min(1, 'Giờ trả phòng không được để trống'),
	image: validate.custom<File | string>(
		(file) => file instanceof File || file?.length > 0,
		'Bạn phải chọn một ảnh hợp lệ'
	),
});

const propertyAddressInformationSchema = validate.object({
	country_id: validate.number({
		message: 'Bạn phải chọn quốc gia',
	}),
	city_id: validate.number({
		message: 'Bạn phải chọn thành phố',
	}),
	district_id: validate.number({
		message: 'Bạn phải chọn quận/huyện',
	}),
	ward_id: validate.number({
		message: 'Bạn phải chọn phường/xã',
	}),
	latitude: validate.number(),
	longitude: validate.number(),
	address: validate
		.string({
			message: 'Vui lòng nhập địa chỉ',
		})
		.min(1, 'Vui lòng nhập địa chỉ')
		.max(100, 'Địa chỉ có tối đa 100 kí tự')
		.trim(),
	fullAddress: validate.string().optional(),
});

const aboutThePropertyInformationSchema = validate.object({
	construction_year: validate
		.number({
			message: 'Vui lòng nhập năm xây dựng',
		})
		.min(1900, 'Vui lòng nhập năm xây dựng hợp lệ')
		.max(2025, 'Vui lòng nhập năm xây dựng hợp lệ'),
	bar_count: validate
		.number({
			message: 'Vui lòng nhập số quán bar',
		})
		.min(0, 'Vui lòng nhập số hợp lệ'),
	floor_count: validate
		.number({
			message: 'Vui lòng nhập số tầng',
		})
		.gt(0, 'Số tầng phải lớn hơn 0')
		.lt(20, 'Số tầng quá lớn'),
	restaurant_count: validate
		.number({
			message: 'Vui lòng nhập số nhà hàng',
		})
		.min(0, 'Vui lòng nhập số hợp lệ'),
	language: validate
		.string({
			required_error: 'Bạn phải chọn ngôn ngữ hỗ trợ',
		})
		.min(1, 'Vui lòng chọn ngôn ngữ hỗ trợ')
		.max(50, 'Ngôn ngữ hỗ trợ có tối đa 50 kí tự'),
	description: validate
		.string({
			required_error: 'Vui lòng nhập nhập một đoạn giới thiệu ngắn',
		})
		.optional(),
});

const faqInformationSchema = validate.object({
	question: validate
		.string({
			required_error: 'Vui lòng nhập câu hỏi',
		})
		.min(1, 'Vui lòng nhập câu hỏi')
		.max(100, 'Câu hỏi có tối đa 100 kí tự'),
	reply: validate
		.string({
			required_error: 'Vui lòng nhập câu trả lời',
		})
		.min(1, 'Vui lòng nhập câu trả lời')
		.max(300, 'Câu trả lời có tối đa 300 kí tự'),
});

const locateOnMapSchema = validate.object({
	latitude: validate
		.number({ message: 'Vui lòng nhập vĩ độ' })
		.min(-90, 'Vĩ độ tối thiểu là -90')
		.max(90, 'Vĩ độ tối đa là 90')
		.optional(),
	longitude: validate
		.number({ message: 'Vui lòng nhập kinh độ' })
		.min(-180, 'Kinh độ tối thiểu là -180')
		.max(180, 'Kinh độ tối đa là 180')
		.optional(),
});

export type TLocateOnMap = validate.infer<typeof locateOnMapSchema>;

export type AboutThePropertyInformation = validate.infer<
	typeof aboutThePropertyInformationSchema
>;

export type PropertyAddressInformation = validate.infer<
	typeof propertyAddressInformationSchema
>;

export type GeneralInformation = validate.infer<
	typeof generalInformationSchema
>;

const AccommodationInfoSchema = validate.object({
	id: validate.number().optional(),
	generalInfo: generalInformationSchema,
	address: propertyAddressInformationSchema,
	introduction: aboutThePropertyInformationSchema,
	faq: validate
		.array(faqInformationSchema)
		.max(5, 'Không được vượt quá 5 câu hỏi'),
});

export type AccommodationInfo = validate.infer<typeof AccommodationInfoSchema>;
export { AccommodationInfoSchema, locateOnMapSchema };
