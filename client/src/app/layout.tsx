import type { Metadata } from 'next';
import { Inter } from 'next/font/google';
import './globals.css';
import HolyLoader from 'holy-loader';
import { Toaster } from '@/components/ui/sonner';
import LoadingView from '@/components/shared/Loading/LoadingView';

const geistSans = Inter({
	variable: '--font-geist-sans',
	weight: ['400', '500', '600', '700'],
	subsets: ['vietnamese'],
});

export const metadata: Metadata = {
	title: '190Booking - HMS',
	description: 'Hotel Management System for partners of 190Booking',
};

export default function RootLayout({
	children,
}: Readonly<{
	children: React.ReactNode;
}>) {
	return (
		<html lang="vi" className={'overflow-x-hidden !scroll-smooth'}>
			<body className={`${geistSans.className} w-full antialiased`}>
				<HolyLoader />
				{children}
				<Toaster />
				<LoadingView />
			</body>
		</html>
	);
}
