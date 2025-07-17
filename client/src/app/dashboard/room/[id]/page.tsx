import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import LoadingView from '@/components/shared/Loading/LoadingView';
import { TOKEN_EXPIRED_MESSAGE } from '@/configs/axios/axios';
import {
	AuthRouters,
	DashboardRouter,
	RefreshRouters,
} from '@/constants/routers';
import SettingRoom from '@/containers/setting-room/SettingRoom';
import { getRoomDetail, IRoomDetail } from '@/services/room/getRoomDetail';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import { AxiosError, HttpStatusCode } from 'axios';
import { cookies } from 'next/headers';
import { redirect } from 'next/navigation';

export default async function Page({
	params,
}: {
	params: Promise<{ id: string }>;
}) {
	const cookieStore = await cookies();
	const { id } = await params;
	const { pathName } = await getFullURLServerComponent();
	const isCreate = id === 'create';
	let roomDetail: IRoomDetail | null = null;

	if (!isCreate) {
		const hotel_id = cookieStore.get('hotel_id')?.value ?? 0;
		if (!!hotel_id) {
			try {
				roomDetail = await getRoomDetail({
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
							`${RefreshRouters.index}?redirect=${DashboardRouter.room}/${id}`
						);
					} else {
						redirect(AuthRouters.signIn + '?force=true');
					}
				} else {
					redirect(DashboardRouter.room);
				}
			}
		} else {
			redirect(DashboardRouter.room);
		}
	}
	const roomName = isCreate
		? 'Tạo phòng mới'
		: (roomDetail && roomDetail.name) || '';

	return (
		<DashboardContainer>
			<DashboardHeroTitle
				{...(roomDetail
					? { displayName: { [roomDetail.id]: roomDetail.name } }
					: { displayName: { create: 'Tạo phòng mới' } })}
				pathName={pathName}
				title={roomName}
			/>
			<DashboardCard>
				<SettingRoom isEdit={!isCreate} roomDetail={roomDetail} />
			</DashboardCard>
			{!isCreate && !roomDetail && <LoadingView show />}
		</DashboardContainer>
	);
}
