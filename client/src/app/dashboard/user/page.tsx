import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import React from 'react';
import UserTable from '@/containers/user/UserTable';

const Page = async () => {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle pathName={pathName} title={'Danh sách người dùng'} />
			<DashboardCard>
				<UserTable/>
			</DashboardCard>
		</DashboardContainer>
	);
};
export default Page;
