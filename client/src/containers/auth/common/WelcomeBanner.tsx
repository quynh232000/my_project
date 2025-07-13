import Image from 'next/image';
import AppLogo from '@/assets/Logo/AppLogo';
import Typography from '@/components/shared/Typography';

const WelcomeBanner = () => {
	return (
		<div
			className={
				'flex w-full flex-col bg-primary-800 text-white lg:w-[600px]'
			}>
			<Image
				alt={'banner'}
				src={'/images/pages/auth/login/banners/banner-viewer.jpg'}
				width={800}
				height={800}
				className={'hidden h-auto w-full lg:block'}
			/>
			<div className={'space-y-6 p-[50px] pb-20'}>
				<AppLogo />
				<Typography variant={'headline_32px_700'}>
					Chào mừng đến với HMS! <br />
					Giải pháp quản lý khách sạn <br />
					hiệu quả và dễ dàng.
				</Typography>
				<Typography variant={'content_16px_400'}>
					Chúng tôi sẽ đồng hành cùng bạn để tối ưu hóa hoạt động và
					nâng cao trải nghiệm khách hàng!
				</Typography>
			</div>
		</div>
	);
};

export default WelcomeBanner;
