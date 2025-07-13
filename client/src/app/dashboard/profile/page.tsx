import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import TabHeadRecordedRecords from '@/containers/recorded-records/TabHeadRecordedRecords';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';

export default async function Page() {
	const { pathName } = await getFullURLServerComponent();

	const safePathName = pathName || '/';
	console.log('----------pathName: ', safePathName);
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				title={'Hồ sơ chỗ nghỉ'}
				pathName={safePathName}
			/>
			<DashboardCard>
				<TabHeadRecordedRecords />
			</DashboardCard>
		</DashboardContainer>
	);
}
