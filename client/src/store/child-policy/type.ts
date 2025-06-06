import { IPolicyChildren } from '@/services/policy/children/getPolicyChildren';

export interface ChildrenPolicyState {
	data: IPolicyChildren[] | null;
}

export interface ChildrenPolicyActions {
	fetchChildrenPolicy: () => Promise<void>;
	setChildrenPolicy: (data: IPolicyChildren[] | null) => void;
}
