import { OtherPolicyFormValue } from '@/lib/schemas/policy/otherPolicy';
import { IPolicyOtherItem } from '@/services/policy/other/getPolicyOther';

export type DepositMethod = 'cash' | 'credit_card' | 'banking';

export type TPolicyExtraBed = {
	slug: string;
	is_active: boolean;
};
export type TPolicyDeposit = {
	slug: string;
	is_active: boolean;
	settings?: {
		type_deposit: 'fixed' | 'percent'; //fixed|percent
		amount: number;
		method_deposit: DepositMethod[];
	};
};
export type TDocumentRequire = 'cccd' | 'passport' | 'driver_license';
export type TAdultRequire = 'parent' | 'legal_guardian' | 'relative_over_18';
export type TFeeType = 'free' | 'charged';
export type TExtraBreakfast = {
	age_from: number;
	age_to: number | null;
	fee_type: TFeeType;
	fee: number;
};

export type TPolicyMinimumCheckInAge = {
	slug: string;
	settings?: {
		age: number;
		doccument_require: TDocumentRequire[];
		adult_require: TAdultRequire[];
		accompanying_adult_proof: boolean;
	};
};
export type TPolicyServesBreakfast = {
	slug: string;
	is_active: boolean;
	settings?: {
		time_from?: string;
		time_to?: string;
		breakfast_type: number;
		serving_type: number;
		extra_breakfast: TExtraBreakfast[];
	};
};

export interface OtherPolicyState {
	data: OtherPolicyFormValue;
	otherPolicy: IPolicyOtherItem[];
}

export interface OtherPolicyActions {
	setOtherPolicy: (val: IPolicyOtherItem[]) => void;
	fetchOtherPolicy: () => Promise<void>;
	reset: () => void;
}
