import { useState } from 'react';
import ContainerView from '@/components/shared/Container/ContainerView';
import AppLogo from '@/assets/Logo/AppLogo';
import { ButtonVariants } from '@/components/shared/Button/types';
import {
	InputOTP,
	InputOTPGroup,
	InputOTPSlot,
} from '@/components/ui/input-otp';
import { REGEXP_ONLY_DIGITS } from 'input-otp';
import { useForgotPasswordContext } from '@/components/context/auth/ForgotPasswordContext';
import { useCounterContext } from '@/components/context/CounterContext';
import { toast } from 'sonner';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { verifyPassword } from '@/services/auth/verifyPass';
import { APIValidationError, HttpError } from '@/utils/errors/apiError';
import { useLoadingStore } from '@/store/loading/store';

const OTPVerification = () => {
	const [otp, setOTP] = useState('');
	const { email } = useForgotPasswordContext();
	const { incrementCount, decrementCount } = useCounterContext();
	const setLoading = useLoadingStore(state => state.setLoading);
	const handleSubmit = async () => {
		setLoading(true);
		if (otp.length === 4) {
			try {
				const res = await verifyPassword({ email, code: otp });
				toast.success(res?.message);
				incrementCount();
			} catch (error) {
				if (error instanceof APIValidationError) {
					toast.error(error.payload?.message || error.message);
				} else if (error instanceof HttpError) {
					toast.error(error.payload?.message || error.message);
				} else {
					toast.error('Đã xảy ra lỗi, vui lòng thử lại sau.');
				}
			} finally {
				setLoading(false);
			}
		} else {
			toast.error('Mã OTP không hợp lệ');
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
			<Typography variant={'headline_32px_700'}>Nhập mã OTP</Typography>
			<div>
				<Typography variant={'content_16px_400'} className={'text-neutral-600'}>
					Chúng tôi đã gửi mã xác minh đến địa chỉ email{' '}
					<span className={'text-nowrap font-semibold'}>{email}</span>
					<br />
				</Typography>
				<button
					onClick={decrementCount}
					className={`${TextVariants.caption_14px_400} mt-2 text-secondary-500`}>
					Email không đúng?
				</button>
			</div>
			<InputOTP
				maxLength={4}
				onChange={(value) => setOTP(value)}
				pattern={REGEXP_ONLY_DIGITS}>
				<InputOTPGroup className={'min-w-md gap-6'}>
					<InputOTPSlot index={0} />
					<InputOTPSlot index={1} />
					<InputOTPSlot index={2} />
					<InputOTPSlot index={3} />
				</InputOTPGroup>
			</InputOTP>
			<button
				onClick={handleSubmit}
				className={
					otp.length === 4
						? ButtonVariants['16px_px24_py12_active']
						: ButtonVariants['16px_px24_py12_inactive']
				}>
				Tiếp tục
			</button>
		</ContainerView>
	);
};

export default OTPVerification;
