'use client';
import { useCallback, useEffect, useState } from 'react';
import { IService } from '@/services/service/getServices';
import { useForm } from 'react-hook-form';
import {
	AmenityType,
	RoomAmenitiesType,
} from '@/containers/setting-room/RoomAmenities/data';
import { useLoadingStore } from '@/store/loading/store';
import { updateHotelServices } from '@/services/accommodation/updateHotelService';
import { toast } from 'sonner';

type Props = {
	type: 'hotel' | 'room';
	pointId?: number;
	serviceList: IService[];
	fetchServiceList: () => Promise<void>;
	services: IService[] | undefined;
	fetchServices: () => Promise<void>;
	setServices: (services: IService[]) => void;
};

const useAmenityForm = ({
	type,
	pointId,
	serviceList,
	setServices,
	fetchServiceList,
	fetchServices,
	services,
}: Props) => {
	const form = useForm<RoomAmenitiesType>();
	const [originalList, setOriginalList] = useState<AmenityType[]>([]);
	const setLoading = useLoadingStore((state) => state.setLoading);

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
		Promise.all([fetchServiceList(), fetchServices()]).finally(() =>
			setLoading(false)
		);
	}, []);

	useEffect(() => {
		if (serviceList.length) {
			const amenities = mapAmenitiesToObject(serviceList);
			setOriginalList(amenities);
		}
	}, [serviceList]);

	useEffect(() => {
		if (!!services) {
			const defaultValue = services.reduce(
				(acc, group) => {
					if (group?.id && Array.isArray(group?.children)) {
						acc[group.id] = group.children.map((child) =>
							String(child.id)
						);
					}
					return acc;
				},
				{} as Record<string, string[]>
			);
			form.reset(defaultValue);
		}
	}, [services]);

	const onSubmit = async (data: RoomAmenitiesType) => {
		try {
			setLoading(true);
			const ids = Object.values(data)
				.flat()
				.map((id) => Number(id));

			const res = await updateHotelServices({
				type,
				ids,
				...(type === 'room' ? { point_id: String(pointId) } : {}),
			});

			if (res?.status) {
				toast.success(res.message);

				const selected = serviceList.map((group) => ({
					...group,
					children: group.children.filter((c) =>
						(data[group.id] ?? []).includes(String(c.id))
					),
				}));

				setServices(selected);
			} else {
				toast.error('Có lỗi xảy ra, vui lòng thử lại!');
			}
		} catch (error) {
			console.error(error);
			toast.error('Có lỗi xảy ra, vui lòng thử lại!');
		} finally {
			setLoading(false);
		}
	};

	return { form, originalList, onSubmit };
};

export default useAmenityForm;
