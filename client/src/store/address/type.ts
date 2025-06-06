import { IAddressItem } from '@/services/address/getAddress';

export interface AddressState {
	listCountry: IAddressItem[];
	listProvince: {
		upperId: number;
		list: IAddressItem[];
	};
	listDistrict: {
		upperId: number;
		list: IAddressItem[];
	};
	listWard: {
		upperId: number;
		list: IAddressItem[];
	};
}

export interface AddressActions{
	getAddress: (type: keyof AddressState, upperId?: number) => Promise<void>;
}
