import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import RoomTable from '@/containers/setting-room/RoomTable';

export default async function Page() {
	const { pathName } = await getFullURLServerComponent();

	return (
		<DashboardContainer>
			<DashboardHeroTitle title={'Quản lý phòng'} pathName={pathName} />
			<DashboardCard>
				<RoomTable/>
			</DashboardCard>
		</DashboardContainer>
	);
}
