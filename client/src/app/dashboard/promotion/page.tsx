import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import PromotionTable from '@/containers/promotion/PromotionTable';

export default async function Page() {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle pathName={pathName} title={'Khuyến mãi'} />
			<DashboardCard>
				<PromotionTable />
			</DashboardCard>
		</DashboardContainer>
	);
}
