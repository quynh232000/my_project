'use client';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { useAccommodationProfileStore } from '@/store/accommodation-profile/store';
import { useServiceStore } from '@/store/services/store';
import { useState } from 'react';
import { useShallow } from 'zustand/react/shallow';
import SearchAndBrowse from '@/containers/setting-room/RoomAmenities/common/SearchAndBrowse';
import SelectedUtilities from '@/containers/setting-room/RoomAmenities/common/SelectedUtilities';
import DialogResetSelect from '@/containers/setting-room/RoomAmenities/common/DialogResetSelect';
import { Form } from '@/components/ui/form';
import useAmenityForm from '@/hooks/use-amenity-form';

interface AmenitiesAndServicesProps {
	onNext: () => void;
}

export default function AmenitiesAndServices({
	onNext,
}: AmenitiesAndServicesProps) {
	const [openDialog, setOpenDialog] = useState(false);
	const { hotelServiceList, fetchHotelServiceList } = useServiceStore(
		useShallow((state) => ({
			hotelServiceList: state.hotelServiceList,
			fetchHotelServiceList: state.fetchHotelServiceList,
		}))
	);
	const { services, fetchServices, setServices } =
		useAccommodationProfileStore(
			useShallow((state) => ({
				services: state.services,
				fetchServices: state.fetchServices,
				setServices: state.setServices,
			}))
		);

	const { form, onSubmit, originalList } = useAmenityForm({
		type: 'hotel',
		fetchServices,
		services,
		setServices,
		fetchServiceList: fetchHotelServiceList,
		serviceList: hotelServiceList,
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
}
