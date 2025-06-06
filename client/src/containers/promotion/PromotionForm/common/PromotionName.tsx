import React from 'react';
import { Input } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { useFormContext } from 'react-hook-form';
import { PromotionType } from '@/lib/schemas/discount/discount';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';

const PromotionName = () => {
	const { control } = useFormContext<PromotionType>();
	return (
		<FormField
			control={control}
			name={'name'}
			render={({ field }) => (
				<FormItem className={'space-y-2'}>
					<FormLabel required>Tên khuyến mãi</FormLabel>
					<FormControl>
						<Input
							{...field}
							placeholder={'Early Year Deal'}
							className={cn(
								'h-10 border-other-divider-02 py-2 text-neutral-600',
								TextVariants.caption_14px_400
							)}
						/>
					</FormControl>
					<FormMessage />
				</FormItem>
			)}
		/>
	);
};

export default PromotionName;