import { CounterProvider } from '@/components/context/CounterContext';
import ContainerView from '@/components/shared/Container/ContainerView';
import OnboardingNotice from '@/containers/auth/onboarding/OnboardingNotice';
import AccommodationView from '@/containers/auth/onboarding/AccommodationView';
import AppHeader from '@/components/layouts/app-header/AppHeader';

export default function Page() {
	return (
		<CounterProvider>
			<div className={'flex min-h-screen flex-col'}>
				<AppHeader />
				<ContainerView
					containerClassName={'flex-1 flex items-center justify-center'}
					className={'flex'}>
					<OnboardingNotice className={'flex-1'} />
					<AccommodationView className={'flex-1'} />
				</ContainerView>
			</div>
		</CounterProvider>
	);
}
