'use client';
import { useEffect, useState } from 'react';
import { usePathname, useSearchParams } from 'next/navigation';

export type QueryParams = Record<string, string | number | undefined>;
const useQueryPaginationParams = () => {
	const pathname = usePathname();
	const searchParams = useSearchParams();
	const [params, setParams] = useState<QueryParams>({});
	const [isParsedParams, setIsParsedParams] = useState<boolean>(false);

	const setSearchQuery = (params: QueryParams) => {
		const current = new URLSearchParams(Array.from(searchParams.entries()));
		Object.entries(params).forEach(([key, value]) => {
			if (value === undefined || value === '') {
				current.delete(key);
			} else {
				current.set(key, value.toString());
			}
		});
		window.history.replaceState({}, '', `${pathname}?${current.toString()}`);
	};

	useEffect(() => {
		if (isParsedParams) return;
		const page = searchParams.get('page');
		const limit = searchParams.get('limit');
		const search = searchParams.get('search');
		const status = searchParams.get('status');
		const column = searchParams.get('column');
		const direction = searchParams.get('direction');

		const newParams: QueryParams = {
			page: page || undefined,
			limit: limit || 10,
			search: search || undefined,
			status: status === 'all' ? undefined : status || undefined,
			column: column || undefined,
			direction: direction || undefined,
		};

		setParams(newParams);

		setIsParsedParams(true);
	}, [searchParams, isParsedParams]);

	useEffect(() => {
		if (isParsedParams) {
			setSearchQuery({
				limit: params.limit || undefined,
				page: params.page || undefined,
				search: params.search || undefined,
				column: params.column || undefined,
				direction: params.direction || undefined,
				status:
					params.status === 'all' ? undefined : params.status || undefined,
			});
		}
	}, [JSON.stringify(params), isParsedParams]);

	return { setParams, params };
};

export default useQueryPaginationParams;
