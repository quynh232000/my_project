import type { NextConfig } from 'next';

const nextConfig: NextConfig = {
	/* config options here */
	output: process.env.DOMAIN === 'localhost' ? undefined : 'standalone',
	images: {
		remotePatterns: [
			{
				protocol: 'https',
				hostname: 'data.vietnambooking.com',
			},
			{
				protocol: 'https',
				hostname: 'admin.190booking.com',
			},
			{
				protocol: 'https',
				hostname: 'data.190booking.com',
			},
			{
				protocol: 'https',
				hostname: 'img.youtube.com',
			},
			{
				protocol: 'https',
				hostname: 'www.vietnambooking.com',
			},
			{
				protocol: 'https',
				hostname: '190booking.com',
			},
			{
				protocol: 'https',
				hostname: 'console.190booking.com',
			},
			{
				protocol: 'https',
				hostname: 'flagcdn.com',
			},
		],
		contentSecurityPolicy: "default-src 'self'; script-src 'none'; sandbox;",
	},
};

export default nextConfig;
