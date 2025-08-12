import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';


export interface ILogin {
	status: boolean;
	message: string;
	error: {
		details: any
	}
	meta: {
		access_token: string;
		token_type: string;
		expires_in: number;
		refresh_token?: string;
	};
	data: {
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
	};
}

export interface RegisterBodyType {
	email: string;
	full_name: string;
	password: string;
}

export const SRegister = async ({
	email,
	password,
	full_name
}: RegisterBodyType): Promise<ILogin> => {
	try {
		const res = await CallAPI().post(`${AppEndpoint.AUTH_REGISTER}`, {
			email,
			password,
			remember: true,
			full_name
		});
		return res.data;
	} catch (err: any) {
		return err.response.data as ILogin
	}
};
