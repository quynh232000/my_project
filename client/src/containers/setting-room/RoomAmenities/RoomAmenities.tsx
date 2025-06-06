import { Form } from '@/components/ui/form';
import { useCallback, useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';

import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import DialogResetSelect from '@/containers/setting-room/RoomAmenities/common/DialogResetSelect';
import SearchAndBrowse from '@/containers/setting-room/RoomAmenities/common/SearchAndBrowse';
import SelectedUtilities from '@/containers/setting-room/RoomAmenities/common/SelectedUtilities';
import {
	AmenityType,
	RoomAmenitiesType,
} from '@/containers/setting-room/RoomAmenities/data';
import { updateHotelServices } from '@/services/accommodation/updateHotelService';
import { IService } from '@/services/service/getServices';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomDetailStore } from '@/store/room-detail/store';
import { useServiceStore } from '@/store/services/store';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

interface RoomAmenitiesProps {
	onNext: () => void;
}

const RoomAmenities = ({ onNext }: RoomAmenitiesProps) => {
	const [openDialog, setOpenDialog] = useState(false);
	const [originalList, setOriginalList] = useState<AmenityType[]>([]);
	const { roomServiceList, fetchRoomServiceList } = useServiceStore(
		useShallow((state) => ({
			roomServiceList: state.roomServiceList,
			fetchRoomServiceList: state.fetchRoomServiceList,
		}))
	);
	const { roomDetail, fetchServices, services, setServices } =
		useRoomDetailStore(
			useShallow((state) => ({
				roomDetail: state.roomDetail,
				fetchServices: state.fetchServices,
				services: state.services,
				setServices: state.setServices,
			}))
		);
	const setLoading = useLoadingStore((state) => state.setLoading);

	const form = useForm<RoomAmenitiesType>();

	const mapAmenitiesToObject = useCallback(
		(data: IService[]): AmenityType[] => {
			return data.reduce<AmenityType[]>((acc, item) => {
				acc.push({
					id: item.id,
					title: item.name,
					children: item.children.map((child) => ({
						name: child.name,
						id: child.id,
					})),
				});
				return acc;
			}, []);
		},
		[]
	);

	useEffect(() => {
		setLoading(true);
		Promise.all([fetchRoomServiceList(), fetchServices()]).finally(() =>
			setLoading(false)
		);
	}, []);

	useEffect(() => {
		if (roomServiceList.length) {
			const amenities = mapAmenitiesToObject(roomServiceList);
			setOriginalList(amenities);
		}
	}, [roomServiceList]);

	useEffect(() => {
		if (!!services) {
			const defaultValue = services.reduce(
				(acc, group) => {
					if (group?.id && Array.isArray(group?.children)) {
						acc[group.id] = group.children.map((child) => String(child.id));
					}
					return acc;
				},
				{} as Record<string, string[]>
			);
			form.reset(defaultValue);
		}
	}, [services]);

	const onSubmit = (values: RoomAmenitiesType) => {
		const amenities = Object.values(values)
			.filter((amenitiesParent) => Array.isArray(amenitiesParent))
			.flat()
			.map((item) => Number(item));
		if (roomDetail?.id > 0) {
			(async () => {
				setLoading(true);
				const res = await updateHotelServices({
					type: 'room',
					ids: amenities,
					point_id: String(roomDetail?.id),
				});
				if (res && res.status) {
					toast.success(res.message);
					const selectedService: IService[] =
						roomServiceList?.map((serviceGroup) => ({
							...serviceGroup,
							children:
								serviceGroup?.children?.filter((item) =>
									(values?.[`${serviceGroup.id}`] ?? []).includes(
										String(item.id)
									)
								) ?? [],
						})) ?? [];
					setServices(selectedService);
				} else {
					toast.error('Có lỗi xảy ra, vui lòng thử lại!');
				}
				setLoading(false);
			})();
		}
	};

	return (
		<Form {...form}>
			<form onSubmit={form.handleSubmit(onSubmit)}>
				<div
					className={
						'mt-6 grid grid-cols-1 items-stretch gap-4 overflow-hidden lg:grid-cols-[404px_,1fr]'
					}>
					<SearchAndBrowse originalList={originalList} />
					<SelectedUtilities
						onOpenDialog={() => setOpenDialog(true)}
						originalList={originalList}
					/>
				</div>
				<ButtonActionGroup actionCancel={onNext} />
				<DialogResetSelect
					originalList={originalList}
					onClose={() => setOpenDialog(false)}
					open={openDialog}
				/>
			</form>
		</Form>
	);
};

export default RoomAmenities;
