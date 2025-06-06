import React from 'react';
import Typography from '@/components/shared/Typography';
import { Controller, useFormContext } from 'react-hook-form';
import { PromotionType } from '@/lib/schemas/discount/discount';
import { Switch } from '@/components/ui/switch';

const StackablePromotionOption = () => {
	const { control } = useFormContext<PromotionType>();
	return (
		<div className={'rounded-lg border border-blue-100 bg-white p-4'}>
			<Typography
				tag={'h2'}
				variant={'content_16px_600'}
				className={'text-neutral-600'}>
				Bạn có cho phép cộng dồn khuyến mãi này không?
			</Typography>
			<Controller
				control={control}
				name={'is_stackable'}
				render={({ field }) => (
					<div className={'mt-4 flex items-start gap-3'}>
						<label className="relative inline-block h-6 w-10 flex-shrink-0">
							<Switch checked={field.value} onCheckedChange={field.onChange} />
						</label>
						<div>
							<Typography
								tag={'p'}
								variant={'caption_14px_600'}
								className={'text-neutral-600'}
								text={'Cho phép cộng dồn'}
							/>
							<Typography
								tag={'p'}
								variant={'caption_14px_400'}
								className={'text-neutral-400'}>
								Khuyến mãi này sẽ được kết hợp với các chương trình ưu đãi hiện
								có (ví dụ: bạn có ưu đãi 20% và thêm khuyến mãi kép 10%, tổng ưu
								đãi sẽ là 30%). <br />
								Không chỉ vậy, bạn cũng có thể kết hợp với các khuyến mãi kép
								đang chạy khác.
							</Typography>
						</div>
					</div>
				)}
			/>
		</div>
	);
};

export default StackablePromotionOption;