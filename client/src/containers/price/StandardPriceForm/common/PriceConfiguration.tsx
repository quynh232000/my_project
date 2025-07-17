import React from 'react';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Label } from '@/components/ui/label';
import { Controller, useFormContext } from 'react-hook-form';
import {
	EPriceSetting,
	TPriceType,
} from '@/lib/schemas/type-price/standard-price';

const PriceConfiguration = () => {
	const { control } = useFormContext<TPriceType>();
	return (
		<Controller
			control={control}
			name={'priceSetting'}
			render={({ field }) => (
				<div className={'rounded-2xl bg-white p-5'}>
					<h2 className={cn(TextVariants.caption_18px_700)}>
						Cài đặt giá
						<span className={'ml-1 text-red-500'}>*</span>
					</h2>
					<div className={'mt-4'}>
						<RadioGroup
							className="gap-4"
							onValueChange={(val) => field.onChange(+val)}
							value={String(EPriceSetting.new)}>
							<div className="flex items-center space-x-2">
								<RadioGroupItem
									value={String(EPriceSetting.new)}
									id="priceSetting-new"
									className={
										'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
									}
								/>
								<Label
									htmlFor="priceSetting-new"
									containerClassName={'mb-0'}
									className={`cursor-pointer text-neutral-600 ${TextVariants.caption_14px_400}`}>
									Cài đặt như một loại giá mới
								</Label>
							</div>
							<div className="flex items-center space-x-2">
								<RadioGroupItem
									value={String(
										EPriceSetting.based_on_existing
									)}
									id="based_on_existing"
									className={
										'size-5 cursor-default border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
									}
								/>
								<Label
									htmlFor="based_on_existing"
									containerClassName={'mb-0'}
									className={`text-neutral-300 ${TextVariants.caption_14px_400}`}>
									Dựa trên một trong số loại giá hiện tại
								</Label>
							</div>
							{/*<div className="flex items-center space-x-2">*/}
							{/*	<RadioGroupItem*/}
							{/*		value="based_on_existing"*/}
							{/*		id="based_on_existing"*/}
							{/*		className={*/}
							{/*			'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'*/}
							{/*		}*/}
							{/*	/>*/}
							{/*	<Label*/}
							{/*		htmlFor="based_on_existing"*/}
							{/*		containerClassName={'mb-0'}*/}
							{/*		className={'cursor-pointer text-neutral-600'}>*/}
							{/*		Dựa trên một trong số loại giá hiện tại*/}
							{/*	</Label>*/}
							{/*</div>*/}
						</RadioGroup>
					</div>
				</div>
			)}
		/>
	);
};

export default PriceConfiguration;
