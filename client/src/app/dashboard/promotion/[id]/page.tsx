import React from 'react';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import PromotionForm from '@/containers/promotion/PromotionForm';
import {
	DashboardRouter,
	AuthRouters,
	RefreshRouters,
} from '@/constants/routers';
import { cookies } from 'next/headers';
import { redirect } from 'next/navigation';
import { IPromotionItem } from '@/services/promotion/getPromotionList';
import { getPromotionDetail } from '@/services/promotion/getPromotionDetail';
import { AxiosError, HttpStatusCode } from 'axios';
import { TOKEN_EXPIRED_MESSAGE } from '@/configs/axios/axios';

export default async function Page({
	params,
}: {
	params: Promise<{
		id: string;
	}>;
}) {
	const cookieStore = await cookies();
	const { id } = await params;
	const { pathName } = await getFullURLServerComponent();
	const isCreate = id === 'create';
	let promotionDetail: IPromotionItem | null = null;

	if (!isCreate) {
		const hotel_id = cookieStore.get('hotel_id')?.value ?? 0;
		if (!!hotel_id) {
			try {
				promotionDetail = await getPromotionDetail({
					id: +id,
					hotel_id: +hotel_id,
				});
			} catch (error) {
				const axiosError = error as AxiosError;
				const msg = (axiosError?.response?.data as { message: string })
					?.message;
				if (
					axiosError?.response?.status === HttpStatusCode.Unauthorized
				) {
					if (msg === TOKEN_EXPIRED_MESSAGE) {
						redirect(
							`${RefreshRouters.index}?redirect=${DashboardRouter.promotion}/${id}`
						);
					} else {
						redirect(AuthRouters.signIn + '?force=true');
					}
				} else {
					redirect(DashboardRouter.promotion);
				}
			}
		} else {
			redirect(DashboardRouter.promotion);
		}
	}

	const promotionName = isCreate
		? 'Khuyến mãi'
		: (promotionDetail && promotionDetail.name) || '';

	return (
		<DashboardContainer>
			<DashboardHeroTitle
				{...(promotionDetail
					? {
							displayName: {
								[promotionDetail.id]: promotionDetail.name,
							},
						}
					: { displayName: { create: 'Khuyến mãi' } })}
				pathName={pathName}
				title={promotionName}
			/>
			<DashboardCard>
				<PromotionForm promotionDetail={promotionDetail} />
			</DashboardCard>
		</DashboardContainer>
	);
}
