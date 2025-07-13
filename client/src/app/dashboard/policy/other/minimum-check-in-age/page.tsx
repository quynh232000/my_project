import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import MinimumCheckInAge from '@/containers/policy/other-policies/minimum-check-in-age/MinimumCheckInAge';

// CHÍNH SÁCH KHÁC
export default async function Page() {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				title={'Độ tuổi tối thiểu nhận phòng'}
				pathName={pathName}
			/>
			<DashboardCard>
				<MinimumCheckInAge />
			</DashboardCard>
		</DashboardContainer>
	);
}
