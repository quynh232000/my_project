export interface RoomAmenitiesType {
	[key: string]: string[]
}

export interface FormValuesWithTitle {
	[key: string]: {
		title: string;
		arr: string[];
	};
}

export interface AmenityTypeItem {
	name: string;
	id: number;
}

export interface AmenityType {
	id: number;
	title: string;
	children: AmenityTypeItem[];
}
