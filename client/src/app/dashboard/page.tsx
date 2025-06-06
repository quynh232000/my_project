import { redirect } from 'next/navigation';
import { DashboardRouter } from '@/constants/routers';

export default async function Page() {
	redirect(DashboardRouter.profile);
}
