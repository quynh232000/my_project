import AppLogo from '@/assets/Logo/AppLogo';
import ContainerView from '@/components/shared/Container/ContainerView';

const AppHeader = () => {
	return (
		<ContainerView
			className={'py-4'}
			containerClassName={'border-b border-gray-300'}>
			<AppLogo />
		</ContainerView>
	);
};

export default AppHeader;
