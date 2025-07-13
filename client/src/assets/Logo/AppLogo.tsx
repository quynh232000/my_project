import Typography from '@/components/shared/Typography';

interface AppLogoProps {
	hideBrand?: boolean;
}

export default function AppLogo({ hideBrand }: AppLogoProps) {
	return (
		<div className={'flex items-center gap-2.5'}>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				width="26"
				height="24"
				viewBox="0 0 26 24"
				fill="none">
				<path
					d="M7.36707 24L3.29482 21.0953L9.14405 13.6883L0 10.9652L1.55486 6.28139L10.5508 9.40393L10.3287 0H15.3635L15.1414 9.40393L24.1003 6.28139L25.6552 10.9652L16.5481 13.6883L22.3233 21.0953L18.2511 24L12.8461 16.3026L7.36707 24Z"
					fill="#2A85FF"
				/>
			</svg>
			{!hideBrand && (
				<Typography
					variant={'headline_24px_700'}
					className={'text-nowrap'}>
					190 HMS
				</Typography>
			)}
		</div>
	);
}
