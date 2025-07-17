import { IResponseStatus } from '@/services/type';

export interface IStatusType {
	status: boolean;
	message: string;
	data?:
		| number
		| {
				id: number;
		  };
	error?: {
		code: number;
		details: {
			[key: string]: string[];
		};
	};
}

export const parseErrorStatus = (statusData: IStatusType): IResponseStatus => {
	const errorData = Object.values(statusData?.error?.details ?? {})?.[0];
	return {
		status: statusData?.status ?? false,
		id: statusData?.data
			? typeof statusData?.data === 'number'
				? statusData?.data
				: statusData?.data?.id
			: undefined,
		message: statusData?.status
			? statusData.message
			: statusData && statusData?.error?.details
				? Array.isArray(errorData) && errorData?.[0]
					? errorData?.[0]
					: statusData?.message
				: 'Có lỗi xảy ra, vui lòng thử lại!',
	};
};
