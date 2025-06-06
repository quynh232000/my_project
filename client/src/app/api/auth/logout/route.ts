import { logout } from '@/services/auth/logout';
import { NextResponse } from 'next/server';

interface LogoutResponse {
	success: boolean;
	message: string;
}

export async function POST(): Promise<NextResponse<LogoutResponse>> {
	try {
		await logout();

		const response = NextResponse.json({
			success: true,
			message: 'Successfully logged out'
		});

		response.cookies.delete('access_token');
		response.cookies.delete('hotel_id');
		response.cookies.delete('refresh_token');

		return response;
	} catch (error) {
		console.error('Logout error:', error);

		return NextResponse.json(
			{
				success: false,
				message: 'Failed to logout'
			},
			{ status: 500 }
		);
	}
}