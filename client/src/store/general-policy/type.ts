import { IGeneralPolicy } from '@/services/policy/general/getGeneralPolicy';

export interface GeneralPolicyState {
	data: IGeneralPolicy[] | null;
}

export interface GeneralPolicyActions {
	fetchGeneralPolicy: () => Promise<void>;
	setGeneralPolicy: (data: IGeneralPolicy[] | null) => void;
}
