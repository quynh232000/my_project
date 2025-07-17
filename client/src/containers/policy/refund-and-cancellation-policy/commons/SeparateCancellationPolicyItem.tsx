import React from 'react';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import Typography from '@/components/shared/Typography';
import {
	CancelPolicyStatus,
	ICancelPolicy,
} from '@/services/policy/cancel/getCancelPolicy';
import IconSettings from '@/assets/Icons/outline/IconSettings';
import { CancellationTimeline } from '@/containers/policy/refund-and-cancellation-policy/commons/CancellationTimeline';
import IconTrash from '@/assets/Icons/outline/IconTrash';

interface SeparateCancellationPolicyItemProps {
	policy: ICancelPolicy;
	onEdit: (id: number) => void;
	onChangeActive: (id: number, isActive: boolean) => void;
	onRemove: (id: number) => void;
}

export default function SeparateCancellationPolicyItem({
	policy,
	onEdit,
	onChangeActive,
	onRemove,
}: SeparateCancellationPolicyItemProps) {
	return (
		<div className="mb-4 flex flex-col gap-4 rounded-xl bg-white p-4">
			<div className="flex justify-between gap-4">
				<div className="flex flex-row gap-4">
					<Typography
						tag="p"
						variant="caption_14px_400"
						text={policy.code}
						className="text-neutral-400"
					/>
					<Typography
						tag="p"
						text={policy.name}
						variant="caption_14px_600"
						className="text-neutral-600"
					/>
				</div>
				<div className="flex items-center gap-4">
					{(policy?.price_types?.length ?? 0) > 0 &&
						policy.status === CancelPolicyStatus.ACTIVE && (
							<Typography
								tag="p"
								text={`${policy?.price_types?.length} loại giá đang áp dụng`}
								variant="caption_12px_600"
								className="rounded-lg bg-green-50 px-4 py-1 text-accent-02"
							/>
						)}
					<button
						className="flex items-center gap-1 text-sm font-semibold text-neutral-400"
						onClick={() => onEdit(policy.id)}>
						<IconSettings />
						Thiết lập
					</button>
				</div>
			</div>

			<CancellationTimeline
				policyRow={policy?.cancel_rules ? policy?.cancel_rules : []}
				cancelable={true}
			/>

			<div className="flex flex-row items-center justify-between">
				<div className="flex w-full flex-row gap-2">
					<Switch
						id={`policy-${policy.name}-status`}
						checked={policy.status === CancelPolicyStatus.ACTIVE}
						onCheckedChange={(checked) =>
							onChangeActive(policy.id, checked)
						}
					/>
					<Label
						htmlFor={`policy-${policy.name}-status`}
						className="cursor-pointer">
						Kích hoạt
					</Label>
				</div>
				<IconTrash
					className="cursor-pointer"
					onClick={() => onRemove(policy.id)}
				/>
			</div>
		</div>
	);
}
