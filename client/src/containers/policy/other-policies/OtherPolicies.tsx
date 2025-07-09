'use client';
import DashboardTable, {
	renderStatus,
} from '@/components/shared/DashboardTable';
import Typography from '@/components/shared/Typography';
import { DashboardRouter } from '@/constants/routers';
import { IPolicyOtherItem } from '@/services/policy/other/getPolicyOther';
import { useLoadingStore } from '@/store/loading/store';
import { useOtherPolicyStore } from '@/store/other-policy/store';
import { startHolyLoader } from 'holy-loader';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import { useShallow } from 'zustand/react/shallow';

export default function OtherPolicies() {
	const router = useRouter();
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { otherPolicy, fetchOtherPolicy } = useOtherPolicyStore(
		useShallow((state) => ({
			otherPolicy: state.otherPolicy,
			fetchOtherPolicy: state.fetchOtherPolicy,
		}))
	);

	useEffect(() => {
		setLoading(true);
		fetchOtherPolicy().finally(() => setLoading(false));
	}, []);

	return (
		<>
			{otherPolicy.length > 0 ? (
				<DashboardTable<IPolicyOtherItem>
					showSearchComponent={false}
					columns={[
						{ label: 'Tên chính sách', field: 'name', sortable: true },
						{
							label: 'Trạng thái',
							field: 'is_active',
							sortable: true,
							fieldClassName: 'w-[175px]',
							renderCell: (status, row) =>
								renderStatus(status, row, {
									statusesPalete: {
										true: {
											label: 'Hoạt động',
											backgroundColor: 'bg-gray-200',
											color: 'text-gray-900',
										},
										false: {
											label: 'Không hoạt động',
											backgroundColor: 'bg-gray-200',
											color: 'text-gray-500',
										},
									},
								}),
						},
					]}
					rows={otherPolicy}
					action={{
						name: 'Thiết lập',
						type: 'edit',
						className: 'w-[175px]',
						url: `${DashboardRouter.policyOther}`,
						handle: [
							(policy) => {
								startHolyLoader();
								router.push(`${DashboardRouter.policyOther}/${policy.slug}`);
							},
						],
					}}
				/>
			) : (
				<div className={'my-10 text-center'}>
					<Typography
						tag={'h2'}
						variant={'content_16px_700'}
						className={'text-neutral-600'}>
						Hiện chưa có Chính sách khác nào
					</Typography>
				</div>
			)}
		</>
	);
}
