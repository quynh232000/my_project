'use client';
import DashboardTable from '@/components/shared/DashboardTable';
import { DateRangePicker } from '@/containers/price/common/DateRangePicker';
import {
	mapPriceHistory,
	TPriceHistory,
} from '@/containers/price/history/data';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomStore } from '@/store/room/store';
import { addDays } from 'date-fns';
import { useEffect, useState } from 'react';
import { useShallow } from 'zustand/react/shallow';

const PriceTable = () => {
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { priceHistoryList, fetchPriceHistory } = useRoomStore(
		useShallow((state) => ({
			priceHistoryList: state.priceHistoryList,
			fetchPriceHistory: state.fetchPriceHistory,
		}))
	);
	const [priceHistory, setPriceHistory] = useState<TPriceHistory[]>([]);
	const [date, setDate] = useState<{
		from: Date | undefined;
		to: Date | undefined;
	}>({
		from: new Date(),
		to: addDays(new Date(), 7),
	});

	useEffect(() => {
		setLoading(true);
		fetchPriceHistory().finally(() => setLoading(false));
	}, []);

	useEffect(() => {
		if (priceHistoryList.length > 0) {
			setPriceHistory(mapPriceHistory(priceHistoryList));
		}
	}, [priceHistoryList]);

	return (
		<>
			<DashboardTable<TPriceHistory & { id: number }>
				customAction={
					<DateRangePicker
						className={'min-w-[367px]'}
						dateRange={{
							from: date.from,
							to: date.to,
						}}
						onSelectDateRange={(value) => {
							if (value)
								setDate({
									from: value.from,
									to: value.to,
								});
						}}
					/>
				}
				searchInputClassName={'flex-1 md:w-full'}
				searchPlaceholder={'Tên phòng/Tên người chỉnh sửa'}
				addButtonText={'Tìm kiếm'}
				handleAdd={() => {}}
				fieldSearch={['created_by', 'room_name']}
				filterPlaceholder={''}
				filterData={[]}
				columns={[
					{
						label: 'Phòng',
						field: 'room_name',
						sortable: true,
					},
					{
						label: 'Giá cũ(VND)',
						field: 'old_price',
						sortable: true,
					},
					{
						label: 'Giá mới(VND)',
						field: 'new_price',
						sortable: true,
					},
					{
						label: 'Thời gian áp dụng',
						field: 'apply_date',
					},
					{ label: 'Loại giá', field: 'type_price', sortable: true },
					{
						label: 'Người chỉnh sửa',
						field: 'created_by',
						sortable: true,
					},
					{
						label: 'Ngày chỉnh sửa',
						field: 'updated_date',
						sortable: true,
					},
				]}
				rows={
					priceHistory
						? (priceHistory as Array<
								Omit<TPriceHistory, 'id'> & { id: number }
							>)
						: []
				}
				action={{
					name: 'Chi tiết',
					type: 'detail',
					handle: [(row) => console.log(row)],
				}}
			/>
		</>
	);
};

export default PriceTable;
