import { useCallback, useEffect, useState } from 'react';
import { usePathname, useSearchParams } from 'next/navigation';

interface ITabItem {
	key: string;
	title: string;
}

const useTabStateWithQueryParam = (tabs: ITabItem[]) => {
	const pathname = usePathname();
	const searchParams = useSearchParams();
	const [selectedIndex, setSelectedIndex] = useState<number | null>(null);
	const [isParsedParams, setIsParsedParams] = useState<boolean>(false);
	const updateUrlWithTab = useCallback(
		(newTabKey: string) => {
			const current = new URLSearchParams(
				Array.from(searchParams.entries())
			);
			current.set('tab', newTabKey);
			window.history.replaceState(
				{},
				'',
				`${pathname}?${current.toString()}`
			);
		},
		[searchParams, pathname]
	);

	const updateTab = (index: number) => {
		setSelectedIndex(index);
	};

	useEffect(() => {
		if (!isParsedParams) {
			const tabKey = searchParams.get('tab');
			const foundIndex = tabs.findIndex((tab) => tab.key === tabKey);
			if (foundIndex !== -1) {
				updateTab(foundIndex);
			} else {
				updateTab(0);
			}
			setIsParsedParams(true);
		}
	}, [searchParams, tabs, updateTab, isParsedParams]);

	useEffect(() => {
		if (selectedIndex !== null) {
			const newTabKey = tabs[selectedIndex].key;
			updateUrlWithTab(newTabKey);
		}
	}, [selectedIndex]);

	return { updateTab, selectedIndex };
};

export default useTabStateWithQueryParam;
