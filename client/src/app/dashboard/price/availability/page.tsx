import React from 'react';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import AvailabilityActions from '@/containers/price/Availability/common/AvailabilityActions';
import AvailabilityDesc from '@/containers/price/Availability/common/AvailabilityDesc';
import Availability from '@/containers/price/Availability';

const Page = async () => {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				pathName={pathName}
				title={'Giá và phòng trống'}
				extraContent={<AvailabilityDesc />}
				extraTitle={<AvailabilityActions />}
			/>
			<Availability />
		</DashboardContainer>
	);
};

export default Page;
