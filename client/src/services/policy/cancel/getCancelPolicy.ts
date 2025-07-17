import { CallAPI } from '@/configs/axios/axios';
import { AppEndpoint } from '@/services/type';
import { ECancelFeeType } from '@/lib/schemas/policy/cancelPolicy';
import { getClientSideCookie } from '@/utils/cookie';

export enum CancelPolicyStatus {
	ACTIVE = 'active',
	INACTIVE = 'inactive',
}

export interface ICancelRule {
	day: number;
	fee_type: ECancelFeeType;
	fee: number;
}

export interface IPriceTypes {
	name: string;
	policy_cancel_id: number;
}

export interface ICancelPolicy {
	id: number;
	code: string;
	name: string;
	status: CancelPolicyStatus;
	is_global: boolean;
	cancel_rules: ICancelRule[];
	price_types?: IPriceTypes[];
}

export const getCancelPolicy = async (): Promise<{
	global: ICancelPolicy | undefined;
	local: ICancelPolicy[] | undefined;
} | null> => {
	try {
		const hotel_id = getClientSideCookie('hotel_id');
		const { data } = await CallAPI().get(`${AppEndpoint.CANCEL_POLICY}`, {
			params: {
				hotel_id,
			},
		});
		if (!data) {
			return null;
		}
		return {
			global: data?.data?.global,
			local: data?.data?.local,
		};
	} catch (error) {
		console.error('getCancelPolicy', error);
		return null;
	}
};
