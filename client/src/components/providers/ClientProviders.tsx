'use client';

import { SidebarProvider } from '@/components/ui/sidebar';
import { CookiesProvider } from 'react-cookie';
import { ReactNode } from 'react';

interface ClientProvidersProps {
	children: ReactNode;
}

export default function ClientProviders({ children }: ClientProvidersProps) {
	return (
		<CookiesProvider>
			<SidebarProvider
				style={
					{
						'--sidebar-width': '17.5rem',
						'--sidebar-width-mobile': '20rem',
					} as React.CSSProperties
				}>
				{children}
			</SidebarProvider>
		</CookiesProvider>
	);
}
