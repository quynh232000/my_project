'use client';
import { Separator } from '@/components/ui/separator';
import PaymentInformation from '@/containers/payment-information/PaymentInformation';
import GeneralInformation from '../general-information';
import AmenitiesAndServices from '@/containers/amenities-and-services/AmenitiesAndServices';
import useTabStateWithQueryParam from '@/hooks/use-tab-state-with-query-param';
import { tabDefs } from '@/containers/recorded-records/data';

export default function TabHeadRecordedRecords() {
	const { updateTab, selectedIndex } = useTabStateWithQueryParam(tabDefs);
	const components = [
		<GeneralInformation key={1} onNext={() => updateTab(1)} />,
		<AmenitiesAndServices key={2} onNext={() => updateTab(2)} />,
		<PaymentInformation key={3} />,
	];

	return (
		<>
			<div className="w-full">
				<div className="flex w-full flex-wrap justify-start gap-0 gap-y-4 text-left lg:flex-nowrap lg:gap-6">
					{tabDefs.map((tab, index) => (
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
				<div className="mt-8">{components[selectedIndex]}</div>
			) : null}
		</>
	);
}
