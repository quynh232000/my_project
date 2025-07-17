'use client';
import React, { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import Typography from '@/components/shared/Typography';
import { zodResolver } from '@hookform/resolvers/zod';
import {
	ABSENT_VALUE,
	ECancelFeeType,
	SeparatelyPolicyRow,
	separatelyPolicySchema,
} from '@/lib/schemas/policy/cancelPolicy';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import CancellationTableForm from '@/containers/policy/refund-and-cancellation-policy/commons/CancellationTableForm';
import { useRouter } from 'next/navigation';
import { useLoadingStore } from '@/store/loading/store';
import { updateCancelPolicy } from '@/services/policy/cancel/updateCancelPolicy';
import { CancelPolicyStatus } from '@/services/policy/cancel/getCancelPolicy';
import { toast } from 'sonner';
import { useCancelPolicyStore } from '@/store/cancel-policy/store';
import { DashboardRouter } from '@/constants/routers';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { useShallow } from 'zustand/react/shallow';

export default function SeparateCancellationPolicyForm({
	defaultValues,
	onSubmit,
	onCancel,
	isDialog = false,
}: {
	defaultValues?: SeparatelyPolicyRow;
	onSubmit?: (val: SeparatelyPolicyRow) => void;
	onCancel?: () => void;
	isDialog?: boolean;
}) {
	const router = useRouter();
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { addLocalPolicy, fetchCancelPolicy } = useCancelPolicyStore(
		useShallow((state) => ({
			addLocalPolicy: state.addLocalPolicy,
			fetchCancelPolicy: state.fetchCancelPolicy,
		}))
	);

	const form = useForm<SeparatelyPolicyRow>({
		resolver: zodResolver(separatelyPolicySchema),
		mode: 'onChange',
		defaultValues: defaultValues || {
			code: '',
			name: '',
			status: true,
			rows: [
				{ day: ABSENT_VALUE, fee: 100, fee_type: ECancelFeeType.FEE },
			],
		},
	});

	const { control, handleSubmit } = form;

	useEffect(() => {
		setLoading(true);
		fetchCancelPolicy().finally(() => setLoading(false));
	}, []);

	const handleFormSubmit = (data: SeparatelyPolicyRow) => {
		if (onSubmit) {
			onSubmit(data);
		} else {
			setLoading(true);
			updateCancelPolicy({
				is_global: false,
				code: data.code,
				name: data.name,
				status: data.status
					? CancelPolicyStatus.ACTIVE
					: CancelPolicyStatus.INACTIVE,
				policy_rules: data.rows,
			})
				.then((res) => {
					if (res.id) {
						addLocalPolicy({
							id: res.id,
							code: data.code,
							name: data.name,
							status: data.status
								? CancelPolicyStatus.ACTIVE
								: CancelPolicyStatus.INACTIVE,
							is_global: false,
							cancel_rules: data.rows,
						});
					}
					if (res.status) {
						toast.success('Thêm chính sách riêng thành công!');
						router.replace(DashboardRouter.policyCancel);
					} else {
						toast.error(res.message);
					}
				})
				.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
				.finally(() => setLoading(false));
		}
	};

	return (
		<Form {...form}>
			<form
				onSubmit={handleSubmit(handleFormSubmit)}
				className="flex w-full flex-col gap-6 overflow-hidden">
				<div className="flex flex-col gap-4 md:flex-row">
					<FormField
						name={'code'}
						control={control}
						render={({ field }) => (
							<FormItem className={'flex-1 space-y-2'}>
								<FormLabel required>
									Mã chính sách
									<FormMessage />
								</FormLabel>
								<FormControl>
									<Input
										type="text"
										{...field}
										placeholder="CHS004"
									/>
								</FormControl>
							</FormItem>
						)}
					/>

					<FormField
						name={'name'}
						control={control}
						render={({ field }) => (
							<FormItem className={'flex-1 space-y-2'}>
								<FormLabel required>
									Tên chính sách
									<FormMessage />
								</FormLabel>
								<FormControl>
									<Input
										{...field}
										placeholder="Tên chính sách"
									/>
								</FormControl>
							</FormItem>
						)}
					/>

					<FormField
						name="status"
						control={control}
						render={({ field }) => (
							<FormItem className={'flex-1 space-y-2'}>
								<FormLabel required>Trạng thái</FormLabel>
								<FormControl>
									<Switch
										id="policy-status"
										checked={field.value}
										onCheckedChange={field.onChange}
									/>
								</FormControl>
							</FormItem>
						)}
					/>
				</div>
				<CancellationTableForm />
				<div className="flex items-center gap-10">
					<div className="flex items-center gap-2">
						<div
							className={'h-2 w-6 rounded-xl bg-accent-02'}></div>
						<Typography
							tag="p"
							text={'Miễn phí hủy'}
							className={'text-sm font-medium leading-4'}
						/>
					</div>
					<div className="flex items-center gap-2">
						<div
							className={
								'h-2 w-6 rounded-xl bg-neutral-200'
							}></div>
						<Typography
							tag="p"
							text={'No-show'}
							className={'text-sm font-medium leading-4'}
						/>
					</div>
				</div>
				<ButtonActionGroup
					actionCancel={() =>
						isDialog
							? onCancel?.()
							: router.push('/dashboard/policy/cancel')
					}
				/>
			</form>
		</Form>
	);
}
