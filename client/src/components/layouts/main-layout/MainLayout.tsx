'use client';
import DashboardMenu from '@/components/shared/Dashboard/DashboardMenu';
import { SidebarTrigger, useSidebar } from '@/components/ui/sidebar';
import { PropertySelectRouters } from '@/constants/routers';
import { useAccommodationProfileStore } from '@/store/accommodation-profile/store';
import { useLoadingStore } from '@/store/loading/store';
import { getClientSideCookie } from '@/utils/cookie';
import { useWindowSize } from '@uidotdev/usehooks';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import { useCookies } from 'react-cookie';
import { useShallow } from 'zustand/react/shallow';

const MainLayout = ({ children }: ChildrenProp) => {
	const [cookies] = useCookies(['hotel_id']);
	const router = useRouter();
	const { open } = useSidebar();
	const size = useWindowSize();
	const { fetchProfile, profile } = useAccommodationProfileStore(
		useShallow((state) => ({
			fetchProfile: state.fetchProfile,
			profile: state.profile,
		}))
	);
	const setLoading = useLoadingStore((state) => state.setLoading);

	useEffect(() => {
		if (profile) {
			if (profile.id !== +cookies.hotel_id) {
				if (document.visibilityState === 'visible') {
					window.location.reload();
				} else {
					const handleVisibilityChange = () => {
						if (document.visibilityState === 'visible') {
							window.location.reload();
							document.removeEventListener(
								'visibilitychange',
								handleVisibilityChange
							);
						}
					};
					document.addEventListener(
						'visibilitychange',
						handleVisibilityChange
					);
					return () => {
						document.removeEventListener(
							'visibilitychange',
							handleVisibilityChange
						);
					};
				}
			}
		}
	}, [profile, cookies.hotel_id]);

	useEffect(() => {
		const hotel_id = getClientSideCookie('hotel_id');
		if (hotel_id) {
			setLoading(true);
			fetchProfile(+hotel_id).finally(() => setLoading(false));
		} else {
			router.replace(PropertySelectRouters.index);
		}
	}, []);

	return (
		<main
			className={'grow bg-blue-100'}
			style={{
				maxWidth: `calc(100% - ${(size.width ?? 0) >= 768 ? (open ? 280 : 48) : 0}px)`,
			}}>
			<DashboardMenu />
			<SidebarTrigger className="!ml-2 md:hidden" icon />
			{children}
		</main>
	);
};

export default MainLayout;
