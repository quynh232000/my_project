'use client';
import { IconClose } from '@/assets/Icons/outline';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Button } from '@/components/ui/button';
import {
	Dialog,
	DialogContent,
	DialogDescription,
	DialogFooter,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import InputPassword from '@/containers/auth/forgot-password/common/InputPassword';
import { cn } from '@/lib/utils';
import { GlobalUI } from '@/themes/type';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';

import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { roleList, userFormDefaultValues } from '@/containers/user/data';
import { UserInformationType, userSchema } from '@/lib/schemas/user/user';
import { ECustomerStatus } from '@/services/customer/getCustomerList';
import { updateCustomerDetail } from '@/services/customer/updateCustomer';
import { useCustomerStore } from '@/store/customer/store';
import { useLoadingStore } from '@/store/loading/store';
import { getClientSideCookie } from '@/utils/cookie';
import { zodResolver } from '@hookform/resolvers/zod';
import { toast } from 'sonner';

const UserFormDialog = ({
	openDialog,
	handleOpenDialog,
	userIdEdit,
	onClose,
}: {
	openDialog: boolean;
	handleOpenDialog: () => void;
	userIdEdit: number;
	onClose: () => void;
}) => {
	const hotel_id = getClientSideCookie('hotel_id');
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { fetchCustomerList, customerList } = useCustomerStore();
	const form = useForm<UserInformationType>({
		mode: 'onSubmit',
		resolver: zodResolver(userSchema),
		defaultValues: userFormDefaultValues,
	});

	useEffect(() => {
		if (userIdEdit) {
			(async () => {
				const customer = customerList.find(
					(customer) => customer.id === userIdEdit
				);
				if (customer) {
					form.reset({
						full_name: customer.full_name,
						email: customer.email,
						role: String(
							customer.hotel_customers.find(
								(role) => role.hotel_id === +(hotel_id as string)
							)?.id as number
						),
						status: customer.status,
						password: '',
						password_confirmation: '',
					});
				}
			})();
		} else {
			form.reset(userFormDefaultValues);
		}
	}, [userIdEdit, customerList, hotel_id]);

	const onSubmit = async (values: UserInformationType) => {
		setLoading(true);
		const res = await updateCustomerDetail({
			...values,
			...(userIdEdit && userIdEdit > 0 && { id: userIdEdit }),
			role:
				roleList.find((role) => String(role.value) === values.role)?.label ||
				'staff',
		});
		setLoading(false);
		if (res && res.status) {
			toast.success(`Cập nhật ${values.full_name} thành công`);
			await fetchCustomerList(true);
			onClose();
		}
	};
	return (
		<Dialog open={openDialog} onOpenChange={() => handleOpenDialog()}>
			<DialogContent
				onPointerDownOutside={() => onClose()}
				hideButtonClose={true}
				className={'rounded-2xl p-6 sm:max-w-[888px]'}>
				<DialogHeader className={'hidden'}>
					<DialogTitle></DialogTitle>
					<DialogDescription></DialogDescription>
				</DialogHeader>
				<Form {...form}>
					<form onSubmit={form.handleSubmit(onSubmit)} autoComplete="off">
						<div className={'space-y-4'}>
							<div className={'flex items-center justify-between'}>
								<h2
									className={`${TextVariants.headline_18px_700} text-neutral-700`}>
									{userIdEdit ? 'Chỉnh sửa người dùng' : 'Thêm người dùng mới'}
								</h2>
								<button
									type={'button'}
									onClick={() => onClose()}
									className={
										'flex h-8 w-8 items-center justify-center rounded-full bg-neutral-50 p-2'
									}>
									<IconClose
										width={20}
										height={20}
										color={GlobalUI.colors.neutrals['500']}
									/>
								</button>
							</div>
							<div className={'grid grid-cols-2 gap-4'}>
								<FormField
									control={form.control}
									name={'full_name'}
									render={({ field }) => (
										<FormItem className={'space-y-2'}>
											<FormLabel required={true}>Tên người dùng</FormLabel>
											<FormControl>
												<Input
													{...field}
													placeholder={'Josh Pham'}
													className={cn('h-10 py-2')}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
								<FormField
									control={form.control}
									name={'email'}
									render={({ field }) => (
										<FormItem className={'space-y-2'}>
											<FormLabel required>Email</FormLabel>
											<FormControl>
												<Input
													{...field}
													autoComplete="new-email"
													placeholder={'joshpham@gmail.com'}
													className={cn('h-10 py-2')}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
							</div>
							<div className={'grid grid-cols-2 gap-4'}>
								<FormField
									control={form.control}
									name={'password'}
									rules={{
										deps: ['password_confirmation'],
									}}
									render={({ field: { value, onChange } }) => (
										<FormItem className={'space-y-2'}>
											<FormLabel>Mật khẩu</FormLabel>
											<FormControl>
												<InputPassword
													autoComplete="new-password"
													placeholder={'Nhập mật khẩu'}
													password={value ?? ''}
													setPassword={onChange}
													className={'h-10'}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
								<FormField
									control={form.control}
									name={'password_confirmation'}
									render={({ field: { value, onChange } }) => (
										<FormItem className={'space-y-2'}>
											<FormLabel>Nhập lại mật khẩu</FormLabel>
											<FormControl>
												<InputPassword
													autoComplete="new-password"
													placeholder={'Nhập lại mật khẩu'}
													password={value ?? ''}
													setPassword={onChange}
													className={'h-10'}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
							</div>
							<div className={'grid grid-cols-2 gap-4'}>
								<FormField
									control={form.control}
									name={'role'}
									render={({ field: { value, onChange, ...fieldProps } }) => (
										<FormItem className={'space-y-2'}>
											<FormControl>
												<SelectPopup
													label={'Vai trò'}
													required={true}
													placeholder="Chọn vai trò"
													labelClassName="mb-2"
													className="h-10 rounded-lg bg-white py-2"
													controllerRenderProps={fieldProps}
													data={roleList}
													selectedValue={value}
													onChange={(val) => onChange(String(val))}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
								<FormField
									control={form.control}
									name={'status'}
									render={({ field: { value, onChange, ...fieldProps } }) => (
										<FormItem className={'space-y-2'}>
											<FormLabel required={true}>Trạng thái</FormLabel>
											<FormControl>
												<div className={'flex h-10 items-center gap-3'}>
													<Switch
														checked={value === ECustomerStatus.active}
														onCheckedChange={(checked) =>
															onChange(
																checked
																	? ECustomerStatus.active
																	: ECustomerStatus.inactive
															)
														}
														{...fieldProps}
													/>
													<Typography
														tag={'span'}
														variant={'caption_14px_400'}
														className={'text-neutral-600'}>
														Hoạt động
													</Typography>
												</div>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
							</div>
						</div>
						<DialogFooter className={'mt-6 sm:justify-end'}>
							<div className={'flex w-full justify-end gap-3'}>
								<Button
									type={'button'}
									onClick={onClose}
									className={
										'h-12 w-[193px] rounded-xl border-2 bg-white px-6 py-3 text-black'
									}>
									Huỷ
								</Button>
								<Button
									variant={'secondary'}
									type={'submit'}
									className={
										'h-12 w-[193px] rounded-xl bg-secondary-500 px-6 py-3 text-white'
									}>
									Áp dụng
								</Button>
							</div>
						</DialogFooter>
					</form>
				</Form>
			</DialogContent>
		</Dialog>
	);
};

export default UserFormDialog;
