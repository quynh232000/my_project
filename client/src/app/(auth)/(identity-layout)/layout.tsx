import StoreLayout from '@/components/layouts/store-layout/StoreLayout';
import WelcomeBanner from '@/containers/auth/common/WelcomeBanner';
import WelcomeFooter from '@/containers/auth/common/WelcomeFooter';
import React from 'react';

export default function Layout({ children }: { children: React.ReactNode }) {
	return (
		<div className={'flex min-h-screen flex-wrap lg:flex-nowrap'}>
			<WelcomeBanner />
			<div className={'flex flex-1 flex-col'}>
				<div className={'flex flex-1 flex-col items-center justify-center'}>
					<StoreLayout>{children}</StoreLayout>
				</div>
				<WelcomeFooter />
			</div>
		</div>
	);
}

//constants
