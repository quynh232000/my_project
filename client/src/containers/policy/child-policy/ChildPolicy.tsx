'use client';
import { Controller, FormProvider, useForm } from 'react-hook-form';
import Typography from '@/components/shared/Typography';
import { Separator } from '@/components/ui/separator';
import {
	PolicyFormValues,
	policySchema,
	ROBB,
} from '@/lib/schemas/policy/validationChildPolicy';
import { zodResolver } from '@hookform/resolvers/zod';
import { cn } from '@/lib/utils';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import React, { useEffect } from 'react';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { useLoadingStore } from '@/store/loading/store';
import { updatePolicyChildren } from '@/services/policy/children/updatePolicyChildren';
import { toast } from 'sonner';
import { useChildrenPolicyStore } from '@/store/child-policy/store';
import { useRouter } from 'next/navigation';
import { DashboardRouter } from '@/constants/routers';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import ChildPolicyTableForm, {
	childrenAge,
} from '@/containers/policy/common/ChildPolicyTableForm';
import Link from 'next/link';

interface Props {
	className?: string;
}

export default function ChildPolicy({ className }: Props) {
	const router = useRouter();

	const methods = useForm<PolicyFormValues>({
		defaultValues: {
			ageLimit: 12,
			rows: [
				{ age_from: 0, age_to: NaN, fee_type: 'free', meal_type: ROBB.RO },
			],
		},
		resolver: zodResolver(policySchema),
	});

	const {
		control,
		handleSubmit,
		formState: { errors },
		reset,
	} = methods;

	const setLoading = useLoadingStore((state) => state.setLoading);

	const { data, fetchChildrenPolicy, setChildrenPolicy } =
		useChildrenPolicyStore();

	useEffect(() => {
		setLoading(true);
		fetchChildrenPolicy().finally(() => setLoading(false));
	}, []);

	useEffect(() => {
		if (data && data.length > 0) {
			reset({
				ageLimit: data[data.length - 1].age_to,
				rows: data.map((item) => ({
					...item,
					fee: (item?.fee ?? 0) > 0 ? item.fee : NaN,
					fee_type: item.fee_type as 'free' | 'charged' | 'limit',
					meal_type: item.meal_type as ROBB,
				})),
			});
		}
	}, [data]);

	const onSubmit = async (data: PolicyFormValues) => {
		if (data && data.rows.length > 0) {
			try {
				setLoading(true);
				const res = await updatePolicyChildren({ policies: data.rows });
				if (res && res.status) {
					toast.success(res.message);
					setChildrenPolicy(data.rows);
				} else {
					toast.error('Có lỗi xảy ra, vui lòng thử lại!');
				}
				setLoading(false);
			} catch (error) {
				console.log(error);
			}
		}
	};

	return (
		<FormProvider {...methods}>
			<form
				onSubmit={handleSubmit(onSubmit)}
				className={cn('flex flex-col gap-6', className)}>
				<div>
					<Typography
						tag={'p'}
						text={'Độ tuổi tối đa của trẻ em'}
						className={'text-md font-semibold leading-6'}
					/>
					<div className={'mt-4 flex items-center gap-6'}>
						<div>
							{errors.ageLimit && (
								<span className="mt-1 text-sm text-red-500">
									{errors.ageLimit.message}
								</span>
							)}
							<Controller
								name={'ageLimit'}
								control={control}
								render={({ field }) => (
									<SelectPopup
										searchInput={false}
										className="h-10 w-[200px] rounded-lg px-3 py-0"
										labelClassName="hidden"
										data={childrenAge}
										selectedValue={String(field.value)}
										onChange={(val) => field.onChange(+val)}
									/>
								)}
							/>
						</div>
						<div>
							<Typography
								tag={'p'}
								text={'*Lưu ý quan trọng: '}
								className={`${TextVariants.caption_12px_500} text-neutral-400`}
							/>
							<Typography
								tag={'p'}
								className={`${TextVariants.caption_12px_500} text-neutral-400`}>
								{
									'Thay đổi độ tuổi trẻ em tối đa sẽ phải thiết lập lại Phụ thu trẻ em trong '
								}
								<Link href={DashboardRouter.priceType} className="underline">
									loại giá (Rate plan).
								</Link>
							</Typography>
						</div>
					</div>
				</div>
				<Separator orientation="horizontal" />

				<ChildPolicyTableForm prefix={''} />
				<ButtonActionGroup
					className={'mt-0'}
					actionCancel={() => router.push(DashboardRouter.policyCancel)}
				/>
			</form>
		</FormProvider>
	);
}
