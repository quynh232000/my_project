import SelectPopup from '@/components/shared/Select/SelectPopup';
import Typography from '@/components/shared/Typography';
import Editor from '@/components/ui/editor';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { NumberInput } from '@/components/ui/number-input';
import { AccommodationInfo } from '@/lib/schemas/property-profile/general-information';
import { useLanguageStore } from '@/store/languages/store';
import { useFormContext } from 'react-hook-form';

export default function IntroductionInfo() {
	const { control } = useFormContext<AccommodationInfo>();
	const languageList = useLanguageStore((state) => state.languageList);

	return (
		<div className={'space-y-6'}>
			<Typography
				tag={'h1'}
				text={'Giới thiệu về chỗ nghỉ'}
				className={
					'text-md font-semibold leading-6 tracking-[-0.32px] text-neutral-700'
				}
			/>
			<div className={'space-y-4'}>
				<div className={'grid grid-cols-3 gap-4'}>
					<div className={'col-span-12 lg:col-span-1'}>
						<FormField
							name="introduction.construction_year"
							control={control}
							render={({ field }) => (
								<FormItem className={'col-span-1 space-y-2'}>
									<FormLabel required>Năm xây dựng</FormLabel>
									<FormControl>
										<Input
											type="number"
											placeholder="2015"
											maxLength={4}
											inputMode={'numeric'}
											className={'h-[44px] py-2 leading-6'}
											{...field}
											value={
												field.value && !Number.isNaN(field.value)
													? field.value
													: ''
											}
											onChange={(e) => field.onChange(Number(e.target.value))}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>
					</div>
					<div className={'col-span-12 lg:col-span-1'}>
						<FormField
							name="introduction.bar_count"
							control={control}
							render={({ field: { value, onChange, ...props } }) => (
								<FormItem className={'col-span-1 space-y-2'}>
									<FormLabel required>Số quán bar</FormLabel>
									<FormControl>
										<NumberInput
											placeholder="1"
											inputMode={'numeric'}
											value={value}
											suffix={''}
											className={'h-[44px] py-2 leading-6'}
											{...props}
											onValueChange={(e) => {
												onChange(e.value.length === 0 ? '' : Number(e.value));
											}}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>
					</div>
					<div className={'col-span-12 lg:col-span-1'}>
						<FormField
							name="introduction.floor_count"
							control={control}
							render={({ field: { value, onChange, ...props } }) => (
								<FormItem className={'col-span-1 space-y-2'}>
									<FormLabel required>Số tầng</FormLabel>
									<FormControl>
										<NumberInput
											placeholder="1"
											inputMode={'numeric'}
											suffix={''}
											value={value}
											className={'h-[44px] py-2 leading-6'}
											{...props}
											onValueChange={(e) => {
												onChange(e.value.length === 0 ? '' : Number(e.value));
											}}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>
					</div>
				</div>
				<div className={'grid grid-cols-3 gap-4'}>
					<div className={'col-span-12 lg:col-span-1'}>
						<FormField
							name="introduction.restaurant_count"
							control={control}
							render={({ field: { value, onChange, ...props } }) => (
								<FormItem className={'col-span-1 space-y-2'}>
									<FormLabel required>Số nhà hàng</FormLabel>
									<FormControl>
										<NumberInput
											placeholder="1"
											inputMode={'numeric'}
											suffix={''}
											value={value}
											{...props}
											className={'h-[44px] py-2 leading-6'}
											onValueChange={(e) => {
												onChange(e.value.length === 0 ? '' : Number(e.value));
											}}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>
					</div>
					<div className={'col-span-12 lg:col-span-1'}>
						<FormField
							name="introduction.language"
							control={control}
							render={({ field: { value, onChange, ...props } }) => (
								<FormItem className={'col-span-1 space-y-2'}>
									<FormLabel required>Ngôn ngữ hỗ trợ</FormLabel>
									<FormControl>
										<SelectPopup
											placeholder={'Chọn ngôn ngữ hỗ trợ'}
											labelClassName="mb-2"
											onChange={onChange}
											selectedValue={value}
											className="h-[44px] rounded-lg bg-white py-2"
											controllerRenderProps={props}
											data={languageList.map((item) => ({
												label: item.name,
												value: String(item.id),
											}))}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>
					</div>
				</div>
				<FormField
					name={'introduction.description'}
					control={control}
					render={({ field }) => (
						<FormItem>
							<FormControl>
								<Editor content={field.value ?? ''} onChange={field.onChange} />
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>
			</div>
		</div>
	);
}
