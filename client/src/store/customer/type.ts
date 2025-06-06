import { ICustomerItem } from '@/services/customer/getCustomerList';

export interface CustomerStore {
	customerList: ICustomerItem[];
	fetchCustomerList: (force?: boolean) => Promise<void>;
	reset: () => void;
}
