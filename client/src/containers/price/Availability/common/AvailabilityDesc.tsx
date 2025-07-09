'use client';
import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import Typography from '@/components/shared/Typography';
import { DateRangePicker } from '@/containers/price/common/DateRangePicker';
import { mapToLabelValue } from '@/containers/setting-room/helpers';
import { ERoomStatus } from '@/services/room/getRoomList';
import { useAvailabilityCenterStore } from '@/store/availability-center/store';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomStore } from '@/store/room/store';
import { addDays, differenceInDays, format, isBefore, parse } from 'date-fns';
import { usePathname, useSearchParams } from 'next/navigation';
import { useEffect, useState } from 'react';
import { useShallow } from 'zustand/react/shallow';

type QueryParams = Record<string, string | number | undefined>;

const AvailabilityDesc = () => {
	const pathname = usePathname();
	const searchParams = useSearchParams();

	const { roomList, fetchRoomList } = useRoomStore(
		useShallow((state) => ({
			roomList: state.roomList,
			fetchRoomList: state.fetchRoomList,
		}))
	);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const [isFetched, setIsFetched] = useState(false);

	const {
		params,
		isParsedParams,
		setParams,
		fetchListConfig,
		setIsParsedParams,
	} = useAvailabilityCenterStore();

	useEffect(() => {
		setLoading(true);
		fetchRoomList().finally(() => setLoading(false));
	}, []);

	useEffect(() => {
		if (!isFetched && params?.filterDate?.from && params?.filterDate?.to) {
			fetchAvailabilityTable();
			setIsFetched(true);
		}
	}, [params?.filterDate?.from, params?.filterDate?.to, isFetched]);

	useEffect(() => {
		if (isParsedParams) return;
		const room = searchParams.get('room');
		const start = searchParams.get('start');
		const end = searchParams.get('end');
		let startDate: Date | undefined;
		let endDate: Date | undefined;
		const occupancyPrice = searchParams.get('occupancyPrice');
		let flag = true;

		if (room) {
			if (room === 'all') {
				setParams({ room: 'all' });
			}
			if (!!roomList) {
				const roomId = +room;
				const isAvailableId = isNaN(+room)
					? 'all'
					: roomList?.find(
							(room) => room.status === ERoomStatus.active && room.id === roomId
						)?.id || 'all';
				setParams({ room: isAvailableId });
			} else {
				flag = false;
			}
		}

		setParams({ filterPrice: occupancyPrice === '1' });

		if (start) {
			const parsedDate = parse(start, 'yyyy-MM-dd', new Date());
			if (!isNaN(parsedDate.getDate())) {
				startDate = isBefore(parsedDate, new Date()) ? new Date() : parsedDate;
			}
		}
		if (end) {
			const parsedDate = parse(end, 'yyyy-MM-dd', new Date());
			if (!isNaN(parsedDate.getDate())) {
				endDate = parsedDate;
			}
		}
		if (!!startDate && !!endDate) {
			const dateDiff = differenceInDays(endDate, startDate);
			if (dateDiff > 0 && dateDiff < 6 * 30) {
				setParams({
					filterDate: {
						from: startDate,
						to: endDate,
					},
				});
			}
		} else {
			setParams({
				filterDate: {
					from: new Date(),
					to: addDays(new Date(), 31),
				},
			});
		}
		setIsParsedParams(flag);
	}, [searchParams, roomList, isParsedParams]);

	useEffect(() => {
		if (isParsedParams) {
			setSearchQuery({
				room: params.room,
				occupancyPrice: +params.filterPrice,
				start: params?.filterDate?.from
					? format(params.filterDate.from, 'yyyy-MM-dd')
					: '',
				end: params?.filterDate?.to
					? format(params.filterDate.to, 'yyyy-MM-dd')
					: '',
			});
		}
	}, [JSON.stringify(params), isParsedParams]);

	const fetchAvailabilityTable = () => {
		setLoading(true);
		fetchListConfig().finally(() => setLoading(false));
	};

	const setSearchQuery = (params: QueryParams) => {
		const current = new URLSearchParams(Array.from(searchParams.entries()));
		Object.entries(params).forEach(([key, value]) => {
			if (value === undefined || value === '') {
				current.delete(key);
			} else {
				current.set(key, value.toString());
			}
		});
		window.history.replaceState({}, '', `${pathname}?${current.toString()}`);
	};

	return (
		<div className={'mt-6 flex flex-wrap items-center gap-4'}>
			<SelectPopup
				containerClassName="w-[270px]"
				className={'h-10 rounded-lg bg-white'}
				placeholder={'Chọn loại phòng'}
				searchInput={false}
				selectedValue={String(params.room)}
				onChange={(val) => {
					setParams({
						room: val === 'all' ? val : +val,
					});
				}}
				data={[
					{ label: 'Tất cả phòng', value: 'all' },
					...mapToLabelValue(
						roomList?.filter((room) => room.status === ERoomStatus.active) ?? []
					),
				]}
			/>
			<DateRangePicker
				showSummaryAndSearch
				handleSearch={fetchAvailabilityTable}
				className="w-[367px]"
				dateRange={params.filterDate}
				disabled={{
					before: new Date(),
				}}
				onSelectDateRange={(filterDate) => {
					setParams({
						filterDate,
					});
				}}
			/>

			<CheckBoxView
				id={'price'}
				containerClassName="ml-auto"
				className={'bg-white'}
				value={params.filterPrice}
				onValueChange={(filterPrice) => {
					setParams({
						filterPrice,
					});
				}}>
				<Typography
					tag={'p'}
					variant={'caption_14px_400'}
					className={'text-neutral-600'}
					text={'Giá theo số lượng khách'}
				/>
			</CheckBoxView>
		</div>
	);
};

export default AvailabilityDesc;
