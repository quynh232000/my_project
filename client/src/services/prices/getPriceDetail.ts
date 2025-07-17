import { CallAPI } from '@/configs/axios/axios';
import { PolicyRowValues } from '@/lib/schemas/policy/validationChildPolicy';
import {
	ECancellationPolicy,
	EExtraFee,
	EPriceSetting,
	TPriceType,
} from '@/lib/schemas/type-price/standard-price';
import { AppEndpoint } from '@/services/type';

export interface IPriceDetailAPI {
	id: number;
	hotel_id: number;
	name: string;
	rate_type: string;
	policy_cancel_id: number | null;
	date_min: number;
	date_max: number;
	night_min: number;
	night_max: number;
	status: string;
	created_at: string;
	room_type: {
		room_id: number;
		price_type_id: number;
	}[];
	policy_children: PolicyRowValues[];
}

export const getPriceDetail = async (
	id: number,
	hotel_id: number
): Promise<TPriceType | null> => {
	try {
		const { data } = await CallAPI().get(
			`${AppEndpoint.PRICE_TYPE}/${id}`,
			{
				params: {
					hotel_id,
				},
			}
		);
		if (!data || !data?.data) {
			return Promise.reject(null);
		}
		const detailData: IPriceDetailAPI = data?.data;
		const { policy_cancel_id, policy_children, room_type, ...rest } =
			detailData;
		return Promise.resolve(
			detailData
				? {
						...rest,
						priceSetting: EPriceSetting.new,
						cancellationPolicy: {
							type: !!policy_cancel_id
								? ECancellationPolicy.custom
								: ECancellationPolicy.general,
							policy_cancel_id: !!policy_cancel_id
								? policy_cancel_id
								: undefined,
						},
						extraChildFeeType:
							policy_children?.length > 0
								? EExtraFee.charged
								: EExtraFee.free,
						policy:
							policy_children?.length > 0
								? {
										ageLimit:
											policy_children?.[
												policy_children?.length - 1
											]?.age_to,
										rows: policy_children,
									}
								: undefined,
						room_ids: room_type.map((type) => type.room_id),
					}
				: null
		);
	} catch (error) {
		console.error('getPriceDetail', error);
		return Promise.reject(error);
	}
};
