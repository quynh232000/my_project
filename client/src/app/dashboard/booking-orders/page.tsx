import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import React from 'react';
import BookingOrderTable from '@/containers/booking-orders/BookingOrderTable';
import BookingOrderActions from '@/containers/booking-orders/common/BookingOrderActions';

const Page = async () => {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle pathName={pathName} title={'Đơn đặt phòng'} extraTitle={<BookingOrderActions/>}/>
			<DashboardCard className={"lg:p-4 bg-other-white"}>
				<BookingOrderTable/>
			</DashboardCard>
		</DashboardContainer>
	);
};
export default Page;
