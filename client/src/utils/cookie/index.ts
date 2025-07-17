import Cookies from 'js-cookie';

interface CookieOptions {
	expires?: number | Date;
	path?: string;
	domain?: string;
	secure?: boolean;
	sameSite?: 'strict' | 'lax' | 'none';
	httpOnly?: boolean;
}

export const DEFAULT_COOKIE_OPTIONS: CookieOptions = {
	path: '/',
	httpOnly: false,
	sameSite: 'strict',
	secure: true,
};

export const getClientSideCookie = (name: string): string | undefined => {
	try {
		return Cookies.get(name);
	} catch (error) {
		console.error(`Error getting cookie ${name}:`, error);
		return undefined;
	}
};

export const setClientSideCookie = ({
	name,
	value,
	options,
}: {
	name: string;
	value: string;
	options: CookieOptions;
}): string | undefined => {
	try {
		return Cookies.set(name, value, {
			...DEFAULT_COOKIE_OPTIONS,
			...options,
		});
	} catch (error) {
		console.error(`Error setting cookie ${name}:`, error);
		return undefined;
	}
};

export const removeClientSideCookie = (
	name: string,
	options: CookieOptions = {}
): void => {
	try {
		Cookies.remove(name, { ...DEFAULT_COOKIE_OPTIONS, ...options });
	} catch (error) {
		console.error(`Error removing cookie ${name}:`, error);
	}
};

export const clearAllCookies = (): void => {
	try {
		Object.keys(Cookies.get()).forEach((cookieName) => {
			removeClientSideCookie(cookieName);
		});
	} catch (error) {
		console.error('Error clearing cookies:', error);
	}
};
