import { IconVerified } from '@/assets/Icons/filled';
import { IconExclamationTriangle } from '@/assets/Icons/filled';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Checkbox } from '@/components/ui/checkbox';
import {
	Dialog,
	DialogClose,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import PhoneInput from '@/components/ui/phone-input';
import {
	EPaymentInformationStatus,
	EPaymentInformationType,
	PaymentInformationForm,
	PaymentInformationSchema,
} from '@/lib/schemas/property-profile/payment-information';
import { createPaymentInformation } from '@/services/paymentInfo/createPaymentInformation';
import { updatePaymentInformation } from '@/services/paymentInfo/updatePaymentInformation copy';
import { useAccommodationProfileStore } from '@/store/accommodation-profile/store';
import { useBankListStore } from '@/store/banks/store';
import { useLoadingStore } from '@/store/loading/store';
import { zodResolver } from '@hookform/resolvers/zod';
import { X } from 'lucide-react';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { toast } from 'sonner';

interface PaymentInformationItemDialogProps {
	open: boolean;
	data?: PaymentInformationForm;
	onClose: () => void;
}
export const PaymentInformationItemDialog = ({
	open,
	data,
	onClose,
}: PaymentInformationItemDialogProps) => {
	const form = useForm<PaymentInformationForm>({
		mode: 'onChange',
		resolver: zodResolver(PaymentInformationSchema),
	});

	const bankList = useBankListStore((state) => state.bankList);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const fetchPaymentInfo = useAccommodationProfileStore(
		(state) => state.fetchPaymentInfo
	);

	const { control, handleSubmit, watch, unregister, getValues, reset } = form;

	const [type, status, is_default] = watch(['type', 'status', 'is_default']);

	const isVerified = status === EPaymentInformationStatus.VERIFIED;

	useEffect(() => {
		if (data) {
			reset(data);
		}
	}, [data, reset]);

	const onSubmit = (data: PaymentInformationForm) => {
		setLoading(true);
		if (data.id) {
			updatePaymentInformation({
				...data,
				id: data.id,
			})
				.then(async (res) => {
					if (res.status && res.id) {
						await fetchPaymentInfo(true);
						toast.success('Cập nhật thông tin thanh toán thành công!');
						_onClose();
					} else {
						toast.error(res.message);
					}
				})
				.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
				.finally(() => setLoading(false));
		} else {
			createPaymentInformation(data)
				.then(async (res) => {
					if (res.status) {
						await fetchPaymentInfo(true);
						toast.success('Thêm thông tin thanh toán thành công!');
						_onClose();
					} else {
						toast.error(res.message);
					}
				})
				.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
				.finally(() => setLoading(false));
		}
	};

	const onUpdateDefault = () => {
		const isDefault = getValues('is_default');
		if (data?.id) {
			setLoading(true);
			updatePaymentInformation({
				id: data.id,
				is_default: isDefault ? 1 : 0,
			})
				.then(async (res) => {
					if (res.status && res.id) {
						await fetchPaymentInfo(true);
						toast.success('Cập nhật tài khoản mặc định thành công!');
						_onClose();
					} else {
						toast.error(res.message);
						reset();
					}
				})
				.catch(() => {
					toast.error('Có lỗi xảy ra, vui lòng thử lại!');
					reset();
				})
				.finally(() => setLoading(false));
		}
	};

	const _onClose = () => {
		onClose();
		reset({
			bank_id: NaN,
			bank_branch: '',
			name_account: '',
			number: '',
			type: EPaymentInformationType.PERSONAL,
		});
	};

	useEffect(() => {
		if (type === EPaymentInformationType.BUSINESS) {
			const currentState = getValues();
			reset({
				...currentState,
				name_company: data?.name_company ?? '',
				contact_person: data?.contact_person ?? '',
				address: data?.address ?? '',
				tax_code: data?.tax_code ?? '',
				email: data?.email ?? '',
				phone: data?.phone ?? '+84',
			});
		} else {
			unregister([
				'name_company',
				'contact_person',
				'address',
				'tax_code',
				'email',
				'phone',
			]);
		}
	}, [type, data]);

	return (
		<Dialog open={open} onOpenChange={(val) => !val && _onClose()}>
			<DialogContent
				hideButtonClose={true}
				className={'max-h-[90vh] max-w-[888px] gap-4 overflow-auto p-6'}>
				<DialogHeader className="flex-row items-center justify-between">
					<DialogTitle
						className={`${TextVariants.caption_18px_700} text-neutral-700`}>
						{data?.id ? 'Tài' : 'Thêm tài'} khoản thanh toán
					</DialogTitle>
					<DialogDescription></DialogDescription>
					<DialogClose>
						<X className="h-5 w-5" />
					</DialogClose>
				</DialogHeader>
				<Form {...form}>
					<form
						className="flex flex-col gap-6"
						onSubmit={handleSubmit(onSubmit)}>
						<div className={'grid grid-cols-2 gap-4'}>
							<FormField
								control={control}
								name={'bank_id'}
								render={({ field: { value, onChange, ...props } }) => (
									<FormItem>
										<FormLabel required>Ngân hàng</FormLabel>
										<FormControl>
											<SelectPopup
												disabled={isVerified}
												className="h-[44px] rounded-lg bg-white py-2"
												labelClassName="mb-2"
												placeholder="Chọn ngân hàng"
												data={bankList.map((bank) => ({
													label: bank.name,
													value: bank.id,
												}))}
												controllerRenderProps={props}
												selectedValue={value}
												onChange={onChange}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
							<FormField
								name={'bank_branch'}
								control={control}
								render={({ field }) => (
									<FormItem>
										<FormLabel>Chi nhánh ngân hàng</FormLabel>
										<FormControl>
											<Input
												disabled={isVerified}
												type="text"
												placeholder="Nhập tên chi nhánh ngân hàng"
												className={'h-[44px] py-2 leading-6'}
												{...field}
												value={field.value ?? ''}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
							<FormField
								name={'name_account'}
								control={control}
								render={({ field }) => (
									<FormItem>
										<FormLabel required>Tên tài khoản</FormLabel>
										<FormControl>
											<Input
												disabled={isVerified}
												type="text"
												placeholder="Nhập tên tài khoản"
												className={'h-[44px] py-2 leading-6'}
												{...field}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
							<FormField
								name={'number'}
								control={control}
								render={({ field }) => (
									<FormItem>
										<FormLabel required>Số tài khoản</FormLabel>
										<FormControl>
											<Input
												disabled={isVerified}
												type="text"
												placeholder="Nhập số tài khoản"
												className={'h-[44px] py-2 leading-6'}
												{...field}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
							<FormField
								control={control}
								name={'type'}
								render={({ field: { value, onChange, ...props } }) => (
									<FormItem>
										<FormLabel required>Loại tài khoản</FormLabel>
										<FormControl>
											<SelectPopup
												disabled={isVerified}
												className="h-[44px] rounded-lg bg-white py-2"
												labelClassName="mb-2"
												placeholder="Chọn loại tài khoản"
												searchInput={false}
												data={[
													{
														label: 'Cá nhân',
														value: EPaymentInformationType.PERSONAL,
													},
													{
														label: 'Doanh nghiệp',
														value: EPaymentInformationType.BUSINESS,
													},
												]}
												controllerRenderProps={props}
												selectedValue={value}
												onChange={onChange}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
							<div className="space-y-2">
								<Typography variant="caption_14px_500">Trạng thái</Typography>
								<div className="flex gap-2">
									{isVerified ? (
										<IconVerified className="size-6 shrink-0" />
									) : (
										<IconExclamationTriangle className="size-6 shrink-0" />
									)}
									<div>
										<Typography
											variant="caption_14px_600"
											text={
												isVerified
													? 'Tài khoản này đã được xác thực'
													: 'Tài khoản này chưa được xác thực'
											}
											className={`${
												isVerified ? 'text-accent-02' : 'text-accent-03'
											}`}
										/>
										{!isVerified && (
											<Typography
												variant="caption_12px_400"
												className="text-neutral-500"
												text={
													'Chúng tôi sẽ liên hệ lại bạn để xử lý trong thời gian sớm nhất.'
												}
											/>
										)}
									</div>
								</div>
							</div>
							{isVerified && (
								<FormField
									name="is_default"
									control={form.control}
									render={({ field }) => (
										<FormItem className="mt-2 flex flex-row items-center space-x-3 space-y-0">
											<FormControl>
												<Checkbox
													disabled={!!data?.is_default}
													id={`is_default`}
													checked={!!field.value}
													onCheckedChange={(checked) => {
														field.onChange(+checked);
													}}
												/>
											</FormControl>
											<FormLabel
												htmlFor={`is_default`}
												className={`${TextVariants.caption_14px_400} ${
													!data?.is_default && 'cursor-pointer'
												} text-neutral-600`}>
												Chọn tài khoản này làm tài khoản giao dịch chính
											</FormLabel>
										</FormItem>
									)}
								/>
							)}
						</div>
						{type === EPaymentInformationType.BUSINESS && (
							<div className={'grid grid-cols-2 gap-4'}>
								<Typography
									tag={'h1'}
									text={'Thông tin xuất hóa đơn'}
									className={`${TextVariants.content_16px_600} col-span-2`}
								/>
								<FormField
									name={'name_company'}
									control={control}
									render={({ field }) => (
										<FormItem>
											<FormLabel required>Tên công ty</FormLabel>
											<FormControl>
												<Input
													disabled={isVerified}
													type="text"
													placeholder="Nhập tên công ty"
													className={'h-[44px] py-2 leading-6'}
													{...field}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
								<FormField
									name={'contact_person'}
									control={control}
									render={({ field }) => (
										<FormItem>
											<FormLabel required>Người đại diện</FormLabel>
											<FormControl>
												<Input
													disabled={isVerified}
													type="text"
													placeholder="Nhập tên người đại diện"
													className={'h-[44px] py-2 leading-6'}
													{...field}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
								<FormField
									name={'address'}
									control={control}
									render={({ field }) => (
										<FormItem>
											<FormLabel required>Địa chỉ</FormLabel>
											<FormControl>
												<Input
													disabled={isVerified}
													type="text"
													placeholder="Nhập địa chỉ"
													className={'h-[44px] py-2 leading-6'}
													{...field}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
								<FormField
									name={'tax_code'}
									control={control}
									render={({ field }) => (
										<FormItem>
											<FormLabel required>Mã số thuế</FormLabel>
											<FormControl>
												<Input
													disabled={isVerified}
													type="text"
													placeholder="Nhập mã số thuế"
													className={'h-[44px] py-2 leading-6'}
													{...field}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
								<FormField
									name={'email'}
									control={control}
									render={({ field }) => (
										<FormItem>
											<FormLabel required>Email</FormLabel>
											<FormControl>
												<Input
													disabled={isVerified}
													type="text"
													placeholder="Nhập email"
													className={'h-[44px] py-2 leading-6'}
													{...field}
												/>
											</FormControl>
											<Typography
												tag={'p'}
												text={'Dùng để nhận hóa đơn điện tử'}
												className={`${TextVariants.caption_12px_500} text-neutral-400`}
											/>
											<FormMessage />
										</FormItem>
									)}
								/>
								<FormField
									name={'phone'}
									control={control}
									render={({ field }) => (
										<FormItem>
											<FormLabel required>Số điện thoại</FormLabel>
											<FormControl>
												<PhoneInput
													disabled={isVerified}
													value={field.value ?? '+84'}
													onChange={field.onChange}
												/>
											</FormControl>
											<FormMessage />
										</FormItem>
									)}
								/>
							</div>
						)}
						<ButtonActionGroup
							btnClassName="w-[193px]"
							titleBtnConfirm="Lưu"
							titleBtnCancel="Huỷ"
							actionCancel={() => _onClose()}
							{...(isVerified && {
								disabledBtnConfirm: is_default === data?.is_default,
								actionSubmit() {
									onUpdateDefault();
								},
							})}
						/>
					</form>
				</Form>
			</DialogContent>
		</Dialog>
	);
};
