'use client';
import { Separator } from '@/components/ui/separator';
import AmenitiesAndServices from '@/containers/amenities-and-services/AmenitiesAndServices';
import PaymentInformation from '@/containers/payment-information/PaymentInformation';
import { usePathname, useSearchParams } from 'next/navigation';
import { useCallback, useEffect, useMemo, useState } from 'react';
import GeneralInformation from '../general-information';

export default function TabHeadRecordedRecords() {
	const pathname = usePathname();
	const [selectedIndex, setSelectedIndex] = useState<number | null>(null);
	const [isParsedParams, setIsParsedParams] = useState<boolean>(false);
	const searchParams = useSearchParams();

	const updateUrlWithTab = useCallback(
		(newTabKey: string) => {
			const current = new URLSearchParams(Array.from(searchParams.entries()));
			current.set('tab', newTabKey);
			window.history.replaceState({}, '', `${pathname}?${current.toString()}`);
		},
		[searchParams, pathname]
	);

	const updateTab = (index: number) => {
		setSelectedIndex(index);
	};

	const tabs = useMemo(
		() => [
			{
				title: 'Thông tin chung',
				key: 'general',
				component: <GeneralInformation onNext={() => updateTab(1)} />,
			},
			{
				title: 'Tiện ích và dịch vụ',
				key: 'amenities',
				component: <AmenitiesAndServices onNext={() => updateTab(2)} />,
			},
			{
				title: 'Thông tin thanh toán',
				key: 'payment',
				component: <PaymentInformation />,
			},
		],
		[]
	);

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

	return (
		<>
			<div className="w-full">
				<div className="flex w-full flex-wrap justify-start gap-0 gap-y-4 text-left lg:flex-nowrap lg:gap-6">
					{tabs.map((tab, index) => (
						<button
							key={index}
							className={`w-1/2 border-b-4 pb-3 text-md font-medium leading-6 text-neutral-300 lg:w-fit ${
								selectedIndex === index
									? 'border-primary-500 text-primary-500'
									: 'border-transparent'
							}`}
							onClick={() => updateTab(index)}>
							{tab.title}
						</button>
					))}
				</div>
				<Separator />
			</div>
			{selectedIndex !== null ? (
				<div className="mt-8">{tabs[selectedIndex].component}</div>
			) : null}
		</>
	);
}
