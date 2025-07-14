
import type { Metadata } from 'next';
import { Inter } from 'next/font/google';
import './globals.css';
import HolyLoader from 'holy-loader';
import { Toaster } from '@/components/ui/sonner';
import LoadingView from '@/components/shared/Loading/LoadingView';
import Header from '@/components/layouts/app/Header';
import Footer from '@/components/layouts/app/Footer';

const geistSans = Inter({
	variable: '--font-geist-sans',
	weight: ['400', '500', '600', '700'],
	subsets: ['vietnamese'],
});

export const metadata: Metadata = {
	title: 'Quin Booking',
	description:
		'Quin booking - Nền tảng du lịch nhiều người truy cập nhất Việt Nam | quin-booking.mr-quynh.site',
};
import 'swiper/css';
import 'swiper/css/scrollbar';
import ClientWrapper from '@/components/layouts/ClientWrapper';
export default function RootLayout({
	children,
}: Readonly<{
	children: React.ReactNode;
}>) {
	return (
		<html lang="vi" className={'overflow-x-hidden !scroll-smooth'}>
			<body className={`${geistSans.className} w-full antialiased`}>
				<div>
					<ClientWrapper>
						<Header />
						<HolyLoader />
						{children}
						<Toaster />
						<LoadingView />
						<Footer/>
					</ClientWrapper>
				</div>
			</body>
		</html>
	);
}
