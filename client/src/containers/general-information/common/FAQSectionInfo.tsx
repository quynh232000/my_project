import React from 'react';
import IconIdea from '@/assets/Icons/outline/IconIdea';
import FAQItem from '@/containers/general-information/common/FAQItem';
import Typography from "@/components/shared/Typography";

export default function FaqSectionInfo() {
	return (
		<div className={'space-y-4'}>
			<Typography text={"Câu hỏi thường gặp"} className={"text-md font-semibold leading-6 tracking-[-0.32px] text-neutral-700"} />
			{Array(5) .fill(null).map((_, i) => (
					<FAQItem index={i} key={i} />
			))}
			<div className={'flex items-center gap-[6px]'}>
				<IconIdea />

				<Typography tag='span'variant='caption_12px_500'
					text='Tip nhỏ: Hãy viết câu trả lời ngắn gọn, rõ ràng và dễ hiểu để tăng
						trải nghiệm khách hàng!' className='italic text-neutral-600'>
				</Typography>
			</div>
		</div>
	)
}

