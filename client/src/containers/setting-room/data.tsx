import { OptionType } from '@/components/shared/Select/SelectPopup';
import { TSelectColumn } from '@/containers/booking-orders/data';

export const ageRanges = [
	{ label: '1', value: '1' },
	{ label: '2', value: '2' },
	{ label: '3', value: '3' },
	{ label: '4', value: '4' },
	{ label: '5', value: '5' },
	{ label: '6', value: '6' },
	{ label: '7', value: '7' },
	{ label: '8', value: '8' },
	{ label: '9', value: '9' },
	{ label: '10', value: '10' },
	{ label: '11', value: '11' },
	{ label: '12', value: '12' },
];

export const feeTypes = [
	{ label: 'Miễn phí', value: 'free' },
	{ label: 'Có phí', value: 'paid' },
];

export const filterData: OptionType[] = [
	{
		label: 'Tất cả',
		value: 'all',
	},
	{
		value: 'inactive',
		label: 'Ẩn',
	},
	{
		value: 'active',
		label: 'Hoạt động',
	},
];

export const gridViewData: TSelectColumn[] = [
	{
		title: 'Mã đặt phòng',
		value: 'id',
	},
	{
		title: 'Tên phòng',
		value: 'name',
	},
	{
		title: 'Sức chứa',
		value: 'max_capacity',
	},
	{
		title: 'Kích thước',
		value: 'area',
	},
	{
		title: 'Số lượng',
		value: 'quantity',
	},
	{
		title: 'Trạng thái',
		value: 'status',
	}
];

export const tabDefs = [
	{
		title: 'Thiết lập chung',
		key: 'general',
	},
	{
		title: 'Hình ảnh phòng',
		key: 'image',
	},
	{
		title: 'Tiện ích phòng',
		key: 'amenities',
	},
]