import { TPriceType } from '@/lib/schemas/type-price/standard-price';

export interface PricesState {
	data: TPriceType[] | null;
}

export interface PricesStateActions {
	fetchPrices: () => Promise<void>;
	addUpdatePrice: (data: TPriceType) => void;
	deletePrice: (id: number) => void;
	reset: () => void;
}
