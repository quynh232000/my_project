import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import OtherPolicies from '@/containers/policy/other-policies/OtherPolicies';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';

// CHÍNH SÁCH KHÁC
export default async function Page() {
	const { pathName } = await getFullURLServerComponent();

	return (
		<DashboardContainer>
			<DashboardHeroTitle title={'Chính sách khác'} pathName={pathName} />
			<DashboardCard>
				<OtherPolicies />
			</DashboardCard>
		</DashboardContainer>
	);
}
