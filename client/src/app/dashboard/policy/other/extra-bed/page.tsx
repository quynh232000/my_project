import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import ExtraBed from '@/containers/policy/other-policies/extra-bed/ExtraBed';

// CHÍNH SÁCH NÔI/CŨI GIƯỜNG PHỤ
export default async function Page() {
	const { pathName } = await getFullURLServerComponent()
	return <DashboardContainer>
		<DashboardHeroTitle className='text-2xl leading-8 font-bold' title={"Nôi/cũi và giường phụ"} pathName={pathName} />
		<DashboardCard>
			<ExtraBed />
		</DashboardCard>
	</DashboardContainer>
}
