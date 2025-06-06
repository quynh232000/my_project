import { cn } from '@/lib/utils';
import Typography from '@/components/shared/Typography';

export default function OnboardingNotice ({ className }: ClassNameProp) {
	return (
		<div className={cn('', className)}>
			<div className={'flex items-center gap-1.5'}>
				{Array.from({ length: 4 }).map((_, index) => (
					<div key={index} className={'size-5 rounded-[3px] bg-neutral-200'} />
				))}
			</div>
			<Typography tag='p' variant={'content_16px_700'} className={'mt-5 text-gray-500'}>BƯỚC 1 / 4</Typography>
			<Typography tag='p' variant={'headline_48px_700'} className={'mt-14 text-pretty pr-14'}>
				Chúng tôi cần một số thông tin về chỗ nghỉ của bạn
			</Typography>
			<Typography tag='p' variant={'content_16px_400'} className={'mt-[30px] text-pretty pr-24 text-neutral-400'}>
				Dữ liệu này cần thiết để chúng tôi có thể dễ dàng cung cấp giải pháp phù
				hợp với khả năng của công ty bạn.
			</Typography>
		</div>
	)
}

