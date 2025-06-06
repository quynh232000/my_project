'use client';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { Form } from '@/components/ui/form';
import { DashboardRouter } from '@/constants/routers';
import {
	mapPromotionDetailToPromotionConfiguration,
	mapPromotionFormToPromotionData,
} from '@/containers/promotion/helpers';
import DiscountApplication from '@/containers/promotion/PromotionForm/common/DiscountApplication';
import PromotionDuration from '@/containers/promotion/PromotionForm/common/PromotionDuration';
import PromotionName from '@/containers/promotion/PromotionForm/common/PromotionName';
import PromotionPriceType from '@/containers/promotion/PromotionForm/common/PromotionPriceType';
import PromotionRoomSelection from '@/containers/promotion/PromotionForm/common/PromotionRoomSelection';
import StackablePromotionOption from '@/containers/promotion/PromotionForm/common/StackablePromotionOption';
import {
	defaultDiscountValues,
	promotionSchema,
	PromotionType,
} from '@/lib/schemas/discount/discount';
import { createPromotion } from '@/services/promotion/createPromotion';
import { IPromotionItem } from '@/services/promotion/getPromotionList';
import { updatePromotion } from '@/services/promotion/updatePromotion';
import { useLoadingStore } from '@/store/loading/store';
import { usePricesStore } from '@/store/prices/store';
import { usePromotionStore } from '@/store/promotion/store';
import { useRoomStore } from '@/store/room/store';
import { zodResolver } from '@hookform/resolvers/zod';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { toast } from 'sonner';

interface PromotionFormProps {
	promotionDetail: IPromotionItem | null;
}

const PromotionForm = ({ promotionDetail }: PromotionFormProps) => {
	const router = useRouter();
	const fetchPromotionList = usePromotionStore(
		(state) => state.fetchPromotionList
	);
	const roomList = useRoomStore((state) => state.roomList);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { data: priceTypeList } = usePricesStore();
	const form = useForm<PromotionType>({
		resolver: zodResolver(promotionSchema),
		defaultValues: defaultDiscountValues,
	});

	useEffect(() => {
		if (promotionDetail && promotionDetail.id) {
			form.reset(
				mapPromotionDetailToPromotionConfiguration(
					promotionDetail,
					roomList ?? [],
					priceTypeList
				)
			);
			setLoading(false);
		}
	}, [promotionDetail, roomList, priceTypeList]);

	const onSubmit = async (values: PromotionType) => {
		const data = mapPromotionFormToPromotionData({
			values,
			promotionDetail,
			roomList: roomList ?? [],
			priceTypeList,
		});
		try {
			setLoading(true);
			const res =
				promotionDetail && promotionDetail.id > 0
					? await updatePromotion(data)
					: await createPromotion(data);
			if (res && res.status) {
				toast.success(
					promotionDetail && promotionDetail.id > 0
						? `Cập nhật ${data.name} thành công`
						: `Thêm ${data.name} thành công`
				);
				res?.id &&
					router.replace(`${DashboardRouter.promotion}/${res.id}`, {
						scroll: false,
					});
				await fetchPromotionList(true);
			} else {
				toast.error('Có lỗi xảy ra, vui lòng thử lại!');
			}
			setLoading(false);
		} catch (err) {
			console.error(err);
		}
	};

	return (
		<Form {...form}>
			<form onSubmit={form.handleSubmit(onSubmit)}>
				<div className={'space-y-4'}>
					<PromotionName />
					<PromotionPriceType />
					<PromotionRoomSelection />
					<DiscountApplication />
					<PromotionDuration />
					<StackablePromotionOption />
				</div>
				<ButtonActionGroup className={'mt-6'} />
			</form>
		</Form>
	);
};

export default PromotionForm;
