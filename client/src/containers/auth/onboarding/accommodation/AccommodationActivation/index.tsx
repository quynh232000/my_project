import { AccommodationContainer } from '@/containers/auth/onboarding/accommodation/common/AccommodationContainer';
import SelectPopover from '@/components/shared/Select/SelectPopover';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import IconPlus from '@/assets/Icons/outline/IconPlus';
import Typography from '@/components/shared/Typography';

export default function AccommodationActivation() {
	return (
		<AccommodationContainer title={'Bước cuối cùng để kích hoạt chỗ nghỉ'}>
			<div className={'grid grid-cols-2 gap-4'}>
				<SelectPopover
					label={'Giờ nhận phòng'}
					data={[]}
					renderItem={() => <div />}
				/>
				<SelectPopover
					label={'Giờ nhận phòng'}
					data={[]}
					renderItem={() => <div />}
				/>
			</div>
			<div className={'mt-4'}>
				<div className={'mb-2 flex items-center justify-between'}>
					<Label htmlFor={'hotel-avatar'} containerClassName={'mb-0'}>
						Ảnh đại diện
					</Label>
					<div className={'flex items-center'}>
						<Input
							type={'checkbox'}
							id={'check-upload-avatar'}
							className={'size-5'}
						/>
						<Label containerClassName={'ml-2 mb-0'}>
							Tải lên sau
						</Label>
					</div>
				</div>
				<Input id={'hotel-avatar'} type={'file'} className={'hidden'} />
				<Label
					htmlFor={'hotel-avatar'}
					className={
						'border-neutral-5 w-full cursor-pointer space-y-1 rounded-xl border border-dashed p-4 text-center'
					}>
					<div
						className={
							'mx-auto flex size-8 items-center justify-center rounded-full bg-[#EAF3FF]'
						}>
						<IconPlus width={16} height={16} color={'#2A85FF'} />
					</div>
					<Typography tag="p" variant={'caption_14px_600'}>
						Kéo và thả tệp vào đây, hoặc duyệt
					</Typography>
					<Typography tag="p" variant={'caption_14px_400'}>
						Giữ hình ảnh dưới 5MB và định dạng JPEG nếu có thể.
						<br /> Kích thước tối thiểu:{' '}
						<Typography tag="span" className={'text-nowrap'}>
							684px x 456px
						</Typography>
					</Typography>
				</Label>
			</div>
		</AccommodationContainer>
	);
}
