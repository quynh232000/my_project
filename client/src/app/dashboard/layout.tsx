'use client';

import AppSidebar from '@/components/shared/Sidebar/AppSidebar';
import MainLayout from '@/components/layouts/main-layout/MainLayout';
import ClientProviders from '@/components/providers/ClientProviders';

export default function Layout({ children }: ChildrenProp) {
	return (
		<ClientProviders>
			<AppSidebar />
			<MainLayout>{children}</MainLayout>
		</ClientProviders>
	);
}
