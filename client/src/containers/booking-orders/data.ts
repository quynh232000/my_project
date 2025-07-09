import { ECancelFeeType } from '@/lib/schemas/policy/cancelPolicy';

export type TBookingOrder = {
	id: string | number;
	time_order: string;
	name: string;
	date: {
		from: Date;
		to: Date;
	};
	room_guests: string;
	total_price: string;
	status: string;
	email: string;
	phone: string;
	max_extra_adults: number;
	max_extra_children: number
};

export const bookingOrderList: TBookingOrder[] = [
	{
		id: '1606575106',
		email: 'test@gmail.com',
		phone: '0978564813',
		time_order: '24/12/2025, 13:59',
		name: 'Anh Duc Nguyen',
		date: {
			from: new Date("4/30/2025"),
			to: new Date("5/3/2025")
		},
		room_guests: "Phòng Tiêu Chuẩn (1018442099)",
		total_price: '600.000',
		max_extra_adults: 3,
		max_extra_children: 4,
		status: 'inactive',
	},
	{
		id: '1606575105',
		email: 'test@gmail.com',
		phone: '0978564813',
		time_order: '24/12/2025, 13:59',
		name: 'Nguyen Quynh',
		date: {
			from: new Date("4/30/2025"),
			to: new Date("5/3/2025")
		},
		room_guests: "Phòng Tiêu Chuẩn (1018442099)",
		total_price: '600.000',
		max_extra_adults: 3,
		max_extra_children: 4,
		status: 'active',
	},
	{
		id: '1606575107',
		email: 'test@gmail.com',
		phone: '0978564813',
		time_order: '24/12/2025, 13:59',
		name: 'Minh Trung',
		date: {
			from: new Date("4/30/2025"),
			to: new Date("5/3/2025")
		},
		room_guests: "Phòng Tiêu Chuẩn (1018442099)",
		total_price: '600.000',
		max_extra_adults: 3,
		max_extra_children: 4,
		status: 'pending',
	},
];

export type TSelectCheckbox = {
	title: string;
	value: string;
	checked: boolean
};
export type TSelectColumn= {
	title: string;
	value: string;
};
export const gridViewData: TSelectCheckbox[] = [
	{
		title: 'Mã đặt phòng',
		value: 'id',
		checked: false
	},
	{
		title: 'Tên khách',
		value: 'name_customer',
		checked: false
	},
	{
		title: 'Ngày ở',
		value: 'date',
		checked: false
	},
	{
		title: 'Phòng và số người ở',
		value: 'room_guests',
		checked: false
	},
	{
		title: 'Tổng giá bán',
		value: 'total_price',
		checked: false
	},
	{
		title: 'Thời gian đặt',
		value: 'time_booking',
		checked: false
	},
	{
		title: 'OTA thu hộ',
		value: 'ota',
		checked: false
	},
	{
		title: 'Ghi chú',
		value: 'note',
		checked: false
	},
];

export const orderStatus: TSelectCheckbox[] = [
	{
		title: 'Tất cả',
		value: 'all',
		checked: false
	},
	{
		title: 'Chờ xác nhận',
		value: 'pending',
		checked: false
	},
	{
		title: 'Đã xác nhận',
		value: 'active',
		checked: false
	},
	{
		title: 'Đã hủy bỏ',
		value: 'inactive',
		checked: false
	},
];

export const orderTypeRoom: TSelectCheckbox[] = [
	{
		title: 'Tất cả',
		value: 'all',
		checked: false
	},
	{
		title: 'Chờ xác nhận',
		value: 'pending',
		checked: false
	},
	{
		title: 'Đã xác nhận',
		value: 'active',
		checked: false
	},
	{
		title: 'Đã hủy bỏ',
		value: 'inactive',
		checked: false
	},
];

export const orderTypePrice: TSelectCheckbox[] = [
	{
		title: 'Tất cả',
		value: 'all',
		checked: false
		
	},
	{
		title: 'Giá tiêu chuẩn',
		value: 'pending',
		checked: false
		
	},
	{
		title: 'Giá linh động',
		value: 'active',
		checked: false
		
	},
	{
		title: 'Giá hè 2025',
		value: 'inactive',
		checked: false
		
	},
];

