'use client';
import Typography from '@/components/shared/Typography';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import CancellationTableForm from '@/containers/policy/refund-and-cancellation-policy/commons/CancellationTableForm';
import { useForm, useWatch } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import {
	ABSENT_VALUE,
	CancelPolicyFormValues,
	cancelPolicySchema,
	ECancelFeeType,
} from '@/lib/schemas/policy/cancelPolicy';
import { Form } from '@/components/ui/form';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { useRouter } from 'next/navigation';
import { DashboardRouter } from '@/constants/routers';
import { useCancelPolicyStore } from '@/store/cancel-policy/store';
import React, { useEffect } from 'react';
import { CancelPolicyStatus } from '@/services/policy/cancel/getCancelPolicy';
import { useLoadingStore } from '@/store/loading/store';
import { Skeleton } from '@/components/ui/skeleton';
import { updateCancelPolicy } from '@/services/policy/cancel/updateCancelPolicy';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

export default function SettingRefundAndCancellationPolicy() {
	const router = useRouter();
	const { global, fetchCancelPolicy, setGlobalPolicy } = useCancelPolicyStore(
		useShallow((state) => ({
			global: state.global,
			fetchCancelPolicy: state.fetchCancelPolicy,
			setGlobalPolicy: state.setGlobalPolicy,
		}))
	);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const form = useForm<CancelPolicyFormValues>({
		resolver: zodResolver(cancelPolicySchema),
		mode: 'onChange',
	});

	const { setValue, control, reset } = form;

	const cancelable = useWatch({ control, name: 'cancelable' });

	useEffect(() => {
		if (global !== null) {
			if (global && global.status === CancelPolicyStatus.ACTIVE) {
				reset({
					cancelable: true,
					rows: global?.cancel_rules
						? global?.cancel_rules
						: [
								{
									day: ABSENT_VALUE,
									fee: 100,
									fee_type: ECancelFeeType.FEE,
								},
							],
				});
			} else {
				reset({
					cancelable: false,
					rows: [{ day: ABSENT_VALUE, fee: 100, fee_type: ECancelFeeType.FEE }],
				});
			}
		} else {
			setLoading(true);
			fetchCancelPolicy().finally(() => setLoading(false));
		}
	}, [global]);

	const onSubmit = (val: CancelPolicyFormValues) => {
		setLoading(true);
		updateCancelPolicy({
			is_global: true,
			status: val.cancelable
				? CancelPolicyStatus.ACTIVE
				: CancelPolicyStatus.INACTIVE,
			policy_rules: val.cancelable ? val.rows : [],
		})
			.then((res) => {
				setGlobalPolicy({
					id: global?.id ?? 0,
					code: '',
					name: '',
					status: val.cancelable
						? CancelPolicyStatus.ACTIVE
						: CancelPolicyStatus.INACTIVE,
					is_global: true,
					cancel_rules: val.cancelable ? val.rows : [],
				});
				res.status
					? toast.success('Cập nhật chính sách chung thành công!')
					: toast.error(res.message);
			})
			.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
			.finally(() => setLoading(false));
		router.replace(DashboardRouter.policyCancel);
	};

	return (
		<Form {...form}>
			{global === null ? (
				<Skeleton className={'h-[200px] w-full rounded-xl'} />
			) : (
				<form onSubmit={form.handleSubmit(onSubmit)}>
					<Typography
						tag={'p'}
						text={'Chỗ của bạn có chính sách hoàn hủy không?'}
						variant={'content_16px_600'}
						className={'mb-2 text-neutral-600'}
					/>
					<RadioGroup
						value={cancelable ? 'true' : 'false'}
						onValueChange={(val) => {
							setValue('cancelable', val === 'true');
						}}
						className={'flex gap-6'}>
						<div className="flex items-center">
							<RadioGroupItem
								value={'false'}
								id={'r2'}
								className="border-2 border-other-divider"
							/>
							<Label
								htmlFor="r2"
								className={`ml-2 mt-2 cursor-pointer ${TextVariants.caption_14px_400}`}>
								Không hoàn hủy
							</Label>
						</div>
						<div className="flex items-center">
							<RadioGroupItem
								value="true"
								id={'r3'}
								className="border-2 border-other-divider"
							/>
							<Label
								htmlFor="r3"
								className={`ml-2 mt-2 cursor-pointer ${TextVariants.caption_14px_400}`}>
								Có hoàn hủy
							</Label>
						</div>
					</RadioGroup>
					{cancelable && <CancellationTableForm className="mt-6" />}
					<ButtonActionGroup
						actionCancel={() => {
							router.replace(DashboardRouter.policyCancel);
						}}
					/>
				</form>
			)}
		</Form>
	);
}
