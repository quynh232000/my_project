

import HolyLoader from 'holy-loader';
import { Toaster } from '@/components/ui/sonner';
import LoadingView from '@/components/shared/Loading/LoadingView';
import Header from '@/components/layouts/app/Header';
import Footer from '@/components/layouts/app/Footer';


import ClientWrapper from '@/components/layouts/ClientWrapper';
export default function RootLayout({
	children,
}: Readonly<{
	children: React.ReactNode;
}>) {
	return (
		<ClientWrapper>
			<Header />
			<HolyLoader />
			{children}
			<Toaster />
			<LoadingView />
			<Footer/>
		</ClientWrapper>
	);
}