export const timeSelectData = [
	{
		title: 'Theo ngày và theo tuần',
		children: [
			{
				title: 'Hôm nay',
				value: 'today',
			},
			{
				title: 'Hôm qua',
				value: 'yesterday',
			},
			{
				title: 'Tuần này',
				value: 'this_week',
			},
			{
				title: 'Tuần trước',
				value: 'last_week',
			},
			{
				title: '7 ngày qua',
				value: 'last_7_days',
			},
		],
	},
	{
		title: 'Theo tháng và theo quý',
		children: [
			{
				title: 'Tháng này',
				value: 'this_month',
			},
			{
				title: 'Tháng trước',
				value: 'last_month',
			},
			{
				title: '30 ngày qua',
				value: 'last_30_days',
			},
			{
				title: 'Quý này',
				value: 'this_quarter',
			},
			{
				title: 'Quý trước',
				value: 'last_quarter',
			},
		],
	},
	{
		title: 'Theo năm',
		children: [
			{
				title: 'Năm nay',
				value: 'this_year',
			},
			{
				title: 'Năm trước',
				value: 'last_year',
			},
			{
				title: 'Toàn thời gian',
				value: 'all_time',
			},
		],
	},
];

export const payoutDetails = [
	{
		title: 'Thông tin xuất chi',
		children: [
			{ title: 'Tổng tiền đặt chỗ', value: '2.700.000đ' },
			{ title: 'Trạng thái thanh toán của khách', value: 'Đã thanh toán' },
			{ title: 'Ngày thanh toán', value: '26/05/2025' },
			{ title: 'Đơn vị xử lý thanh toán', value: '190Booking' },
			{ title: 'Mã giao dịch', value: 'TXN-23095-HSDQ' },
		],
	},
	{
		title: 'Chi tiết xuất chi cho khách sạn',
		children: [
			{ title: 'Tổng tiền đặt chỗ', value: '2.700.000đ' },
			{ title: 'Phí nền tảng', value: '15% - 405.000đ' },
			{
				title: 'Thuế GTGT hoa hồng (nếu có)',
				value: '40.500đ (10% VAT trên phí nền tảng)',
			},
			{ title: 'Số tiền khách sạn nhận', value: '2.254.500đ' },
			{ title: 'Ngày dự kiến chuyển khoản', value: '01/06/2025' },
		],
	},
];

interface IOccupancyInfo {
	roomType: { count: number; nameRoom: string }[];
	benefits: string[];
	numberOfNights: number;
	adults: number;
	children: number;
	extraBed: number;
	specialRequest: string;
	promotion: string;
	rateType: string;
	cancellationPolicy: string;
}

export const roomOccupancyInfo: IOccupancyInfo = {
	roomType: [
		{
			count: 1,
			nameRoom: 'Biệt Thự 2 Phòng Ngủ Có Hồ Bơi Nhìn Ra Sông',
		},
	],
	benefits: [
		'Breakfast for 1 person',
		'Kaiseki dinner',
		'Complimentary Breakfast',
		'Japanese dinner',
		'Breakfast for 2 people',
		'Cruise dinner',
		'Buffet dinner',
		'Free WiFi',
	],
	numberOfNights: 4,
	adults: 2,
	children: 0,
	extraBed: 0,
	specialRequest:
		'Hi Imola, Thank you for your message. I’ve reached out to Agoda support regarding your refund, and they’ve confirmed that the amount you paid will be refunded within the next few days.',
	promotion: 'Early Year Deal',
	rateType: 'Giá tiêu chuẩn',
	cancellationPolicy: 'Chính sách hủy',
};

export const cancelPolicy = [
	{
		"id": 682,
		"policy_cancel_id": 66,
		"day": 0,
		"fee_type": ECancelFeeType.FEE,
		"fee": 100
	},
	{
		"id": 683,
		"policy_cancel_id": 66,
		"day": 12,
		"fee_type": ECancelFeeType.FREE,
		"fee": 0
	},
	{
		"id": 684,
		"policy_cancel_id": 66,
		"day": 10,
		"fee_type": ECancelFeeType.FEE,
		"fee": 20
	},
	{
		"id": 685,
		"policy_cancel_id": 66,
		"day": 5,
		"fee_type": ECancelFeeType.FEE,
		"fee": 75
	},
	{
		"id": 686,
		"policy_cancel_id": 66,
		"day": 1,
		"fee_type": ECancelFeeType.FEE,
		"fee": 99
	}
]