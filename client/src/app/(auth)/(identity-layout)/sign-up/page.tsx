import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { ButtonVariants } from '@/components/shared/Button/types';
import Link from 'next/link';
import { AuthRouters } from '@/constants/routers';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';

export default function Page() {
	return (
		<div className={'flex w-full max-w-md flex-col gap-8 text-center'}>
			<Typography tag={'h2'} variant={'headline_28px_700'}>
				Đăng Ký
			</Typography>
			<div>
				<div className={'mb-6'}>
					<Label required={true}>Email</Label>
					<Input type="email" placeholder="Nhập email đã đăng ký" />
				</div>
				<div className={'mb-6'}>
					<Label required={true}>Họ và tên</Label>
					<Input type="text" placeholder="Nhập họ và tên" />
				</div>
				<div>
					<Label required={true}>Số điện thoại</Label>
					<Input type="tel" placeholder="Nhập số điện thoại" />
				</div>
			</div>
			<button className={ButtonVariants['16px_px24_py12_inactive']}>
				Đăng nhập
			</button>
			<Link
				href={AuthRouters.signIn}
				className={cn(
					'text-neutral-400',
					TextVariants.caption_14px_500
				)}>
				Bạn đã có tài khoản?{' '}
				<span className={'text-secondary-500'}>Đăng nhập</span>
			</Link>
		</div>
	);
}
