import {
	IconBed,
	IconBuilding,
	IconCalendarAll,
	IconFile,
	IconLink,
	IconNewsWrapper,
	IconStarV2,
	IconTicket,
	IconUser,
	IconWallet,
} from '@/assets/Icons/outline';
import IconImage from '@/assets/Icons/outline/IconImage';

export const GlobalConfig = {};

export const SidebarConfig = {
	menu: [
		{
			label: 'Dashboard',
			url: 'dashboard',
			items: [
				{
					title: 'Hồ sơ chỗ nghỉ',
					url: 'profile',
					icon: IconBuilding,
					shouldMatchPrefix: true,
				},
				{
					title: 'Đơn đặt phòng',
					url: 'booking-orders',
					icon: IconFile,
					shouldMatchPrefix: true,
				},
				{
					title: 'Quản lý phòng',
					url: 'room',
					icon: IconBed,
					shouldMatchPrefix: true,
				},
				{
					title: 'Thư viện ảnh',
					url: 'album',
					icon: IconImage,
					shouldMatchPrefix: true,
				},
				{
					title: 'Chính sách',
					url: 'policy',
					icon: IconNewsWrapper,
					shouldMatchPrefix: false,
					menu: [
						{
							title: 'Chính sách chung',
							url: 'policy/general',
						},
						{
							title: 'Chính sách cho trẻ em',
							url: 'policy/children',
						},
						{
							title: 'Chính sách hoàn hủy',
							url: 'policy/cancel',
						},
						{
							title: 'Chính sách khác',
							url: 'policy/other',
						},
					],
				},
				{
					title: 'Quản lý giá',
					url: 'price',
					icon: IconWallet,
					shouldMatchPrefix: false,
					menu: [
						{
							title: 'Loại giá',
							url: 'price/type',
						},
						{
							title: 'Giá và phòng trống',
							url: 'price/availability',
						},
						/* {
							title: 'Lịch sử giá',
							url: 'price/history',
						}, */
					],
				},
				{
					title: 'Khuyến mãi',
					url: 'promotion',
					icon: IconTicket,
					shouldMatchPrefix: true,
				},
				{
					title: 'Quản lý người dùng',
					url: 'user',
					icon: IconUser,
					shouldMatchPrefix: true,
					menu: [
						{
							title: 'Danh sách người dùng',
							url: 'user',
						},
						{
							title: 'Nhóm người dùng',
							url: 'user/user-group',
						}
					],
				},
				{
					title: 'Đánh giá khách hàng',
					url: 'review',
					icon: IconStarV2,
					shouldMatchPrefix: true,
				},
				{
					title: 'Kết nối CMS',
					url: 'cms',
					icon: IconLink,
					shouldMatchPrefix: true,
				},
				{
					title: 'Cài đặt',
					url: 'settings',
					icon: IconCalendarAll,
					shouldMatchPrefix: true,
				},
			],
		},
	],
};
