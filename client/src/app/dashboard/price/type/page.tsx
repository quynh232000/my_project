import React from 'react';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import PriceTable from '@/containers/price/PriceTable';

const Page = async () => {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle pathName={pathName} title={'Loại giá'} />
			<DashboardCard>
				<PriceTable />
			</DashboardCard>
		</DashboardContainer>
	);
};

export default Page;
