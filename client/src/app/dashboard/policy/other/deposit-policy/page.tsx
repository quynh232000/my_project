import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import DepositPolicy from '@/containers/policy/other-policies/deposit-policy/DepositPolicy';

// CHÍNH SÁCH ĐẶT CỌC
export default async function Page() {
	const { pathName } = await getFullURLServerComponent()

	return <DashboardContainer>
		<DashboardHeroTitle title={"Chính sách đặt cọc"} pathName={pathName} />
		<DashboardCard>
			<DepositPolicy />
		</DashboardCard>
	</DashboardContainer>
}