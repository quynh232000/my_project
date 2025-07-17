'use client';
import { useState } from 'react';
import ContainerView from '@/components/shared/Container/ContainerView';
import AppLogo from '@/assets/Logo/AppLogo';
import { Label } from '@/components/ui/label';
import { ButtonVariants } from '@/components/shared/Button/types';
import ValidationStatusItem from '@/containers/auth/forgot-password/common/ValidationStatusItem';
import { validatePasswordCriteria } from '@/containers/auth/forgot-password/helper/validatePasswordCriteria';
import InputPassword from '@/containers/auth/forgot-password/common/InputPassword';
import { motion } from 'framer-motion';
import { toast } from 'sonner';
import { useCounterContext } from '@/components/context/CounterContext';
import Typography from '@/components/shared/Typography';
import { resetPassword } from '@/services/auth/resetPass';
import { useForgotPasswordContext } from '@/components/context/auth/ForgotPasswordContext';
import { useLoadingStore } from '@/store/loading/store';
import { APIValidationError, HttpError } from '@/utils/errors/apiError';

const NewPassword = () => {
	const { incrementCount } = useCounterContext();
	const [password, setPassword] = useState('');
	const [nPassword, setNewPassword] = useState('');
	const checkRegex =
		validatePasswordCriteria(password).isMinLength &&
		validatePasswordCriteria(password).hasUpperCase &&
		validatePasswordCriteria(password).hasNumber &&
		validatePasswordCriteria(password).hasLowerCase;

	const checkPassword = password === nPassword;
	const { email } = useForgotPasswordContext();
	const setLoading = useLoadingStore((state) => state.setLoading);

	const handleSubmit = async () => {
		if (!checkRegex) {
			toast.error('Mật khẩu không đủ mạnh');
			return;
		} else if (!checkPassword) {
			toast.error('Nhập lại mật khẩu không khớp');
			return;
		} else {
			setLoading(true);
			try {
				const res = await resetPassword({
					email,
					password,
					password_confirmation: nPassword,
				});
				toast.success(res?.message);
				incrementCount();
			} catch (error) {
				if (error instanceof APIValidationError) {
					toast.error(error.payload?.message);
				} else if (error instanceof HttpError) {
					toast.error(error.payload?.message || error.message);
				} else {
					toast.error('Đã xảy ra lỗi, vui lòng thử lại sau');
				}
			} finally {
				setLoading(false);
			}
		}
	};

	return (
		<ContainerView
			containerClassName={'w-full'}
			className={
				'flex min-h-screen max-w-md flex-col items-center justify-center gap-8'
			}>
			<AppLogo />
			<div className={'text-center'}>
				<Typography variant={'headline_32px_700'} className={'mb-4'}>
					Mật khẩu mới
				</Typography>
				<Typography variant={'content_16px_400'}>
					Đặt mật khẩu mới cho của bạn với tối thiểu 8 ký tự, bao gồm
					sự kết hợp giữa chữ cái và số.
				</Typography>
			</div>
			<div className={'w-full'}>
				<Label required={true}>Mật khẩu mới</Label>
				<InputPassword
					placeholder="Nhập mật khẩu mới"
					setPassword={setPassword}
					password={password}
				/>
				<motion.div
				{...({} as any)}
					initial={{ opacity: 0, height: 0, marginTop: 0 }}
					animate={
						!checkRegex
							? { opacity: 1, height: 'auto', marginTop: 32 }
							: { opacity: 0, height: 0, marginTop: 0 }
					}
					transition={{ duration: 0.3, ease: 'easeInOut' }}
					className={'grid w-full grid-cols-2 gap-4'}>
					<ValidationStatusItem
						message={'Ít nhất 8 ký tự'}
						status={validatePasswordCriteria(password).isMinLength}
					/>
					<ValidationStatusItem
						message={'Chữ cái viết hoa (A-Z)'}
						status={validatePasswordCriteria(password).hasUpperCase}
					/>
					<ValidationStatusItem
						message={'Số (0-9)'}
						status={validatePasswordCriteria(password).hasNumber}
					/>
					<ValidationStatusItem
						message={'Chữ cái viết thường (a-z)'}
						status={validatePasswordCriteria(password).hasLowerCase}
					/>
				</motion.div>
			</div>
			<div className={'w-full'}>
				<Label required={true}>Xác nhận mật khẩu</Label>
				<InputPassword
					placeholder="Nhập lại mật khẩu mới"
					setPassword={setNewPassword}
					password={nPassword}
				/>
			</div>
			<button
				onClick={handleSubmit}
				className={
					checkRegex
						? ButtonVariants['16px_px24_py12_active']
						: ButtonVariants['16px_px24_py12_inactive']
				}>
				Tiếp tục
			</button>
		</ContainerView>
	);
};

export default NewPassword;
