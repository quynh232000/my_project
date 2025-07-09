'use client';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { Form } from '@/components/ui/form';
import { DashboardRouter } from '@/constants/routers';
import AdultSurcharge from '@/containers/price/StandardPriceForm/common/AdultSurcharge';
import CancellationPolicy from '@/containers/price/StandardPriceForm/common/CancellationPolicy';
import PriceConfiguration from '@/containers/price/StandardPriceForm/common/PriceConfiguration';
import RateGeneralInfo from '@/containers/price/StandardPriceForm/common/RateGeneralInfo';
import RestrictionSettings from '@/containers/price/StandardPriceForm/common/RestrictionSettings';
import RoomTypeSelection from '@/containers/price/StandardPriceForm/common/RoomTypeSelection';
import {
	defaultStandardPriceData,
	StandardPriceSchema,
	TPriceType,
} from '@/lib/schemas/type-price/standard-price';
import { createUpdatePrice } from '@/services/prices/createUpdatePrice';
import { useCancelPolicyStore } from '@/store/cancel-policy/store';
import { useLoadingStore } from '@/store/loading/store';
import { usePricesStore } from '@/store/prices/store';
import { useRoomStore } from '@/store/room/store';
import { useUserInformationStore } from '@/store/user-information/store';
import { zodResolver } from '@hookform/resolvers/zod';
import { format } from 'date-fns';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

interface StandardPriceFormProps {
	priceItem: TPriceType | null;
}

export default function StandardPriceForm({
	priceItem,
}: StandardPriceFormProps) {
	const router = useRouter();

	const form = useForm<TPriceType>({
		mode: 'onChange',
		resolver: zodResolver(StandardPriceSchema),
		defaultValues: priceItem ?? defaultStandardPriceData,
	});

	const setLoading = useLoadingStore((state) => state.setLoading);
	const fetchRoomList = useRoomStore((state) => state.fetchRoomList);
	const { fetchCancelPolicy, setForceFetch } = useCancelPolicyStore(
		useShallow((state) => ({
			fetchCancelPolicy: state.fetchCancelPolicy,
			setForceFetch: state.setForceFetch,
		}))
	);
	const { fetchPrices, addUpdatePrice } = usePricesStore(
		useShallow((state) => ({
			fetchPrices: state.fetchPrices,
			addUpdatePrice: state.addUpdatePrice,
		}))
	);
	const { userInformation } = useUserInformationStore();

	useEffect(() => {
		setLoading(true);
		Promise.all([fetchCancelPolicy(), fetchPrices()]).finally(() =>
			setLoading(false)
		);
	}, []);

	const onSubmit = (value: TPriceType) => {
		setLoading(true);
		createUpdatePrice(value)
			.then(async (res) => {
				if (res.status && res.id) {
					setForceFetch(true);
					addUpdatePrice({
						...value,
						id: res.id,
						status: value.status ?? 'active',
						created_at:
							value.created_at ?? format(new Date(), 'yyyy-MM-dd HH:mm:ss'),
						user: value.user ?? {
							id: userInformation.id,
							full_name: userInformation.full_name,
						},
					});
					await fetchRoomList(true);
					!priceItem &&
						router.replace(DashboardRouter.priceType + `/${res.id}`);

					toast.success(
						`${priceItem ? `Chỉnh sửa loại giá ${value.name} thành công` : 'Thêm loại giá thành công!'}`
					);
				} else {
					toast.error(res.message);
				}
			})
			.finally(() => setLoading(false));
	};

	return (
		<Form {...form}>
			<form onSubmit={form.handleSubmit(onSubmit)}>
				<div className={'space-y-3'}>
					<RateGeneralInfo />
					<RoomTypeSelection />
					<PriceConfiguration />
					<CancellationPolicy />
					<AdultSurcharge priceItem={priceItem} />
					<RestrictionSettings />
				</div>
				<ButtonActionGroup actionCancel={() => router.back()} />
			</form>
		</Form>
	);
}
