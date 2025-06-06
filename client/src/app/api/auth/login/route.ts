import { cookies } from 'next/headers';
import { ILogin, login, LoginBodyType } from '@/services/auth/login';
import { APIValidationError } from '@/utils/errors/apiError';
import { DEFAULT_COOKIE_OPTIONS } from '@/utils/cookie';
import { addDays } from 'date-fns';

export async function POST(request: Request) {
	const body = (await request.json()) as LoginBodyType;
	const cookiesStore = await cookies();

	try {
		const loginResponse = await login(body);
		const { meta, data, message } = loginResponse as ILogin;
		const { access_token, refresh_token } = meta;
		cookiesStore.set('access_token', access_token, {
			...DEFAULT_COOKIE_OPTIONS,
			expires: addDays(new Date(), 7),
		});
		if (refresh_token) {
			cookiesStore.set('refresh_token', refresh_token, {
				...DEFAULT_COOKIE_OPTIONS,
				expires: addDays(new Date(), 7),
			});
		}

		return new Response(
			JSON.stringify({
				message,
				meta,
				data,
			}),
			{
				headers: {
					'Content-Type': 'application/json',
					'Cache-Control': 'no-store',
				},
			}
		);
	} catch (error) {
		if (error instanceof APIValidationError) {
			return Response.json(
				{
					message: error.payload.message,
					errors: error.payload.error.details,
				},
				{
					status: error.status,
				}
			);
		}

		return Response.json(
			{
				message: 'Internal Server Error',
			},
			{
				status: 500,
			}
		);
	}
}
