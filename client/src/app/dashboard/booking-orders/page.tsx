import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import React from 'react';
import BookingOrderTable from '@/containers/booking-orders/BookingOrderTable';

const Page = async () => {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle pathName={pathName} title={'Đơn đặt phòng'} />
			<DashboardCard className={"lg:p-0"}>
				<BookingOrderTable/>
			</DashboardCard>
		</DashboardContainer>
	);
};
export default Page;
