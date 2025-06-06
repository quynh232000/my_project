'use client';

import { useEffect } from 'react';
import { useCancelPolicyStore } from '@/store/cancel-policy/store';
import { useGeneralPolicyStore } from '@/store/general-policy/store';
import { useAccommodationProfileStore } from '@/store/accommodation-profile/store';
import { usePricesStore } from '@/store/prices/store';
import { useRoomStore } from '@/store/room/store';
import { useAvailabilityCenterStore } from '@/store/availability-center/store';
import { usePromotionStore } from '@/store/promotion/store';
import { useChildrenPolicyStore } from '@/store/child-policy/store';
import { useAlbumHotelStore } from '@/store/album/store';
import { useOtherPolicyStore } from '@/store/other-policy/store';

const StoreLayout = ({ children }: ChildrenProp) => {
	const resetProfile = useAccommodationProfileStore((state) => state.reset);
	const setGeneralPolicy = useGeneralPolicyStore(
		(state) => state.setGeneralPolicy
	);
	const resetCancelPolicy = useCancelPolicyStore((state) => state.reset);
	const resetPrices = usePricesStore((state) => state.reset);
	const resetRooms = useRoomStore((state) => state.reset);
	const setChildrenPolicy = useChildrenPolicyStore(
		(state) => state.setChildrenPolicy
	);
	const resetAvailabilityCenter = useAvailabilityCenterStore(
		(state) => state.reset
	);
	const resetPromotion = usePromotionStore((state) => state.reset);
	const resetAlbumHotel = useAlbumHotelStore((state) => state.reset);
	const resetOtherPolicy = useOtherPolicyStore((state) => state.reset);

	useEffect(() => {
		resetProfile();
		setGeneralPolicy(null);
		setChildrenPolicy(null);
		resetCancelPolicy();
		resetPrices();
		resetRooms();
		resetAvailabilityCenter();
		resetPromotion();
		resetAlbumHotel();
		resetOtherPolicy();
	}, []);

	return <>{children}</>;
};

export default StoreLayout;
