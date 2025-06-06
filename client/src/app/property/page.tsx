import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import DashboardMenu from '@/components/shared/Dashboard/DashboardMenu';
import Typography from '@/components/shared/Typography';
import { TOKEN_EXPIRED_MESSAGE } from '@/configs/axios/axios';
import {
	AuthRouters,
	PropertySelectRouters,
	RefreshRouters
} from '@/constants/routers';
import { PropertyTable } from '@/containers/property/PropertyTable';
import {
	getPropertyList,
	IProperty,
} from '@/services/property/getPropertyList';
import { AxiosError } from 'axios';
import { addDays } from 'date-fns';
import { cookies } from 'next/headers';
import { redirect } from 'next/navigation';

export const dynamic = 'force-dynamic';

export default async function Page() {
	let propertyList: IProperty[] | null = null;

	try {
		propertyList = await getPropertyList();
	} catch (error) {
		const axiosError = error as AxiosError;
		const msg = (axiosError?.response?.data as { message: string })?.message;
		if (msg === TOKEN_EXPIRED_MESSAGE) {
			return redirect(
				`${RefreshRouters.index}?redirect=${PropertySelectRouters.index}`
			);
		} else {
			return redirect(AuthRouters.signIn + '?force=true');
		}
	}

	const handleSelectProperty = async (property: IProperty) => {
		'use server';
		if (property.status === 'active') {
			const cookiesStore = await cookies();
			cookiesStore.set('hotel_id', String(property.id), {
				path: '/',
				httpOnly: false,
				sameSite: 'strict',
				secure: true,
				expires: addDays(new Date(), 30),
			});
		}
	};

	return (
		<div className={'min-h-screen bg-blue-100'}>
			<DashboardMenu />
			<div className={'px-6'}>
				<Typography
					variant={'headline_24px_700'}
					className={'py-6 text-neutral-600'}>
					Danh sách chỗ nghỉ
				</Typography>
				<DashboardCard>
					<PropertyTable
						propertyList={propertyList ?? []}
						onSelectProperty={handleSelectProperty}
					/>
				</DashboardCard>
			</div>
		</div>
	);
}
