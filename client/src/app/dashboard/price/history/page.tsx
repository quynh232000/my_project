import React from 'react';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import PriceHistoryTable from '@/containers/price/history/PriceHistoryTable';
import ActionDownloadCSV from '@/containers/price/history/ActionDownloadCSV';

const Page = async () => {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle extraTitle={<ActionDownloadCSV/>} displayName={{"history": "Lịch sử giá"}} pathName={pathName} title={'Lịch sử giá'} />
			<DashboardCard>
				<PriceHistoryTable/>
			</DashboardCard>
		</DashboardContainer>
	);
};

export default Page;