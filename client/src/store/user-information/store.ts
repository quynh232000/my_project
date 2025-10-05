import { create } from 'zustand/react';
import {
	UserInformationActions,
	UserInformationState,
} from '@/store/user-information/type';

const initialState: UserInformationState = {
	userInformation: {
		id: 0,
		register_id: 0,
		username: '',
		full_name: '',
		email: '',
		phone: '',
		image: '',
		ip: '',
		status: '',
		created_at: '',
		created_by: 0,
		updated_at: '',
		updated_by: 0,
	},
	showLogin: ''
};

export const useUserInformationStore = create<
	UserInformationState & UserInformationActions
>((set) => ({
	...initialState,
	setUserInformationState: (info) =>
		set(() => ({
			userInformation: info,
		})),
	setShowLoginState: (is_show) =>
		set(() => ({
			showLogin: is_show,
		})),
}));
