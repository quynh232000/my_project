import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import SettingRefundAndCancellationPolicy from '@/containers/policy/refund-and-cancellation-policy/commons/SettingRefundAndCancellationPolicy';

export default async function Page() {
	const { pathName } = await getFullURLServerComponent()
	return <DashboardContainer>
		<DashboardHeroTitle title={"Thiết lập"} pathName={pathName} />
		<DashboardCard>
			<SettingRefundAndCancellationPolicy />
		</DashboardCard>
	</DashboardContainer>
}
