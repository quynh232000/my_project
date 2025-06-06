import { OptionType } from '@/components/shared/Select/SelectPopup';
import { ECustomerStatus } from '@/services/customer/getCustomerList';
import { UserInformationType } from '@/lib/schemas/user/user';

export type TUser = {
	id: string | number;
	full_name: string;
	role: string;
	email: string;
	add_by: string;
	status: string;
}

export type TGroupUser = {
	id: string | number;
	name: string;
	email: string;
	add_by: string;
	status: string;
}

export const roleList: OptionType[] = [
	{
		label:"staff",
		value: 1
	},
	{
		label: "manager",
		value: 2
	}
]

export const userGroupList: TGroupUser [] = [
	{
		id: "1",
		name: "Admin",
		email: "jos-pham@gmail.com",
		add_by: "Nội bộ 190 Booking",
		status: "inactive"
	},
	{
		id: "2",
		name: "Lễ Tân",
		email: "khoale@gmail.com",
		add_by: "Nội bộ 190 Booking",
		status: "active"
	},
]

export const permissionList = [
	{
		id: "1",
		name: "Dashboard",
		children: [
			{
				id: "2",
				name: "Xem Dashboard",
			}
		]
	},
	{
		id: "3",
		name: "Hồ sơ chỗ nghỉ",
		children: [
			{
				id: "4",
				name: "Xem hồ sơ chỗ nghỉ"
			},
			{
				id: "5",
				name: "Cập nhật hồ sơ chỗ nghỉ"
			}
		]
	}
]

export const userFormDefaultValues: UserInformationType = {
	role: "",
	password_confirmation: '',
	email: '',
	status: ECustomerStatus.inactive,
	full_name: '',
	password: '',
}