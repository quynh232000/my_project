'use client';

import AppSidebar from '@/components/shared/Sidebar/AppSidebar';
import MainLayout from '@/components/layouts/main-layout/MainLayout';
import ClientProviders from '@/components/providers/ClientProviders';
import HolyLoader from 'holy-loader';
import { Toaster } from 'sonner';
import LoadingView from '@/components/shared/Loading/LoadingView';

export default function Layout({ children }: ChildrenProp) {
	return (
		<ClientProviders>
			<HolyLoader />
			<AppSidebar />
			<MainLayout>{children}</MainLayout>
			<Toaster />
			<LoadingView />
		</ClientProviders>
	);
}
