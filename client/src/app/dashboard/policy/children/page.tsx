import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import ChildPolicy from '@/containers/policy/child-policy/ChildPolicy';

//CHÍNH SÁCH CHO TRẺ EM
export default async function Page() {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				title={'Chính sách cho trẻ em'}
				pathName={pathName}
			/>
			<DashboardCard>
				<ChildPolicy />
			</DashboardCard>
		</DashboardContainer>
	);
}
