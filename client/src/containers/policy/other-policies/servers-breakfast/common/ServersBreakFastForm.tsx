'use client';
import { useEffect } from 'react';
import { useFormContext, useWatch } from 'react-hook-form';
import { Checkbox } from '@/components/ui/checkbox';
import AdditionalBreakfast from '@/containers/policy/other-policies/servers-breakfast/common/AdditionalBreakfast';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import TimePicker from '@/components/ui/time-picker';
import {
	BreakFastServiceFormValue,
	EUseBreakfastType,
} from '@/lib/schemas/policy/otherPolicy';
import { useAttributeStore } from '@/store/attributes/store';
import { mapToLabelValue } from '@/containers/setting-room/helpers';
import { useShallow } from 'zustand/react/shallow';
import { useLoadingStore } from '@/store/loading/store';

export default function ServersBreakFastForm() {
	const { control, setValue, getValues } =
		useFormContext<BreakFastServiceFormValue>();
	const isUseBf = useWatch({ control, name: 'breakfast.isBreakfast' });

	const {
		servingTypeList,
		breakFastTypeList,
		fetchServingTypeList,
		fetchBreakFastTypeList,
	} = useAttributeStore(
		useShallow((state) => ({
			servingTypeList: state.servingTypeList,
			breakFastTypeList: state.breakFastTypeList,
			fetchServingTypeList: state.fetchServingTypeList,
			fetchBreakFastTypeList: state.fetchBreakFastTypeList,
		}))
	);
	const setLoading = useLoadingStore(state => state.setLoading);

	useEffect(() => {
		(async ()=>{
			setLoading(true);
			await Promise.all([fetchServingTypeList(),
			fetchBreakFastTypeList()]).finally(() => setLoading(false))
		})()
	}, []);

	useEffect(() => {
		const extraBf = getValues('breakfast.extra_breakfast');
		if (isUseBf === EUseBreakfastType.yes && extraBf && extraBf.length === 0) {
			setValue('breakfast.extra_breakfast', [
				{ age_from: 0, age_to: null, fee_type: 'free', fee: NaN },
			]);
		} else if (isUseBf === EUseBreakfastType.no) {
			setValue('breakfast.extra_breakfast', []);
		}
	}, [isUseBf]);

	return (
		<div className="mt-[16px]">
			<div className="flex w-full gap-4">
				<div className="grid w-full gap-2">
					<FormField
						name={'breakfast.time_from'}
						control={control}
						render={({ field }) => (
							<FormItem className={'col-span-1 space-y-0'}>
								<FormLabel required className={'m-0'}>
									Giờ phục vụ từ
								</FormLabel>
								<FormControl>
									<TimePicker
										containerClassName={'m-0'}
										triggerLabel={field.value}
										onChange={field.onChange}
										placeholder={'Giờ bắt đầu phục vụ'}
										className={'h-11'}
									/>
								</FormControl>
								<FormMessage className={'pt-2'} />
							</FormItem>
						)}
					/>
				</div>
				<div className="grid w-full gap-2">
					<FormField
						name={'breakfast.time_to'}
						control={control}
						render={({ field }) => (
							<FormItem className={'col-span-1 space-y-0'}>
								<FormLabel required className={'m-0'}>
									Giờ phục vụ đến
								</FormLabel>
								<FormControl>
									<TimePicker
										triggerLabel={field.value}
										onChange={field.onChange}
										placeholder={'Giờ kết thúc phục vụ'}
										className={'h-11'}
									/>
								</FormControl>
								<FormMessage className={'pt-2'} />
							</FormItem>
						)}
					/>
				</div>
			</div>
			<div className="mt-4 flex w-full gap-4">
				<div className="grid w-full gap-2">
					<FormField
						name={'breakfast.serving_type'}
						control={control}
						render={({ field }) => (
							<FormItem className={'col-span-1 space-y-0'}>
								<FormLabel required className={'m-0'}>
									Loại
								</FormLabel>
								<FormControl>
									<SelectPopup
										placeholder="Chọn loại"
										selectedValue={field.value}
										onChange={field.onChange}
										className="h-[44px] rounded-lg bg-white py-2"
										data={servingTypeList ? mapToLabelValue(servingTypeList) : []}
									/>
								</FormControl>
								<FormMessage className={'pt-2'} />
							</FormItem>
						)}
					/>
				</div>
				<div className="grid w-full gap-2">
					<FormField
						name={'breakfast.breakfast_type'}
						control={control}
						render={({ field }) => (
							<FormItem className={'col-span-1 space-y-0'}>
								<FormLabel required className={'m-0'}>
									Kiểu
								</FormLabel>
								<FormControl>
									<SelectPopup
										placeholder="Chọn kiểu"
										selectedValue={field.value}
										onChange={field.onChange}
										className="h-[44px] rounded-lg bg-white py-2"
										data={breakFastTypeList ? mapToLabelValue(breakFastTypeList) : []}
									/>
								</FormControl>
								<FormMessage className={'pt-2'} />
							</FormItem>
						)}
					/>
				</div>
			</div>
			<FormField
				name={'breakfast.isBreakfast'}
				control={control}
				render={({ field }) => (
					<div className="mt-6 flex items-center gap-2">
						<Checkbox
							id="isBreakfast"
							checked={field.value === EUseBreakfastType.yes}
							onCheckedChange={(checked) => {
								field.onChange(
									checked ? EUseBreakfastType.yes : EUseBreakfastType.no
								);
							}}
							className={
								'border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-secondary-500 data-[state=checked]:text-white'
							}
						/>
						<label
							htmlFor="isBreakfast"
							className="cursor-pointer text-md font-semibold leading-6">
							Bữa sáng bổ sung
						</label>
					</div>
				)}
			/>
			{isUseBf === EUseBreakfastType.yes && <AdditionalBreakfast />}
		</div>
	);
}
