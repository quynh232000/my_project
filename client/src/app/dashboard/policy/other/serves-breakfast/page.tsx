import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import ServersBreakfast from '@/containers/policy/other-policies/servers-breakfast/ServersBreakfast';

export default async function Page() {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				title={'Phục vụ bữa sáng'}
				pathName={pathName}
			/>
			<DashboardCard>
				<ServersBreakfast />
			</DashboardCard>
		</DashboardContainer>
	);
}
