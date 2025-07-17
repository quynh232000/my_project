import { AccommodationContainer } from '@/containers/auth/onboarding/accommodation/common/AccommodationContainer';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import IconStarFill from '@/assets/Icons/outline/IconStarFill';
import Typography from '@/components/shared/Typography';

export default function AccommodationSizeSelector() {
	return (
		<AccommodationContainer
			title={'Quy mô chỗ ở của bạn'}
			className={'space-y-4'}>
			<>
				<Label>Tên chỗ nghỉ</Label>
				<Input
					type={'text'}
					placeholder={'Ví dụ: Sheraton Saigon Grand Opera Hotel'}
				/>
			</>
			<>
				<Label>Tổng số phòng</Label>
				<Input type={'text'} placeholder={'Ví dụ: 5, 20, 50…'} />
			</>
			<>
				<Label>
					{' '}
					Sức chứa tối đa{' '}
					<Typography tag="span" className={'text-neutral-400'}>
						(tổng số khách có thể tiếp nhận)
					</Typography>
				</Label>
				<Input type={'text'} placeholder={'Ví dụ: 5, 20, 50…'} />
			</>
			<>
				<Label>Hạng sao</Label>
				<div className={'flex'}>
					{Array.from({ length: 5 }).map((_, index) => (
						<IconStarFill
							width={24}
							height={24}
							color={'#E6E8EC'}
							key={index}
						/>
					))}
				</div>
			</>
		</AccommodationContainer>
	);
}
