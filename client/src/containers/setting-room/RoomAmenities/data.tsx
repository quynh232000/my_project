export interface RoomAmenitiesType {
	[key: string]: string[]
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
