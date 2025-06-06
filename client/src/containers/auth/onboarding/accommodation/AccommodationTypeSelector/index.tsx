import { AccommodationTypeSelectorData } from '@/containers/auth/onboarding/accommodation/AccommodationTypeSelector/data';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { AccommodationContainer } from '@/containers/auth/onboarding/accommodation/common/AccommodationContainer';
import { TextVariants } from '@/components/shared/Typography/TextVariants';

export default function AccommodationTypeSelector() {
	return (
		<AccommodationContainer title={'Lựa chọn loại hình chỗ nghỉ của bạn'}>
			<div className={'grid grid-cols-2 gap-3'}>
				{AccommodationTypeSelectorData.map((item, index) => (
					<div key={index} className={'flex items-center gap-4 rounded-lg_plus border border-other-divider px-4 py-3'}>
						<Input type="radio" id={item.title} name="accommodation-type" value={item.title} className={'size-6'} />
						<Label htmlFor={item.title} containerClassName={'mb-0'} className={TextVariants.caption_14px_600}>{item.title}</Label>
					</div>
				))}
			</div>
		</AccommodationContainer>
	)
}

