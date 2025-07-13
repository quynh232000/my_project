'use client';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import Typography from '@/components/shared/Typography';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormMessage,
} from '@/components/ui/form';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import DepositPolicyForm from '@/containers/policy/other-policies/deposit-policy/commons/DepositPolicyForm';
import {
	DepositPolicyFormValue,
	depositPolicyObject,
	EDepositAmountType,
} from '@/lib/schemas/policy/otherPolicy';
import { getPolicyOtherDetail } from '@/services/policy/other/getPolicyOtherDetail';
import { updatePolicyOther } from '@/services/policy/other/updatePolicyOther';
import { useAttributeStore } from '@/store/attributes/store';
import { useLoadingStore } from '@/store/loading/store';
import { useOtherPolicyStore } from '@/store/other-policy/store';
import { TPolicyDeposit } from '@/store/other-policy/type';
import { zodResolver } from '@hookform/resolvers/zod';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import { useForm, useWatch } from 'react-hook-form';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

export default function DepositPolicy() {
	const router = useRouter();
	const {
		data: { deposit },
		setOtherPolicy,
	} = useOtherPolicyStore(
		useShallow((state) => ({
			data: state.data,
			setOtherPolicy: state.setOtherPolicy,
		}))
	);

	const methods = useForm<DepositPolicyFormValue>({
		resolver: zodResolver(depositPolicyObject),
		defaultValues: {
			deposit: deposit,
		},
	});

	const [watchTypeDeposit, isActive] = useWatch({
		control: methods.control,
		name: ['deposit.type_deposit', 'isActive'],
	});

	const setLoading = useLoadingStore((state) => state.setLoading);

	const fetchMethodDepositList = useAttributeStore(
		(state) => state.fetchMethodDepositList
	);

	useEffect(() => {
		(async () => {
			setLoading(true);
			await fetchMethodDepositList().finally(() => setLoading(false));
		})();
	}, []);

	useEffect(() => {
		(async () => {
			setLoading(true);
			const data = await getPolicyOtherDetail<TPolicyDeposit['settings']>(
				{
					slug: 'deposit-policy',
				}
			);
			if (data) {
				methods.reset({
					isActive: data.is_active,
					deposit: data.is_active
						? {
								...data.settings,
								method_deposit: data.settings?.method_deposit,
								type_deposit: data.settings
									?.type_deposit as EDepositAmountType,
							}
						: undefined,
				});
			}
			setLoading(false);
		})();
	}, []);

	const handlerShow = (value: string) => {
		if (value === 'true' && watchTypeDeposit === undefined) {
			methods.reset({
				isActive: true,
				deposit: {
					method_deposit: [],
					amount: NaN,
					type_deposit: EDepositAmountType.fixed,
				},
			});
		} else if (value === 'false') {
			methods.reset({ isActive: false, deposit: undefined });
		}
	};

	const onSubmit = async (data: DepositPolicyFormValue) => {
		try {
			setLoading(true);
			const res = await updatePolicyOther<TPolicyDeposit>({
				slug: 'deposit-policy',
				is_active: data.isActive,
				settings: data.isActive ? data?.deposit : undefined,
			});
			if (res?.status) {
				toast.success('Cập nhật Chính sách đặt cọc thành công');
				setOtherPolicy([]);
			} else {
				toast.error('Cập nhật Chính sách đặt cọc thất bại');
			}
			setLoading(false);
		} catch (error) {
			console.error(error);
		}
	};

	return (
		<Form {...methods}>
			<form onSubmit={methods.handleSubmit(onSubmit)}>
				<Typography
					tag={'p'}
					text={'Chổ nghỉ của bạn cho chính sách đặt cọc không?'}
					className={'text-md font-semibold leading-6'}
				/>
				<FormField
					name="isActive"
					control={methods.control}
					render={({ field }) => (
						<FormItem className="space-y-2">
							<FormControl>
								<RadioGroup
									value={`${field.value}`}
									onValueChange={(val) => {
										field.onChange(val === 'true');
										handlerShow(val);
									}}
									className={'mt-4 flex gap-4'}>
									<div className="flex items-center space-x-2">
										<RadioGroupItem
											id={'r2'}
											value="false"
											className={
												'border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-white data-[state=checked]:text-secondary-500'
											}
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

									<div className="flex items-center space-x-2">
										<RadioGroupItem
											id={'r3'}
											value="true"
											className={
												'border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-white data-[state=checked]:text-secondary-500'
											}
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
								</RadioGroup>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>

				{isActive && <DepositPolicyForm />}

				<ButtonActionGroup actionCancel={() => router.back()} />
			</form>
		</Form>
	);
}
