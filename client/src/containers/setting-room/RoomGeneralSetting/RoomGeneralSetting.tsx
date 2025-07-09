import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { Form } from '@/components/ui/form';
import { DashboardRouter } from '@/constants/routers';
import { mapRoomDetailToRoomConfiguration } from '@/containers/setting-room/helpers';
import RoomBedConfig from '@/containers/setting-room/RoomGeneralSetting/common/RoomBedConfig';
import RoomBreakfastPolicy from '@/containers/setting-room/RoomGeneralSetting/common/RoomBreakfastPolicy';
import RoomCapacity from '@/containers/setting-room/RoomGeneralSetting/common/RoomCapacity';
import RoomExtraBeds, {
	MAX_AGE_VALUE,
} from '@/containers/setting-room/RoomGeneralSetting/common/RoomExtraBeds';
import RoomPricing from '@/containers/setting-room/RoomGeneralSetting/common/RoomPricing';
import RoomSetup from '@/containers/setting-room/RoomGeneralSetting/common/RoomSetup';
import RoomSmokingPolicy from '@/containers/setting-room/RoomGeneralSetting/common/RoomSmokingPolicy';
import {
	FeeExtraBedType,
	initialRoomConfiguration,
	RoomConfiguration,
	RoomConfigurationSchema,
} from '@/lib/schemas/setting-room/general-setting';
import { createRoom } from '@/services/room/createRoom';
import { updateRoomDetail } from '@/services/room/updateRoomDetail';
import { useAttributeStore } from '@/store/attributes/store';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomDetailStore } from '@/store/room-detail/store';
import { useRoomStore } from '@/store/room/store';
import { zodResolver } from '@hookform/resolvers/zod';
import omit from 'lodash/omit';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

interface RoomGeneralSettingProps {
	onNext: () => void;
}

export default function RoomGeneralSetting({
	onNext,
}: RoomGeneralSettingProps) {
	const router = useRouter();
	const setLoading = useLoadingStore((state) => state.setLoading);
	const roomDetail = useRoomDetailStore((state) => state.roomDetail);
	const setNeedFetch = useRoomStore((state) => state.setNeedFetch);

	const {
		fetchBedTypeList,
		fetchDirectionList,
		fetchRoomTypeList,
		roomTypeList,
	} = useAttributeStore(
		useShallow((state) => ({
			fetchBedTypeList: state.fetchBedTypeList,
			fetchDirectionList: state.fetchDirectionList,
			fetchRoomTypeList: state.fetchRoomTypeList,
			roomTypeList: state.roomTypeList,
		}))
	);
	useEffect(() => {
		setLoading(true);
		Promise.all([
			fetchBedTypeList(),
			fetchDirectionList(),
			fetchRoomTypeList(),
		]).finally(() => setLoading(false));
	}, []);

	const form = useForm<RoomConfiguration>({
		resolver: zodResolver(RoomConfigurationSchema),
		defaultValues: roomDetail?.id
			? mapRoomDetailToRoomConfiguration(roomDetail)
			: initialRoomConfiguration,
		mode: 'onChange',
	});

	const onSubmit = async (value: RoomConfiguration) => {
		setLoading(true);
		const extraBedInfo = omit(
			{
				...value.extras,
				fe_extra_beds: value.extras.extra_beds.map((item) => ({
					...item,
					age_to: item.age_to === Number(MAX_AGE_VALUE) ? null : item.age_to,
				})),
				update_fe_extra_beds: {} as {
					[key: string]: FeeExtraBedType;
				},
				delete_fe_extra_beds: [] as number[],
			},
			['hasExtraBed', 'extra_beds']
		);
		const formValue = {
			...omit(value.setup, ['name']),
			...omit(value.bedInfo, ['hasAlternativeBed']),
			...value.capacity,
			...extraBedInfo,
			...value.pricing,
		};
		let data = {
			...formValue,
			name_custom: value.setup.name,
			status: formValue.status ? 'active' : 'inactive',
			allow_extra_guests: formValue.allow_extra_guests === 'both' ? 1 : 0,
			max_capacity:
				formValue.allow_extra_guests === 'both'
					? value.capacity.max_capacity
					: Math.max(
							value.capacity.standard_guests +
								value.capacity.max_extra_children,
							value.capacity.standard_guests + value.capacity.max_extra_adults
						),
			smoking: Number(formValue.smoking),
			breakfast: Number(formValue.breakfast),
		};
		if (roomDetail?.id > 0) {
			const oldExtraBed = roomDetail?.extra_beds;
			const newExtraBed = data.fe_extra_beds;
			const deleteCount = oldExtraBed.length - newExtraBed.length;
			const idsDelete: number[] =
				deleteCount > 0
					? oldExtraBed.slice(-deleteCount).map((item) => item.id)
					: [];
			const idsUpdate: number[] = oldExtraBed
				.filter((bed) => !idsDelete.includes(bed.id))
				.map((bed) => bed.id);
			const update_fe_extra_beds = idsUpdate.reduce(
				(acc, id, index) => {
					acc[id] = newExtraBed[index];
					return acc;
				},
				{} as { [key: string]: FeeExtraBedType }
			);
			const remainingNewBeds = newExtraBed.slice(oldExtraBed.length);
			data = {
				...data,
				update_fe_extra_beds,
				delete_fe_extra_beds: idsDelete,
				fe_extra_beds: remainingNewBeds,
			};
		}
		const res =
			roomDetail?.id > 0
				? await updateRoomDetail({ id: roomDetail?.id, ...data })
				: await createRoom({ ...data });

		if (res && res.status && roomTypeList) {
			const roomName = roomTypeList
				.find((roomType) => +roomType.id === data.type_id)
				?.room_names.find((item) => +item.id === data.name_id)?.name;
			toast.success(
				roomDetail?.id > 0
					? `Cập nhật phòng ${data.name_custom ? data.name_custom : roomName} thành công`
					: 'Thêm phòng mới thành công'
			);
			setNeedFetch(true);
			roomDetail?.id === 0 &&
				res.id &&
				router.replace(`${DashboardRouter.room}/${res.id}?tab=general`);
			window.scrollTo({ top: 0, behavior: 'smooth' });
		} else {
			toast.error(res?.message ?? 'Có lỗi xảy ra, vui lòng thử lại!');
		}
		setLoading(false);
	};

	useEffect(() => {
		if (roomDetail?.id > 0) {
			form.reset(mapRoomDetailToRoomConfiguration(roomDetail));
		}
	}, [roomDetail]);

	return (
		<Form {...form}>
			<form className="mt-4" onSubmit={form.handleSubmit(onSubmit)}>
				<RoomSetup />
				<RoomCapacity />
				<RoomBedConfig />
				<RoomPricing />
				<RoomBreakfastPolicy />
				<RoomSmokingPolicy />
				<RoomExtraBeds />
				<ButtonActionGroup actionCancel={onNext} />
			</form>
		</Form>
	);
}
