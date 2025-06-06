'use client';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import Typography from '@/components/shared/Typography';
import {
	FormControl,
	FormField,
	FormItem,
	FormMessage,
} from '@/components/ui/form';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { DashboardRouter } from '@/constants/routers';
import { MAX_AGE_VALUE } from '@/containers/setting-room/RoomGeneralSetting/common/RoomExtraBeds';
import {
	BreakFastServiceFormValue,
	breakfastServiceObject,
	EUseBreakfastType,
} from '@/lib/schemas/policy/otherPolicy';
import { getPolicyOtherDetail } from '@/services/policy/other/getPolicyOtherDetail';
import { updatePolicyOther } from '@/services/policy/other/updatePolicyOther';
import { useLoadingStore } from '@/store/loading/store';
import { useOtherPolicyStore } from '@/store/other-policy/store';
import { TPolicyServesBreakfast } from '@/store/other-policy/type';
import { zodResolver } from '@hookform/resolvers/zod';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import { FormProvider, useForm, useWatch } from 'react-hook-form';
import { toast } from 'sonner';
import ServersBreakFastForm from './common/ServersBreakFastForm';

export default function ServersBreakfast() {
	const router = useRouter();
	const setOtherPolicy = useOtherPolicyStore(state => state.setOtherPolicy);
	const methods = useForm<BreakFastServiceFormValue>({
		resolver: zodResolver(breakfastServiceObject),
		defaultValues: { breakfast: undefined },
	});

	const setLoading = useLoadingStore((state) => state.setLoading);

	const watchIsActive = useWatch({
		control: methods.control,
		name: 'breakfast.is_active',
	});

	useEffect(() => {
		(async () => {
			setLoading(true);
			const data = await getPolicyOtherDetail<
				TPolicyServesBreakfast['settings']
			>({ slug: 'serves-breakfast' });
			if (data) {
				methods.reset({
					breakfast: {
						is_active: data.is_active,
						...data.settings,
						isBreakfast:
							data.settings && data.settings?.extra_breakfast?.length > 0
								? EUseBreakfastType.yes
								: EUseBreakfastType.no,
						extra_breakfast: data.settings?.extra_breakfast.map((item) => ({
							...item,
							age_to:
								item.age_to === null ? Number(MAX_AGE_VALUE) : item.age_to,
						})),
					},
				});
			}
			setLoading(false);
		})();
	}, []);

	async function onSubmit(data: BreakFastServiceFormValue) {
		const updateData = data.breakfast && {
			time_from: data.breakfast.time_from,
			time_to: data.breakfast.time_to,
			breakfast_type: data.breakfast.breakfast_type ?? 0,
			serving_type: data.breakfast.serving_type ?? 0,
			extra_breakfast: data.breakfast.isBreakfast
				? (data.breakfast.extra_breakfast ?? []).map((item) => ({
						...item,
						fee_type: item.fee_type as 'free' | 'charged',
						fee: Number.isNaN(item.fee) ? 0 : item.fee,
						age_to: item.age_to === Number(MAX_AGE_VALUE) ? null : item.age_to,
					}))
				: [],
		};

		try {
			setLoading(true);
			const res = await updatePolicyOther<TPolicyServesBreakfast>({
				slug: 'serves-breakfast',
				is_active: watchIsActive,
				settings: watchIsActive ? updateData : undefined,
			});

			if (res?.status) {
				toast.success('Cập nhật chính sách phục vụ bữa sáng thành công');
				setOtherPolicy([]);
			}
			setLoading(false);
		} catch (error) {
			console.log(error);
		}
	}

	return (
		<FormProvider {...methods}>
			<form onSubmit={methods.handleSubmit(onSubmit)}>
				<Typography
					tag={'p'}
					variant="content_16px_600"
					text={'Chỗ nghỉ của bạn có phục vụ bữa sáng không'}
					className={'text-neutral-600'}
				/>
				<FormField
					name={'breakfast.is_active'}
					control={methods.control}
					render={({ field }) => (
						<FormItem className={'col-span-1 space-y-2'}>
							<FormControl>
								<RadioGroup
									value={`${field.value}`}
									onValueChange={(value) => field.onChange(value === 'true')}
									className={'mt-4 flex gap-6'}>
									<div className="flex items-center space-x-2">
										<RadioGroupItem
											id={'r3'}
											value="true"
											className={'border-2'}
										/>
										<Label
											htmlFor="r3"
											containerClassName={'m-0 ml-2'}
											className={
												'cursor-pointer text-base font-normal leading-6'
											}>
											Có
										</Label>
									</div>
									<div className="flex items-center space-x-2">
										<RadioGroupItem
											id={'r2'}
											value="false"
											className={'border-2'}
										/>
										<Label
											htmlFor="r2"
											containerClassName={'m-0 ml-2'}
											className={
												'cursor-pointer text-base font-normal leading-6'
											}>
											Không
										</Label>
									</div>
								</RadioGroup>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>
				{watchIsActive && <ServersBreakFastForm />}
				<ButtonActionGroup
					actionCancel={() => router.push(DashboardRouter.policyOther)}
				/>
			</form>
		</FormProvider>
	);
}
