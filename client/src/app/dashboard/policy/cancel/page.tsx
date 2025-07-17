import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import Establish from '@/containers/policy/refund-and-cancellation-policy/commons/Establish';

// CHÍNH SÁCH HOÀN HỦY
export default async function Page() {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				title={'Chính sách hoàn hủy'}
				pathName={pathName}
			/>
			<DashboardCard>
				<Establish />
			</DashboardCard>
		</DashboardContainer>
	);
}
