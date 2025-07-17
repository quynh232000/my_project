'use client';
import DashboardTable, {
	renderStatus,
	TCellType,
} from '@/components/shared/DashboardTable';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Button } from '@/components/ui/button';
import {
	Dialog,
	DialogClose,
	DialogContent,
	DialogDescription,
	DialogFooter,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import { DashboardRouter } from '@/constants/routers';
import { filterData } from '@/containers/setting-room/data';
import { TPriceType } from '@/lib/schemas/type-price/standard-price';
import { deletePrice } from '@/services/prices/deletePrice';
import { useCancelPolicyStore } from '@/store/cancel-policy/store';
import { useLoadingStore } from '@/store/loading/store';
import { usePricesStore } from '@/store/prices/store';
import { startHolyLoader } from 'holy-loader';
import { useRouter } from 'next/navigation';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';

const renderAuthor = (user: TCellType) => {
	const author = user as {
		full_name: string;
		id: string;
	};
	return (
		<Typography variant={'caption_14px_400'} className={'text-neutral-600'}>
			{author?.full_name ?? ''}
		</Typography>
	);
};

const PriceTable = () => {
	const router = useRouter();
	const {
		data,
		fetchPrices,
		deletePrice: deletePriceStore,
	} = usePricesStore();
	const setLoading = useLoadingStore((state) => state.setLoading);
	const setForceFetch = useCancelPolicyStore((state) => state.setForceFetch);

	const [deletePriceId, setDeletePriceId] = useState<number | null>(null);

	useEffect(() => {
		setLoading(true);
		fetchPrices().finally(() => setLoading(false));
	}, []);

	const onDeletePriceType = () => {
		if (deletePriceId) {
			setLoading(true);
			deletePrice(deletePriceId)
				.then((res) => {
					if (res.status) {
						deletePriceStore(deletePriceId);
						setDeletePriceId(null);
						setForceFetch(true);
						toast.success(`Xoá loại giá thành công`);
					} else {
						toast.error(res.message);
					}
				})
				.finally(() => setLoading(false));
		}
	};

	return (
		<>
			<DashboardTable<TPriceType & { id: number }>
				searchPlaceholder={'Tìm kiếm theo tên/mã giá'}
				filterPlaceholder={'Trạng thái'}
				addButtonText={'Thêm giá mới'}
				handleAdd={() => router.push(DashboardRouter.priceTypeCreate)}
				fieldSearch={['id', 'name']}
				filterData={filterData}
				columns={[
					{
						label: 'Tên gói giá',
						field: 'name',
						sortable: true,
						style: { minWidth: '200px' },
					},
					{ label: 'Rate type', field: 'rate_type', sortable: true },
					{
						label: 'Ngày tạo',
						field: 'created_at',
						sortable: true,
						style: { minWidth: '200px' },
					},
					{
						label: 'Tạo bởi',
						field: 'user',
						sortable: true,
						renderCell: renderAuthor,
						style: { minWidth: '200px' },
					},
					{
						label: 'Trạng thái',
						field: 'status',
						renderCell: renderStatus,
						sortable: true,
					},
				]}
				rows={
					data
						? (data as Array<
								Omit<TPriceType, 'id'> & { id: number }
							>)
						: []
				}
				action={{
					name: 'Thiết lập',
					type: 'editAndDelete',
					handle: [
						(row) => {
							startHolyLoader();
							setLoading(true);
							router.push(
								DashboardRouter.priceType + `/${row.id}`
							);
						},
						(row) => {
							setDeletePriceId(row.id);
						},
					],
				}}
			/>
			<Dialog
				open={!!deletePriceId}
				onOpenChange={() => setDeletePriceId(null)}>
				<DialogContent
					hideButtonClose={true}
					className={'gap-10 p-8 pt-[50px] sm:max-w-md'}>
					<DialogHeader>
						<DialogTitle
							className={`text-center ${TextVariants.headline_18px_700}`}>
							Xoá loại giá
						</DialogTitle>
						<DialogDescription
							className={`text-center ${TextVariants.content_16px_400}`}>
							Thao tác này sẽ xóa loại giá mà bạn đã chọn. Bạn có
							chắc chắc muốn tiếp tục?
						</DialogDescription>
					</DialogHeader>
					<DialogFooter className={'sm:justify-start'}>
						<div className={'flex w-full justify-center gap-3'}>
							<DialogClose asChild>
								<Button variant={'secondary'}>Giữ lại</Button>
							</DialogClose>
							<Button
								variant={'destructive'}
								onClick={() => {
									onDeletePriceType();
								}}
								className={'rounded-xl bg-red-400 text-white'}>
								Xóa
							</Button>
						</div>
					</DialogFooter>
				</DialogContent>
			</Dialog>
		</>
	);
};

export default PriceTable;
