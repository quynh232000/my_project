import React from 'react';

import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';

import UserGroupForm from '@/containers/user/user-group/user-group-detail/UserGroupForm';

const Page = async () => {
	
	return (
		<DashboardContainer>
			
			<UserGroupForm />
		</DashboardContainer>
	);
};
export default Page;
