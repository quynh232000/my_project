import { ICancelPolicy } from '@/services/policy/cancel/getCancelPolicy';

export interface CancelPolicyState {
	global: ICancelPolicy | undefined | null;
	local: ICancelPolicy[] | undefined | null;
	forceFetch: boolean;
}

export interface CancelPolicyActions {
	fetchCancelPolicy: (force?: boolean) => Promise<void>;
	setGlobalPolicy: (data: ICancelPolicy | null) => void;
	addLocalPolicy: (data: ICancelPolicy) => void;
	updateLocalPolicy: (data: ICancelPolicy) => void;
	deleteLocalPolicy: (id: number) => void;
	setForceFetch: (val: boolean) => void;
	reset: () => void;
}
