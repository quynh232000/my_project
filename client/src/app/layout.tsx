
import type { Metadata } from 'next';
import { Inter } from 'next/font/google';
import './globals.css';


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
export default function RootLayout({
	children,
}: Readonly<{
	children: React.ReactNode;
}>) {
	return (
		<html lang="vi" className={'overflow-x-hidden !scroll-smooth'}>
			<body className={`${geistSans.className} w-full antialiased`}>
				<div>
					{children}
				</div>
			</body>
		</html>
	);
}
