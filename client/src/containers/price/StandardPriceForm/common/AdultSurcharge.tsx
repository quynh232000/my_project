import React, { useEffect } from 'react';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { cn } from '@/lib/utils';
import { Controller, useFormContext, useWatch } from 'react-hook-form';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Label } from '@/components/ui/label';
import { EExtraFee, TPriceType } from '@/lib/schemas/type-price/standard-price';
import FieldErrorMessage from '@/components/shared/Form/FieldErrorMessage';
import ChildPolicyTableForm from '@/containers/policy/common/ChildPolicyTableForm';
import { useChildrenPolicyStore } from '@/store/child-policy/store';
import { ROBB } from '@/lib/schemas/policy/validationChildPolicy';
import { useLoadingStore } from '@/store/loading/store';

interface AdultSurchargeProps {
	priceItem: TPriceType | null;
}

const AdultSurcharge = ({ priceItem }: AdultSurchargeProps) => {
	const { control, formState, register, unregister, setValue } =
		useFormContext<TPriceType>();

	const { data, fetchChildrenPolicy } = useChildrenPolicyStore();
	const setLoading = useLoadingStore((state) => state.setLoading);

	const chargeExtraChild = useWatch({
		control,
		name: 'extraChildFeeType',
	});

	const policy = useWatch({
		control,
		name: 'policy',
	});

	useEffect(() => {
		setLoading(true);
		fetchChildrenPolicy().finally(() => setLoading(false));
	}, []);

	useEffect(() => {
		if (chargeExtraChild === EExtraFee.free) {
			unregister('policy');
		} else {
			setValue('policy', {
				ageLimit: data?.[data?.length - 1]?.age_to ?? 12,
				rows:
					(priceItem?.policy?.rows?.length ?? 0) > 0
						? (priceItem?.policy?.rows ?? [
								{
									age_from: 0,
									age_to: NaN,
									fee_type: 'free',
									meal_type: ROBB.RO,
								},
							])
						: [
								{
									age_from: 0,
									age_to: NaN,
									fee_type: 'free',
									meal_type: ROBB.RO,
								},
							],
			});
			register('policy');
		}
	}, [chargeExtraChild, data, priceItem]);

	return (
		<div className={'rounded-2xl bg-white p-5'}>
			<h2 className={cn(TextVariants.caption_18px_700)}>
				Phí phụ thu trẻ em
				<span className={'ml-1 text-red-500'}>*</span>
			</h2>
			<Controller
				control={control}
				name={'extraChildFeeType'}
				render={({ field }) => (
					<div className={'mt-4'}>
						<RadioGroup
							className="gap-4"
							onValueChange={(value) => {
								field.onChange(+value);
							}}
							value={String(field.value)}>
							<div className="flex items-center space-x-2">
								<RadioGroupItem
									value={String(EExtraFee.free)}
									id="extraAdultFee-free"
									className={
										'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
									}
								/>
								<Label
									htmlFor="extraAdultFee-free"
									containerClassName={'mb-0'}
									className={`cursor-pointer text-neutral-600 ${TextVariants.caption_14px_400}`}>
									Theo chính sách chung
								</Label>
							</div>
							<div className="flex items-center space-x-2">
								<RadioGroupItem
									value={String(EExtraFee.charged)}
									id="extraAdultFee-charged"
									className={
										'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
									}
								/>
								<Label
									htmlFor="extraAdultFee-charged"
									containerClassName={'mb-0'}
									className={`cursor-pointer text-neutral-600 ${TextVariants.caption_14px_400}`}>
									Theo chính sách mới
								</Label>
							</div>
						</RadioGroup>
						<FieldErrorMessage errors={formState.errors} name={field.name} />
					</div>
				)}
			/>
			{!!policy && (
				<ChildPolicyTableForm prefix={'policy'} className={'mt-4'} />
			)}
		</div>
	);
};

export default AdultSurcharge;
