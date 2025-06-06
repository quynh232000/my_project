export interface UserInformation {
	id: number;
	register_id: number;
	username: string;
	full_name: string;
	email: string;
	phone: string;
	image: string;
	ip: string;
	status: string;
	created_at: string;
	created_by: number;
	updated_at: string;
	updated_by: number;
}

export interface UserInformationState {
	userInformation: UserInformation;
}

export interface UserInformationActions {
	setUserInformationState: (info: UserInformation) => void;
}
