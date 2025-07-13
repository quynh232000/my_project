'use client';
import DashboardTable, {
	renderStatus,
} from '@/components/shared/DashboardTable';
import { DashboardRouter } from '@/constants/routers';
import { filterData } from '@/containers/setting-room/data';
import { toggleStatusPromotion } from '@/services/promotion/toggleStatusPromotion';
import { useLoadingStore } from '@/store/loading/store';
import { usePricesStore } from '@/store/prices/store';
import { usePromotionStore } from '@/store/promotion/store';
import { useRoomStore } from '@/store/room/store';
import { startHolyLoader } from 'holy-loader';
import { useRouter } from 'next/navigation';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';
import useQueryPaginationParams from '@/hooks/use-query-pagination-params';

export interface IPromotion {
	id: string;
	name: string;
	value: string;
	price_types: string;
	rooms: string;
	status: string;
}

const PromotionTable = () => {
	const { setParams, params } = useQueryPaginationParams();
	const router = useRouter();
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { fetchPromotionList, promotionList, setPromotionList, pagination } =
		usePromotionStore();
	const { roomList, fetchRoomList } = useRoomStore(
		useShallow((state) => ({
			roomList: state.roomList,
			fetchRoomList: state.fetchRoomList,
		}))
	);

	const { data: priceList, fetchPrices } = usePricesStore();
	const [data, setData] = useState<IPromotion[]>([]);

	const toggleStatus = async (id: string) => {
		setLoading(true);
		const res = await toggleStatusPromotion(id);
		setLoading(false);
		if (res && res.status) {
			const promotion = promotionList?.find(
				(promotion) => String(promotion.id) === id
			);
			if (promotion) {
				toast.success(
					`Cập nhật trạng thái ${promotion.name} thành công`
				);
				const newPromotionArr =
					promotionList?.map((promotion) => ({
						...promotion,
						status:
							promotion.id === +id
								? promotion.status === 'active'
									? 'inactive'
									: 'active'
								: promotion.status,
					})) || [];
				setPromotionList(newPromotionArr);
			}
		} else {
			toast.error(res?.message ?? 'Có lỗi xảy ra, vui lòng thử lại!');
		}
	};

	useEffect(() => {
		setLoading(true);
		Promise.all([fetchRoomList(), fetchPrices()]).finally(() =>
			setLoading(false)
		);
	}, []);

	useEffect(() => {
		if (params && Object.keys(params).length > 0) {
			setLoading(true);
			fetchPromotionList({ force: true, query: params }).finally(() =>
				setLoading(false)
			);
		}
	}, [params]);

	useEffect(() => {
		if (promotionList) {
			setData(
				promotionList.map((promotion) => ({
					id: String(promotion.id),
					name: promotion.name,
					value:
						typeof promotion.value === 'number'
							? `${String(promotion.value)}%`
							: 'Cụ thể theo ngày',
					status: promotion.status,
					price_types:
						promotion.price_types.length === priceList?.length
							? 'Tất cả'
							: `${promotion.price_types[0]?.name} ${promotion.price_types?.length > 1 ? '(+' + (promotion.price_types?.length - 1) + ')' : ''}`,
					rooms:
						promotion.rooms.length === roomList?.length
							? 'Tất cả'
							: `${promotion.rooms[0]?.name} ${promotion.rooms?.length > 1 ? '(+' + (promotion.rooms?.length - 1) + ')' : ''}`,
				}))
			);
		}
	}, [promotionList, priceList, roomList]);

	return (
		<DashboardTable<IPromotion>
			params={params}
			meta={pagination}
			onSortModelChange={({ direction, column }) => {
				setParams({
					...params,
					direction,
					column,
				});
			}}
			onPaginationModelChange={({ page, limit }) => {
				setParams({
					...params,
					page,
					limit,
				});
			}}
			onFilterModelChange={({ search, status }) => {
				setParams({
					...params,
					search: search ? search : undefined,
					status: status && status !== 'all' ? status : undefined,
					page: 1,
				});
			}}
			searchPlaceholder={'Tìm kiếm theo tên/mã khuyến mãi'}
			filterPlaceholder={'Trạng thái'}
			addButtonText={'Thêm khuyến mãi'}
			handleAdd={() => router.push(DashboardRouter.promotionCreate)}
			filterData={filterData}
			fieldSearch={['name', 'id']}
			columns={[
				{ label: 'Tên khuyến mãi', field: 'name', sortable: true },
				{ label: 'Giảm giá', field: 'value', sortable: true },
				{
					label: 'Loại giá áp dụng',
					field: 'price_types',
					sortable: false,
				},
				{
					label: 'Loại phòng áp dụng',
					field: 'rooms',
					sortable: false,
				},
				{
					label: 'Trạng thái',
					field: 'status',
					renderCell: (status, row) =>
						renderStatus(status, row, {
							onToggleStatus: () => toggleStatus(row.id),
						}),
					sortable: true,
				},
			]}
			rows={data}
			action={{
				name: 'Thiết lập',
				type: 'edit',
				handle: [
					(promotion) => {
						startHolyLoader();
						setLoading(true);
						router.push(
							`${DashboardRouter.promotion}/${promotion.id}`
						);
					},
				],
			}}
		/>
	);
};

export default PromotionTable;
