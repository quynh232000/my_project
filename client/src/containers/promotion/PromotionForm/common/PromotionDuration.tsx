import React from 'react';
import Typography from '@/components/shared/Typography';
import { DatePicker } from '@/containers/price/common/DatePicker';
import { Controller, useFormContext, useWatch } from 'react-hook-form';
import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import { PromotionType } from '@/lib/schemas/discount/discount';

const PromotionDuration = () => {
	const { control, setValue } = useFormContext<PromotionType>();
	const expiryWatch = useWatch({
		control,
		name: 'discountDuration.noExpiry',
	});

	return (
		<div className={'rounded-lg border border-blue-100 bg-white p-4'}>
			<Typography
				tag={'h2'}
				variant={'content_16px_600'}
				className={'text-neutral-600'}>
				Bạn muốn áp dụng khuyến mãi này trong bao lâu?
			</Typography>
			<div className={'mt-4 lg:grid lg:grid-cols-3 lg:gap-4'}>
				<DatePicker
					title={'Từ'}
					required={true}
					name={'discountDuration.start_date'}
				/>
				<DatePicker
					title={'Đến'}
					name={'discountDuration.end_date'}
					required={true}
					disabled={expiryWatch}
				/>
				<Controller
					control={control}
					name={'discountDuration.noExpiry'}
					render={({ field }) => (
						<CheckBoxView
							containerClassName={'mt-8'}
							value={field.value}
							onValueChange={(checked) => {
								field.onChange(checked);
								if (checked) {
									setValue('discountDuration.end_date', null);
								}
							}}>
							<Typography
								tag={'p'}
								variant={'caption_14px_400'}
								className={'text-neutral-600'}>
								Gia hạn ngày đặt vô thời hạn
							</Typography>
						</CheckBoxView>
					)}
				/>
			</div>
		</div>
	);
};

export default PromotionDuration;
