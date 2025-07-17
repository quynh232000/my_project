import React from 'react';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import ButtonBack from '@/containers/price/common/ButtonBack';
import { DashboardRouter } from '@/constants/routers';
import UserGroupForm from '@/containers/user/user-group/user-group-detail/UserGroupForm';

const Page = async () => {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				actionBack={<ButtonBack url={DashboardRouter.userGroup} />}
				pathName={pathName}
				title={'Nhóm người dùng'}
			/>
			<UserGroupForm />
		</DashboardContainer>
	);
};
export default Page;
