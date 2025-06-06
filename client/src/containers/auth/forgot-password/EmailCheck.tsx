import ContainerView from '@/components/shared/Container/ContainerView';
import AppLogo from '@/assets/Logo/AppLogo';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { ButtonVariants } from '@/components/shared/Button/types';
import { useForgotPasswordContext } from '@/components/context/auth/ForgotPasswordContext';
import isEmail from 'validator/es/lib/isEmail';
import { toast } from 'sonner';
import { useCounterContext } from '@/components/context/CounterContext';
import Typography from '@/components/shared/Typography';
import Link from 'next/link';
import { AuthRouters } from '@/constants/routers';
import { useLoadingStore } from '@/store/loading/store';
import { forgotPass } from '@/services/auth/forgotPass';
import { APIValidationError, HttpError } from '@/utils/errors/apiError';

const EmailCheck = () => {
	const { setEmail, email } = useForgotPasswordContext();
	const { incrementCount } = useCounterContext();
	const setLoading = useLoadingStore(state => state.setLoading);

	const handleSubmit = async () => {
		if (isEmail(email)) {
			setLoading(true);
			try {
				const res = await forgotPass({ email });
				toast.success(res?.message);
				incrementCount();
			} catch (error) {
				if (error instanceof APIValidationError) {
					const emailErrors = error.payload.error?.details?.email;
					if (emailErrors && emailErrors.length > 0) {
						toast.error(emailErrors[0]);
					} else {
						toast.error(error.payload.message || 'Dữ liệu không hợp lệ!');
					}
				} else if (error instanceof HttpError) {
					toast.error(error.payload?.message || error.message);
				} else {
					toast.error('Đã xảy ra lỗi, vui lòng thử lại sau.');
				}
			} finally {
				setLoading(false);
			}
		} else {
			toast.error('Email không hợp lệ');
			setLoading(false);
		}
	};

	return (
		<ContainerView
			containerClassName={'w-full'}
			className={
				'flex min-h-screen max-w-md flex-col items-center justify-center gap-6 text-center'
			}>
			<AppLogo />
			<Typography variant={'headline_32px_700'}>
				Đặt lại mật khẩu của bạn
			</Typography>
			<Typography variant={'content_16px_400'}>
				Nhập địa chỉ email đã đăng ký và chúng tôi sẽ gửi cho bạn hướng dẫn để
				đặt lại mật khẩu.
			</Typography>
			<div className={'w-full'}>
				<Label required={true}>Email</Label>
				<Input
					type="email"
					placeholder="Nhập email đã đăng ký"
					onChange={(event) => setEmail?.(event.target.value)}
					value={email}
				/>
			</div>
			<button
				onClick={handleSubmit}
				className={
					email.length > 0
						? ButtonVariants['16px_px24_py12_active']
						: ButtonVariants['16px_px24_py12_inactive']
				}>
				Tiếp tục
			</button>
			<Link href={AuthRouters.signIn} className={'text-secondary-500'}>
				Trở về trang đăng nhập
			</Link>
		</ContainerView>
	);
};

export default EmailCheck;
