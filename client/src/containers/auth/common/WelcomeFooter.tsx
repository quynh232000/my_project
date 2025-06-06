import Link from 'next/link';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';

const WelcomeFooter = () => {
	return (
		<div className={'flex items-center justify-center gap-2.5 py-12 flex-wrap lg:flex-nowrap'}>
			<Typography className={'text-neutral-300'}>
				© 2025 190Booking. All rights reserved.
			</Typography>
			<Link
				href={'#'}
				className={`${TextVariants.caption_14px_500} text-neutral-600`}>
				Điều khoản & Điều kiện
			</Link>
			<Link
				href={'#'}
				className={`${TextVariants.caption_14px_500} text-neutral-600`}>
				Chính sách bảo mật
			</Link>
		</div>
	);
};

export default WelcomeFooter;
