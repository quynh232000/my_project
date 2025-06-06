'use client';
import { cn } from '@/lib/utils';
import { useCounterContext } from '@/components/context/CounterContext';
import AccommodationTypeSelector from '@/containers/auth/onboarding/accommodation/AccommodationTypeSelector';
// import AccommodationAddressForm from '@/containers/auth/onboarding/accommodation/AccommodationAddressForm';
import AccommodationSizeSelector from '@/containers/auth/onboarding/accommodation/AccommodationSizeSelector';
import AccommodationActivation from '@/containers/auth/onboarding/accommodation/AccommodationActivation';

export default function AccommodationView({ className }: ClassNameProp) {
	const { count } = useCounterContext();

	const renderView = () => {
		switch (count) {
			case 1:
				return <AccommodationTypeSelector />;
			case 2:
				return <AccommodationSizeSelector />;
			case 3:
				// return <AccommodationAddressForm />;
				return <div/>
			case 4:
				return <AccommodationActivation />;
			default:
				return <AccommodationTypeSelector />;
		}
	};

	return <div className={cn('', className)}>{renderView()}</div>;
}
