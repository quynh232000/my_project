import React from 'react';
import {
	FormControl,
	FormField,
	FormItem,
	FormMessage,
} from '@/components/ui/form';
import { AccommodationInfo } from '@/lib/schemas/property-profile/general-information';
import { useFormContext, useWatch } from 'react-hook-form';
import { Input } from '@/components/ui/input';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import Typography from '@/components/shared/Typography';

export default function FaqItem({ index }: { index: number }) {
	const { control } = useFormContext<AccommodationInfo>();

	const [question, answer] = useWatch({
		control,
		name: [`faq.${index}.question`, `faq.${index}.reply`],
	});

	return (
		<div className={'space-y-2'}>
			<div
				className={
					'text-base font-semibold leading-6 text-neutral-700'
				}>
				# Câu số {index + 1}
			</div>
			<div
				className={
					'overflow-hidden rounded-lg border-2 border-other-divider-02'
				}>
				<FormField
					name={`faq.${index}.question`}
					control={control}
					render={({ field }) => (
						<FormItem
							className={
								'flex items-stretch space-y-0 border-b-2 border-other-divider-02'
							}>
							<div
								className={
									'flex w-[88px] items-center justify-start border-r-2 border-other-divider-02 bg-secondary-00 p-3 text-base font-medium leading-6 text-neutral-600'
								}>
								Câu hỏi
							</div>
							<div className={'flex flex-1 flex-col'}>
								<FormControl>
									<Input
										placeholder={'Nhập câu hỏi...'}
										maxLength={100}
										{...field}
										className={`h-[52px] w-full resize-none rounded-none border-none px-3 py-2 outline-none ${TextVariants.caption_14px_400}`}
										onChange={(e) => {
											field.onChange(e);
										}}
									/>
								</FormControl>
								<FormMessage
									className={'!bg-[#cf19190d] px-3'}
								/>
							</div>
							<div
								className={
									'flex items-center p-3 text-sm font-medium leading-4 text-neutral-400'
								}>
								<Typography
									tag="span"
									variant={'caption_12px_500'}>
									{question?.length ?? '0'}
								</Typography>
								/100
							</div>
						</FormItem>
					)}
				/>

				<FormField
					name={`faq.${index}.reply`}
					control={control}
					render={({ field }) => (
						<FormItem className={'flex items-stretch space-y-0'}>
							<div
								className={
									'flex w-[88px] items-center justify-start border-r-2 border-other-divider-02 bg-secondary-00 p-3 text-base font-medium leading-6 text-neutral-600'
								}>
								Trả lời
							</div>
							<div className={'flex flex-1 flex-col'}>
								<FormControl>
									<textarea
										placeholder={'Nhập câu trả lời...'}
										maxLength={300}
										{...field}
										className={
											'scrollbar min-h-20 w-full resize-none px-3 py-2 text-base leading-6 text-neutral-600 outline-none placeholder:text-neutral-300'
										}
										onChange={(e) => {
											field.onChange(e);
										}}
									/>
								</FormControl>
								<FormMessage
									className={'!bg-[#cf19190d] px-3'}
								/>
							</div>
							<div
								className={
									'flex items-center justify-end p-3 text-sm font-medium leading-4 text-neutral-400'
								}>
								<Typography
									tag="span"
									variant={'caption_12px_500'}>
									{answer?.length ?? '0'}
								</Typography>
								/300
							</div>
						</FormItem>
					)}
				/>
			</div>
		</div>
	);
}
