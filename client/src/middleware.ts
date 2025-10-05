import {
	AuthRouters,
	// DashboardRouter,
	PropertySelectRouters,
	RefreshRouters,
} from '@/constants/routers';
import { addDays } from 'date-fns';
import { ReadonlyRequestCookies } from 'next/dist/server/web/spec-extension/adapters/request-cookies';
import { cookies } from 'next/headers';
import type { NextRequest } from 'next/server';
import { NextResponse } from 'next/server';
import { ILogin } from './services/auth/login';
import { API_URL, AppEndpoint } from './services/type';
import { DEFAULT_COOKIE_OPTIONS } from './utils/cookie';

const handleResetToken = async (
	store: ReadonlyRequestCookies,
	request: NextRequest
): Promise<NextResponse<unknown>> => {
	store.delete('access_token');
	store.delete('hotel_id');
	store.delete('refresh_token');
	return NextResponse.redirect(new URL(AuthRouters.signIn, request.nextUrl));
};
const routeRequireLogin = [
	'/khach-san/dat-phong',
	'/khach-san/don-hang'
]

export async function middleware(request: NextRequest) {
	const requestHeaders = new Headers(request.headers);
	requestHeaders.set('x-url', request.url);
	const access_token = request.cookies.get('access_token')?.value;
	const refresh_token = request.cookies.get('refresh_token')?.value;
	const store = await cookies();
	const hotel_id = store.get('hotel_id');
	const { pathname } = request.nextUrl;
	if (pathname === RefreshRouters.index) {
		const url = new URL(request.url);
		const redirect = url.searchParams.get('redirect');
		if (redirect && refresh_token) {
			try {
				const response = await fetch(
					`${API_URL}${AppEndpoint.REFRESH_TOKEN}`,
					{
						method: 'POST',
						body: JSON.stringify({
							refresh_token,
						}),
						headers: {
							'Content-Type': 'application/json',
						},
					}
				);
				const data: ILogin = await response.json();
				const {
					meta: {
						access_token: newAccessToken,
						refresh_token: newRefreshToken,
					},
				} = data;
				store.set('access_token', newAccessToken, {
					...DEFAULT_COOKIE_OPTIONS,
					expires: addDays(new Date(), 7),
				});
				if (newRefreshToken) {
					store.set('refresh_token', newRefreshToken, {
						...DEFAULT_COOKIE_OPTIONS,
						expires: addDays(new Date(), 7),
					});
				}
				return NextResponse.redirect(
					new URL(redirect, request.nextUrl)
				);
			} catch (error) {
				return handleResetToken(store, request);
			}
		} else {
			return handleResetToken(store, request);
		}
	}

	if (pathname === AuthRouters.signIn) {
		const url = new URL(request.url);
		const force = url.searchParams.get('force');
		if (force) {
			return handleResetToken(store, request);
		}
	}

	// if (pathname === '/') {
	// 	if (access_token) {
	// 		store.delete('hotel_id');
	// 		return NextResponse.redirect(
	// 			new URL(PropertySelectRouters.index, request.nextUrl)
	// 		);
	// 	} else
	// 		return NextResponse.redirect(
	// 			new URL(AuthRouters.signIn, request.nextUrl)
	// 		);
	// }

	if (pathname.startsWith('/dashboard')) {
		if (!access_token) {
			return NextResponse.redirect(
				new URL(AuthRouters.signIn, request.nextUrl)
			);
		}
		if (!hotel_id) {
			return NextResponse.redirect(
				new URL(PropertySelectRouters.index, request.nextUrl)
			);
		}
	}
	if (routeRequireLogin.some(prefix => pathname.startsWith(prefix))) {
		if (!access_token) {
			return NextResponse.redirect(new URL("/login?redirect=" + pathname, request.nextUrl));
		}
	}

	// if (access_token) {
	// 	if (
	// 		Object.values(AuthRouters).some((path) => pathname.startsWith(path))
	// 	) {
	// 		return NextResponse.redirect(
	// 			new URL(
	// 				hotel_id
	// 					? DashboardRouter.profile
	// 					: PropertySelectRouters.index,
	// 				request.nextUrl
	// 			)
	// 		);
	// 	}
	// }

	return NextResponse.next({
		headers: requestHeaders,
	});
}

export const config = {
	matcher: [
		/*
		 * Match all request paths except for the ones starting with:
		 * - api (API routes)
		 * - _next/static (static files)
		 * - _next/image (image optimization files)
		 * - favicon.ico, sitemap.xml, robots.txt (metadata files)
		 */
		'/((?!api|_next/static|_next/image|favicon.ico|sitemap.xml|robots.txt).*)',
	],
};
