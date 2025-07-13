import { Form } from '@/components/ui/form';
import { useState } from 'react';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import DialogResetSelect from '@/containers/setting-room/RoomAmenities/common/DialogResetSelect';
import SearchAndBrowse from '@/containers/setting-room/RoomAmenities/common/SearchAndBrowse';
import SelectedUtilities from '@/containers/setting-room/RoomAmenities/common/SelectedUtilities';
import { useRoomDetailStore } from '@/store/room-detail/store';
import { useServiceStore } from '@/store/services/store';
import { useShallow } from 'zustand/react/shallow';
import useAmenityForm from '@/hooks/use-amenity-form';

interface RoomAmenitiesProps {
	onNext: () => void;
}

const RoomAmenities = ({ onNext }: RoomAmenitiesProps) => {
	const [openDialog, setOpenDialog] = useState(false);
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

	const { form, onSubmit, originalList } = useAmenityForm({
		type: 'room',
		fetchServices,
		services,
		setServices,
		fetchServiceList: fetchRoomServiceList,
		serviceList: roomServiceList,
		pointId: roomDetail.id,
	});

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
