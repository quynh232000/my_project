import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import {
	ECancellationPolicy,
	TPriceType,
} from '@/lib/schemas/type-price/standard-price';
import { cn } from '@/lib/utils';
import { CancelPolicyStatus } from '@/services/policy/cancel/getCancelPolicy';
import { useCancelPolicyStore } from '@/store/cancel-policy/store';
import { useEffect } from 'react';
import { Controller, useFormContext, useWatch } from 'react-hook-form';

const CancellationPolicy = () => {
	const { control, formState, register, unregister, getValues, setValue } =
		useFormContext<TPriceType>();

	const local = useCancelPolicyStore((state) => state.local);

	const cancellationPolicyType = useWatch({
		control,
		name: 'cancellationPolicy.type',
	});

	useEffect(() => {
		if (cancellationPolicyType === ECancellationPolicy.custom) {
			const getCancelPolicyId = getValues(
				'cancellationPolicy.policy_cancel_id'
			);
			const policyCancel = local?.find((item) => item.id === getCancelPolicyId);
			if (policyCancel?.status === CancelPolicyStatus.INACTIVE) {
				setValue('cancellationPolicy.type', ECancellationPolicy.general);
				unregister('cancellationPolicy.policy_cancel_id');
			}
		}
	}, [local, cancellationPolicyType, unregister, getValues, setValue]);

	return (
		<div className={'rounded-2xl bg-white p-5'}>
			<h2 className={cn(TextVariants.caption_18px_700)}>
				Chính sách hoàn hủy
				<span className={'ml-1 text-red-500'}>*</span>
			</h2>
			<Controller
				control={control}
				name={'cancellationPolicy.type'}
				render={({ field }) => (
					<div className={'mt-4'}>
						<RadioGroup
							className="gap-4"
							onValueChange={(value) => {
								field.onChange(
									value === String(ECancellationPolicy.custom)
										? ECancellationPolicy.custom
										: ECancellationPolicy.general
								);
								if (value === String(ECancellationPolicy.custom)) {
									register('cancellationPolicy.policy_cancel_id');
								} else {
									unregister('cancellationPolicy.policy_cancel_id');
								}
							}}
							value={String(field.value)}>
							<div className="flex items-center space-x-2">
								<RadioGroupItem
									value={String(ECancellationPolicy.general)}
									id="cancellationPolicy-general"
									className={
										'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
									}
								/>
								<Label
									htmlFor="cancellationPolicy-general"
									containerClassName={'mb-0'}
									className={`cursor-pointer text-neutral-600 ${TextVariants.caption_14px_400}}`}>
									Theo chính sách hoàn hủy chung
								</Label>
							</div>
							<div className="flex items-center space-x-2">
								<RadioGroupItem
									value={String(ECancellationPolicy.custom)}
									id="cancellationPolicy-custom"
									className={
										'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
									}
								/>
								<Label
									htmlFor="cancellationPolicy-custom"
									containerClassName={'mb-0'}
									className={`cursor-pointer text-neutral-600 ${TextVariants.caption_14px_400}`}>
									Chính sách hoàn hủy riêng
								</Label>
							</div>
						</RadioGroup>
					</div>
				)}
			/>
			{cancellationPolicyType !== ECancellationPolicy.general ? (
				<Controller
					control={control}
					name={'cancellationPolicy.policy_cancel_id'}
					render={({ field: { onChange, value, ...props } }) => (
						<div className={'ml-7 mt-4'}>
							<SelectPopup
								className={cn('h-10 w-full rounded-lg lg:w-[372px]')}
								placeholder={'Chọn chính sách riêng'}
								data={local
									?.filter(
										(policy) => policy.status === CancelPolicyStatus.ACTIVE
									)
									?.map((policy) => ({
										value: policy.id,
										label: `${policy.code} - ${policy.name}`,
									}))}
								selectedValue={!!value ? +value : ''}
								onChange={(val) => {
									onChange(+val);
								}}
								controllerRenderProps={{ ...props }}
							/>
							<FieldErrorMessage errors={formState.errors} name={props.name} />
						</div>
					)}
				/>
			) : null}
		</div>
	);
};

export default CancellationPolicy;
