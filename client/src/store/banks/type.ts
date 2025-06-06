import { IBank } from '@/services/bank/getBankList';

export interface BankListStore {
	bankList: IBank[];
	fetchBankList: () => Promise<void>;
}
