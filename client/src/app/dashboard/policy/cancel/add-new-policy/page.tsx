import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import SeparateCancellationPolicyForm from '@/containers/policy/separate-cancellation-policy/SeparateCancellationPolicyForm';

export default async function Page() {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				title={'Chính sách hoàn hủy riêng'}
				pathName={pathName}
			/>
			<DashboardCard>
				<SeparateCancellationPolicyForm />
			</DashboardCard>
		</DashboardContainer>
	);
}
