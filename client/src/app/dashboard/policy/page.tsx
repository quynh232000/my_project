import { redirect } from 'next/navigation';
import { DashboardRouter } from '@/constants/routers';

export default function Page() {
	redirect(DashboardRouter.policyGeneral);
}
