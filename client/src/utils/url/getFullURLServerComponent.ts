import { headers } from 'next/headers';

export const getFullURLServerComponent = async () => {
	const headersList = await headers();
	const domain = headersList.get('host') || '';
	const fullUrl = headersList.get('X-Url') || '';
	const pathName = new URL(fullUrl).pathname;

	return {
		domain,
		fullUrl,
		pathName: pathName,
	};
};
