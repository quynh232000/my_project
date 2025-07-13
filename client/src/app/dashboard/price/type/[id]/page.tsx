import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { TOKEN_EXPIRED_MESSAGE } from '@/configs/axios/axios';
import {
	AuthRouters,
	DashboardRouter,
	RefreshRouters,
} from '@/constants/routers';
import ButtonBack from '@/containers/price/common/ButtonBack';
import StandardPriceForm from '@/containers/price/StandardPriceForm';
import { TPriceType } from '@/lib/schemas/type-price/standard-price';
import { getPriceDetail } from '@/services/prices/getPriceDetail';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import { AxiosError, HttpStatusCode } from 'axios';
import { cookies } from 'next/headers';
import { redirect } from 'next/navigation';

export default async function Page({
	params,
}: {
	params: Promise<{
		id: string;
	}>;
}) {
	const { id } = await params;
	const { pathName } = await getFullURLServerComponent();
	const cookiesStore = await cookies();

	const isCreate = id === 'create';
	const hotel_id = cookiesStore.get('hotel_id');

	let priceDetail: TPriceType | null = null;

	if (!isCreate) {
		if (!!hotel_id?.value) {
			try {
				priceDetail = await getPriceDetail(+id, +hotel_id.value);
			} catch (error) {
				const axiosError = error as AxiosError;
				const msg = (axiosError?.response?.data as { message: string })
					?.message;
				if (
					axiosError?.response?.status === HttpStatusCode.Unauthorized
				) {
					if (msg === TOKEN_EXPIRED_MESSAGE) {
						return redirect(
							`${RefreshRouters.index}?redirect=${DashboardRouter.priceType}/${id}`
						);
					} else {
						return redirect(AuthRouters.signIn + '?force=true');
					}
				} else {
					redirect(DashboardRouter.priceType);
				}
			}
		} else {
			redirect(DashboardRouter.priceType);
		}
	}

	const title = isCreate
		? 'Thêm mới loại giá'
		: (priceDetail && priceDetail.name) || '';

	return (
		<DashboardContainer>
			<DashboardHeroTitle
				actionBack={<ButtonBack url={DashboardRouter.priceType} />}
				{...(priceDetail && {
					displayName: {
						[priceDetail.id as number]: priceDetail.name,
					},
				})}
				pathName={pathName}
				title={title}
			/>
			<DashboardCard className="!bg-transparent !p-0">
				<StandardPriceForm priceItem={priceDetail} />
			</DashboardCard>
		</DashboardContainer>
	);
}
