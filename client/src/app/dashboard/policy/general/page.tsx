import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import PolicyGeneral from '@/containers/policy/policy-general/PolicyGeneral';

// CHÍNH SÁCH CHUNG
export default async function Page() {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				title={'Chính sách chung'}
				pathName={pathName}
			/>
			<DashboardCard>
				<PolicyGeneral />
			</DashboardCard>
		</DashboardContainer>
	);
}
