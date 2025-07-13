'use client';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import Typography from '@/components/shared/Typography';
import { Controller, useForm } from 'react-hook-form';
import { cn } from '@/lib/utils';
import { useGeneralPolicyStore } from '@/store/general-policy/store';
import React, { useEffect } from 'react';
import { useLoadingStore } from '@/store/loading/store';
import { Skeleton } from '@/components/ui/skeleton';
import { useRouter } from 'next/navigation';
import { DashboardRouter } from '@/constants/routers';
import { updateGeneralPolicy } from '@/services/policy/general/updateGeneralPolicy';
import { toast } from 'sonner';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';

interface Props {
	className?: string;
}

type FormData = { [key: string]: boolean };

export default function PolicyGeneral({ className }: Props) {
	const router = useRouter();
	const { data, fetchGeneralPolicy } = useGeneralPolicyStore();
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { handleSubmit, reset, control } = useForm<FormData>();

	const onSubmit = async (formData: FormData) => {
		if (data) {
			setLoading(true);
			const updatedData = [...data];
			updatedData.forEach(
				(policy, index) =>
					(updatedData[index].policy_general = {
						policy_setting_id: policy.id,
						is_allow: !!formData?.[policy.id],
					})
			);
			const res = await updateGeneralPolicy(updatedData);
			if (res) {
				toast.success('Cập nhật chính sách chung thành công!');
			} else {
				toast.error('Có lỗi xảy ra, vui lòng thử lại!');
			}
			setLoading(false);
		}
	};

	useEffect(() => {
		setLoading(true);
		fetchGeneralPolicy().finally(() => setLoading(false));
	}, []);

	useEffect(() => {
		if (data) {
			reset(
				Object.fromEntries(
					data.map((policy) => [
						policy.id,
						!!policy.policy_general?.is_allow,
					])
				)
			);
		}
	}, [data]);

	return (
		<>
			{(data?.length ?? 0) > 0 ? (
				<form
					onSubmit={handleSubmit(onSubmit)}
					className={cn('', className)}>
					<ul className={'flex flex-col gap-6'}>
						{data?.map((item) => (
							<li
								key={item.id}
								className={`flex flex-row flex-wrap items-center gap-y-4`}>
								<Typography
									tag="p"
									text={item.name}
									className={
										'min-w-[266px] text-base font-normal leading-6 text-neutral-600'
									}
								/>
								<Controller
									control={control}
									name={String(item.id)}
									render={({ field }) => (
										<RadioGroup
											onValueChange={(val) =>
												field.onChange(val === 'true')
											}
											defaultValue={String(field.value)}
											className={
												'flex flex-1 items-center'
											}>
											<div className="flex gap-6">
												<div className="flex items-center space-x-2">
													<RadioGroupItem
														id={`yes-${item.id}`}
														value="true"
														checked={
															field.value === true
														}
														className="border-2 border-other-divider data-[state=checked]:border-secondary-500"
													/>
													<label
														htmlFor={`yes-${item.id}`}
														className={
															'cursor-pointer text-base font-normal leading-6 text-neutral-600'
														}>
														Có
													</label>
												</div>
												<div className="flex items-center space-x-2">
													<RadioGroupItem
														id={`no-${item.id}`}
														value="false"
														checked={
															field.value ===
															false
														}
														className="border-2 border-other-divider data-[state=checked]:border-secondary-500"
													/>
													<label
														htmlFor={`no-${item.id}`}
														className={
															'cursor-pointer text-base font-normal leading-6 text-neutral-600'
														}>
														{' '}
														Không
													</label>
												</div>
											</div>
										</RadioGroup>
									)}
								/>
							</li>
						))}
					</ul>
					<ButtonActionGroup
						actionCancel={() =>
							router.push(DashboardRouter.policyChildren)
						}
					/>
				</form>
			) : (
				<Skeleton className={'h-[200px] w-full rounded-xl'} />
			)}
		</>
	);
}
