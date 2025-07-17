import DashboardTable, { TCellType } from '@/components/shared/DashboardTable';
import { PaymentInformationItemDialog } from './common/PaymentInformationItemDialog';
import { useEffect, useState } from 'react';
import { useBankListStore } from '@/store/banks/store';
import { useLoadingStore } from '@/store/loading/store';
import { useAccommodationProfileStore } from '@/store/accommodation-profile/store';
import { useShallow } from 'zustand/react/shallow';
import {
	EPaymentInformationStatus,
	EPaymentInformationType,
	PaymentInformationForm,
} from '@/lib/schemas/property-profile/payment-information';
import Typography from '@/components/shared/Typography';
import { IconVerified, IconExclamationTriangle } from '@/assets/Icons/filled';
import { OptionType } from '@/components/shared/Select/SelectPopup';

const filterData: OptionType[] = [
	{
		label: 'Tất cả',
		value: 'all',
	},
	{
		value: 'verified',
		label: 'Đã xác thực',
	},
];

export default function PaymentInformation() {
	const [dialog, setDialog] = useState<{
		isOpen: boolean;
		data?: PaymentInformationForm;
	}>({
		isOpen: false,
		data: undefined,
	});
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { paymentInfo, fetchPaymentInfo } = useAccommodationProfileStore(
		useShallow((state) => ({
			paymentInfo: state.paymentInfo,
			fetchPaymentInfo: state.fetchPaymentInfo,
		}))
	);
	const { bankList, fetchBankList } = useBankListStore(
		useShallow((state) => ({
			bankList: state.bankList,
			fetchBankList: state.fetchBankList,
		}))
	);

	useEffect(() => {
		setLoading(true);
		const fetchData = async () => {
			try {
				await Promise.all([fetchBankList(), fetchPaymentInfo()]);
			} finally {
				setLoading(false);
			}
		};
		fetchData();
	}, [fetchBankList, fetchPaymentInfo, setLoading]);

	const renderBank = (bank: TCellType) => {
		const bankId = bank as number;
		const bankObj = bankList?.find((bank) => bank.id === bankId);
		return (
			<Typography
				variant={'caption_14px_400'}
				className={'text-neutral-600'}>
				{bankObj?.name ?? ''}
			</Typography>
		);
	};

	const renderType = (type: TCellType) => {
		return (
			<Typography
				variant={'caption_14px_400'}
				className={'text-neutral-600'}>
				{(type as EPaymentInformationType) ===
				EPaymentInformationType.BUSINESS
					? 'Doanh nghiệp'
					: 'Cá nhân'}
			</Typography>
		);
	};

	const renderStatus = (status: TCellType) => {
		const verified =
			(status as EPaymentInformationStatus) ===
			EPaymentInformationStatus.VERIFIED;
		return (
			<Typography
				variant={'caption_12px_600'}
				className={`flex gap-1 ${
					verified ? 'text-accent-02' : 'text-accent-03'
				}`}>
				{verified ? (
					<IconVerified className="size-4 shrink-0" />
				) : (
					<IconExclamationTriangle className="size-4 shrink-0" />
				)}
				{verified ? 'Đã xác thực' : 'Chưa xác thực'}
			</Typography>
		);
	};

	return (
		<>
			<DashboardTable<PaymentInformationForm & { id: number }>
				searchPlaceholder="Tìm theo tên ngân hàng, tên tài khoản, số tài khoản"
				searchInputClassName="xl:w-[500px]"
				searchContainerClassName="mb-2"
				filterPlaceholder="Trạng thái"
				filterData={filterData}
				columns={[
					{
						label: 'Ngân hàng',
						field: 'bank_id',
						sortable: true,
						renderCell: renderBank,
						style: {
							minWidth: '250px',
						},
					},
					{
						label: 'Chủ tài khoản',
						field: 'name_account',
						sortable: true,
					},
					{
						label: 'Số tài khoản',
						field: 'number',
						sortable: true,
					},
					{
						label: 'Loại tài khoản',
						field: 'type',
						sortable: true,
						renderCell: renderType,
					},
					{
						label: 'Trạng thái',
						field: 'status',
						sortable: true,
						renderCell: renderStatus,
						style: {
							minWidth: '150px',
						},
					},
				]}
				rows={
					paymentInfo
						? (paymentInfo as Array<
								Omit<PaymentInformationForm, 'id'> & {
									id: number;
								}
							>)
						: []
				}
				addButtonText="Thêm tài khoản"
				handleAdd={() => {
					setDialog({ data: undefined, isOpen: true });
				}}
				action={{
					name: 'Thiết lập',
					type: 'edit',
					handle: [
						(paymentInfo) => {
							setDialog({ data: paymentInfo, isOpen: true });
						},
					],
				}}
			/>
			<PaymentInformationItemDialog
				open={dialog.isOpen}
				data={dialog.data}
				onClose={() => {
					setDialog({ data: undefined, isOpen: false });
				}}
			/>
		</>
	);
}
