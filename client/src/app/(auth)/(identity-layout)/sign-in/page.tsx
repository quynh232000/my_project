'use client';
import { IconCheck } from '@/assets/Icons/outline';
import { IconEyeHidden } from '@/assets/Icons/outline/IconEyeHidden';
import { LoadingSpinner } from '@/assets/Icons/outline/LoadingSpinner';
import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import {
	AuthRouters,
	DashboardRouter,
	PropertySelectRouters,
} from '@/constants/routers';
import { signInSchema, SignInSchema } from '@/lib/schemas/auth/sign-in';
import { cn } from '@/lib/utils';
import { ILogin } from '@/services/auth/login';
import { useUserInformationStore } from '@/store/user-information/store';
import { GlobalUI } from '@/themes/type';
import { zodResolver } from '@hookform/resolvers/zod';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { useCallback, useEffect, useState } from 'react';
import { FormProvider, useForm } from 'react-hook-form';
import { toast } from 'sonner';

export default function Page() {
	const [showPassword, setShowPassword] = useState(false);
	const [loading, setLoading] = useState<boolean>(false);
	const setUserInformationState = useUserInformationStore(
		(state) => state.setUserInformationState
	);

	const router = useRouter();

	const methods = useForm<SignInSchema>({
		resolver: zodResolver(signInSchema),
		defaultValues: {
			email: '',
			password: '',
			remember: false,
		},
		mode: 'onChange',
	});

	const {
		handleSubmit,
		control,
		formState: { isValid, errors },
		setError,
	} = methods;

	useEffect(() => {
		const token = localStorage.getItem('access_token');
		if (token) {
			router.push(DashboardRouter.profile);
		}
	}, [router]);

	const onSubmit = useCallback(
		async (body: SignInSchema) => {
			if (loading) return;

			setLoading(true);
			try {
				const res = await fetch('/api/auth/login', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify(body),
				});

				if (res.ok) {
					const result = (await res.json()) as ILogin;
					setUserInformationState(result.data);
					router.push(PropertySelectRouters.index);
				} else {
					const result = await res.json();
					Object.keys(result.errors).forEach((key) =>
						setError(key as keyof SignInSchema, {
							message: result.errors[key][0],
						})
					);
					toast.error(result.message);
				}
			} catch (error) {
				toast.error('Đã có lỗi xảy ra. Xin vui lòng thử lại sau.');
			} finally {
				setLoading(false);
			}
		},
		[loading, router, setError, setUserInformationState]
	);

	const togglePassword = () => {
		setShowPassword((prev) => !prev);
	};

	return (
		<FormProvider {...methods}>
			<form onSubmit={handleSubmit(onSubmit)} className="w-full max-w-md">
				<div className="space-y-8 p-5 lg:p-0">
					<Typography
						tag="h2"
						className="text-center"
						variant="headline_28px_700">
						Đăng nhập
					</Typography>
					<div>
						<FormField
							name="email"
							control={control}
							render={({ field: { value, onChange, ...fieldProps } }) => (
								<FormItem className="mb-6">
									<FormLabel required>Email</FormLabel>
									<FormControl>
										<Input
											type="email"
											autoComplete="email"
											placeholder="Nhập email đã đăng ký"
											{...fieldProps}
											value={value}
											onChange={onChange}
											className={errors.email ? 'border-red-400' : ''}
											endAdornment={
												isValid ? (
													<IconCheck
														className="size-6"
														color={GlobalUI.colors.accent['2']}
													/>
												) : undefined
											}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>

						<FormField
							name="password"
							control={control}
							render={({ field: { value, onChange, ...fieldProps } }) => (
								<FormItem className="mb-6">
									<FormLabel required>Mật khẩu</FormLabel>
									<FormControl>
										<Input
											type={showPassword ? 'text' : 'password'}
											autoComplete="current-password"
											placeholder="Nhập mật khẩu"
											{...fieldProps}
											value={value}
											onChange={onChange}
											className={errors.password ? 'border-red-400' : ''}
											endAdornment={
												<IconEyeHidden
													className="cursor-pointer"
													onClick={togglePassword}
												/>
											}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>

						<div className="mt-6 flex items-center justify-between">
							<FormField
								name="remember"
								control={control}
								render={({ field: { value, onChange } }) => (
									<FormItem className="flex items-center gap-2">
										<FormControl>
											<CheckBoxView
												id="check-box"
												defaultValue={value}
												onValueChange={onChange}>
												<Typography tag="p" variant="caption_14px_400">
													Nhớ tài khoản
												</Typography>
											</CheckBoxView>
										</FormControl>
									</FormItem>
								)}
							/>
							<Link
								href={AuthRouters.forgotPassword}
								className={cn(
									'text-neutral-400',
									TextVariants.caption_14px_500
								)}>
								Quên mật khẩu?
							</Link>
						</div>
						<button
							type="submit"
							className={cn(
								'mt-8 flex h-14 w-full items-center justify-center gap-3 rounded-xl bg-primary-500 px-6 py-3 text-white hover:bg-primary-600 disabled:bg-primary-50 disabled:text-primary-100',
								TextVariants.content_16px_600
							)}
							disabled={loading || !isValid}>
							{loading ? <LoadingSpinner className="animate-spin" /> : null}
							Đăng nhập
						</button>
						{/* <div
							className={cn(
								'mt-8 text-center text-neutral-400',
								TextVariants.caption_14px_500
							)}>
							Bạn chưa có tài khoản?{' '}
							<Link className="text-secondary-500" href={AuthRouters.signUp}>
								Đăng ký ngay
							</Link>
						</div> */}
					</div>
				</div>
			</form>
		</FormProvider>
	);
}
