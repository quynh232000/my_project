export const AuthRouters = {
	signIn: '/sign-in',
	signUp: '/sign-up',
	forgotPassword: '/forgot-password',
} as const;

export const RefreshRouters = {
	index: '/refresh'
}

export const PropertySelectRouters = {
	index: '/property'
}
export const DashboardRouter = {
	profile: '/dashboard/profile',
	room: '/dashboard/room',
	roomCreate: '/dashboard/room/create',
	policyGeneral: '/dashboard/policy/general',
	policyChildren: '/dashboard/policy/children',
	policyCancel: '/dashboard/policy/cancel',
	policyCancelEstablish: '/dashboard/policy/cancel/establish',
	policyCancelAdd: '/dashboard/policy/cancel/add-new-policy',
	policyOther: '/dashboard/policy/other',
	policyOtherExtraBed: '/dashboard/policy/other/extra-bed',
	policyOtherDeposit: '/dashboard/policy/other/deposit-policy',
	policyOtherAge: '/dashboard/policy/other/minimum-check-in-age',
	policyOtherBreakfast: '/dashboard/policy/other/serves-breakfast',
	priceType: '/dashboard/price/type',
	priceTypeCreate: '/dashboard/price/type/create',
	priceAvailability: '/dashboard/price/availability',
	promotion: '/dashboard/promotion',
	promotionCreate: '/dashboard/promotion/create',
	user: '/dashboard/user',
	userGroup: '/dashboard/user/user-group',
	userGroupCreate: '/dashboard/user/user-group/create',
	customer: '/dashboard/customer',
	review: '/dashboard/review',
	cms: '/dashboard/cms',
	album: "/dashboard/album",
} as const;
