import { OptionType } from '@/components/shared/Select/SelectPopup';

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
