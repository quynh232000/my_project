export type TBookingOrder = {
	id: string | number;
	name: string;
	date: string;
	room_guests: {
		room_name: string;
		people_count: number;
		date_count: number;
	};
	status: string;
}

export const bookingOrderList: TBookingOrder [] = [
	{
		id: "1606575106",
		name: "Anh Duc Nguyen",
		date: "30/4/2025 -3/5/2025",
		room_guests:  {
			room_name: "Phòng Tiêu Chuẩn (1018442099)",
			people_count: 2,
			date_count: 3
		},
		status: "inactive"
	},
	{
		id: "1606575105",
		name: "Anh Duc Nguyen",
		date: "30/4/2025 -3/5/2025",
		room_guests:  {
			room_name: "Phòng Tiêu Chuẩn (1018442099)",
			people_count: 2,
			date_count: 3
		},
		status: "active"
	},
	{
		id: "1606575105",
		name: "Anh Duc Nguyen",
		date: "30/4/2025 -3/5/2025",
		room_guests:  {
			room_name: "Phòng Tiêu Chuẩn (1018442099)",
			people_count:2,
			date_count: 3
		},
		status: "pending"
	},
]
