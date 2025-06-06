import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';

export default async function Page() {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle title={'Dashboard'} pathName={pathName} />
		</DashboardContainer>
	);
}
