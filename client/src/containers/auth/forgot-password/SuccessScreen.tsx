'use client';
import ContainerView from '@/components/shared/Container/ContainerView';
import CheckIconAnimation from '@/containers/auth/forgot-password/common/CheckIconAnimation';
import { ButtonProgressAnimation } from '@/components/shared/Button/ButtonProgressAnimation';
import FadeAnimationView from '@/components/shared/Animation/FadeAnimationView';
import { useRouter } from 'next/navigation';
import { AuthRouters } from '@/constants/routers';
import Typography from '@/components/shared/Typography';

const SuccessScreen = () => {
	const router = useRouter();
	return (
		<ContainerView
			containerClassName={'w-full'}
			className={
				'flex min-h-screen max-w-md flex-col items-center justify-center gap-6 text-center'
			}>
			<CheckIconAnimation />
			<FadeAnimationView config={{ delay: 0.9, start: 20, end: 0 }}>
				<Typography
					variant={'headline_32px_700'}
					className={'animate-fade-bottom-to-top'}>
					Bạn đã thay đổi mật khẩu thành công
				</Typography>
			</FadeAnimationView>
			<FadeAnimationView config={{ delay: 1, start: 20, end: 0 }}>
				<ButtonProgressAnimation
					onButtonClick={() => router.replace(AuthRouters.signIn)}>
					Quay lại trang đăng nhập
				</ButtonProgressAnimation>
			</FadeAnimationView>
		</ContainerView>
	);
};

export default SuccessScreen;
