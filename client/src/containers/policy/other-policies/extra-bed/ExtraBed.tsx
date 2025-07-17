'use client';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import Typography from '@/components/shared/Typography';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { getPolicyOtherDetail } from '@/services/policy/other/getPolicyOtherDetail';
import { updatePolicyOther } from '@/services/policy/other/updatePolicyOther';
import { useLoadingStore } from '@/store/loading/store';
import { useOtherPolicyStore } from '@/store/other-policy/store';
import { TPolicyExtraBed } from '@/store/other-policy/type';
import { useRouter } from 'next/navigation';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';

export default function ExtraBed() {
	const router = useRouter();

	const setOtherPolicy = useOtherPolicyStore((state) => state.setOtherPolicy);
	const setLoading = useLoadingStore((state) => state.setLoading);

	const [enable, setEnable] = useState(false);

	const handlerShow = (value: string) => {
		setEnable(value === 'true');
	};

	useEffect(() => {
		(async () => {
			setLoading(true);
			const data = await getPolicyOtherDetail<{ is_active: boolean }>({
				slug: 'extra-bed',
			});
			if (data) {
				setEnable(data.is_active);
			}
			setLoading(false);
		})();
	}, []);

	const handleSubmit = async () => {
		try {
			setLoading(true);
			const res = await updatePolicyOther<TPolicyExtraBed>({
				slug: 'extra-bed',
				is_active: enable,
			});
			if (res?.status) {
				toast.success(
					'Cập nhật chính sách nôi/cũi và giường phụ thành công'
				);
				setOtherPolicy([]);
			}
			setLoading(false);
		} catch (error) {
			console.error(error);
		}
	};

	return (
		<>
			<Typography
				tag={'p'}
				text={
					'Chỗ nghĩ của bạn có chính sách nôi/cũi và giường phụ không?'
				}
				variant={'content_16px_600'}
			/>
			<RadioGroup
				className={'mt-4'}
				value={`${enable}`}
				onValueChange={handlerShow}>
				<div className="flex items-center">
					<RadioGroupItem
						id={'r2'}
						value="false"
						className={
							'border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-white data-[state=checked]:text-secondary-500'
						}
					/>
					<Label
						htmlFor="r2"
						containerClassName={'m-0 ml-2'}
						className={
							'cursor-pointer text-base font-normal leading-6'
						}>
						Không cho phép
					</Label>
				</div>
				<div className="flex items-center">
					<RadioGroupItem
						id={'r3'}
						value="true"
						className={
							'border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-white data-[state=checked]:text-secondary-500'
						}
					/>
					<Label
						htmlFor="r3"
						containerClassName={'m-0 ml-2'}
						className={
							'cursor-pointer text-base font-normal leading-6'
						}>
						Linh hoạt tùy loại phòng
					</Label>
				</div>
			</RadioGroup>

			{enable && (
				<ul className="mt-2 list-disc px-10 text-base font-normal leading-6 text-neutral-400">
					<li>
						Chính sách nôi/cũi và giường phụ tùy thuộc vào loại
						phòng đã được thiết lập ở từng loại phòng đó.
					</li>
					<li>
						Phí giường phụ thuộc và cũi chưa được bao gồm trong số
						tổng giá và khách phải thanh toán tạ khách sạn.
					</li>
				</ul>
			)}
			<ButtonActionGroup
				actionCancel={() => router.back()}
				actionSubmit={handleSubmit}
			/>
		</>
	);
}
