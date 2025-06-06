import React from 'react';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import UserGroupTable from '@/containers/user/user-group/UserGroupTable';

const Page = async () => {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle pathName={pathName} title={'Nhóm người dùng'} />
			<DashboardCard>
				<UserGroupTable/>
			</DashboardCard>
		</DashboardContainer>
	);
};
export default Page;
