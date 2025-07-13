import { IPromotionItem } from '@/services/promotion/getPromotionList';
import { PromotionType } from '@/lib/schemas/discount/discount';
import { IRoomItem } from '@/services/room/getRoomList';
import { TPriceType } from '@/lib/schemas/type-price/standard-price';
import { format } from 'date-fns';

export function mapPromotionDetailToPromotionConfiguration(
	data: IPromotionItem,
	roomList: IRoomItem[],
	priceTypeList: TPriceType[] | null
): PromotionType {
	return {
		name: data.name,
		priceType: {
			type:
				priceTypeList &&
				priceTypeList.length === data.price_types.length
					? 'all'
					: 'specific',
			price_type_ids: data.price_types?.map((item) => item.id),
		},
		roomType: {
			type:
				roomList && roomList.length === data.rooms.length
					? 'all'
					: 'specific',
			room_ids: data.rooms?.map((item) => item.id),
		},
		discountType: {
			type: data.type as 'each_nights' | 'day_of_weeks' | 'first_night',
			...(data.type === 'day_of_weeks'
				? {
						specificDaysDiscount: data.value as {
							value: number | null;
							day_of_week: number;
						}[],
					}
				: { discount: data.value as number }),
		},
		is_stackable: data.is_stackable > 0,
		discountDuration: {
			noExpiry: !data.end_date,
			start_date: new Date(data.start_date),
			end_date: data.end_date ? new Date(data.end_date) : null,
		},
	};
}

export function mapPromotionFormToPromotionData({
	values,
	promotionDetail,
	roomList,
	priceTypeList,
}: {
	values: PromotionType;
	promotionDetail: IPromotionItem | null;
	roomList: IRoomItem[];
	priceTypeList: TPriceType[] | null;
}) {
	return {
		...(promotionDetail && promotionDetail.id > 0
			? { id: promotionDetail.id }
			: undefined),
		name: values.name,
		price_type_ids:
			values.priceType.type === 'all'
				? (priceTypeList?.map((room) => room.id) as number[])
				: values.priceType.price_type_ids,
		room_ids:
			values.roomType.type === 'all'
				? roomList.map((room) => room.id)
				: values.roomType.room_ids,
		type: values.discountType.type,
		value:
			values.discountType.type === 'day_of_weeks'
				? (values.discountType.specificDaysDiscount?.filter(
						(item) => item.value !== null
					) as { value: number; day_of_week: number }[])
				: (values.discountType.discount as number),
		is_stackable: values.is_stackable,
		start_date: format(values.discountDuration.start_date, 'yyyy/MM/dd'),
		end_date: values.discountDuration.end_date
			? format(values.discountDuration.end_date, 'yyyy/MM/dd')
			: null,
	};
}
