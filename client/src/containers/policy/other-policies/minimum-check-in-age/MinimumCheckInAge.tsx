'use client';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Checkbox } from '@/components/ui/checkbox';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { Label } from '@/components/ui/label';
import { NumberInput } from '@/components/ui/number-input';
import { Switch } from '@/components/ui/switch';
import {
	AgePolicyFormValue,
	agePolicySchema,
} from '@/lib/schemas/policy/otherPolicy';
import { cn } from '@/lib/utils';
import { getPolicyOtherDetail } from '@/services/policy/other/getPolicyOtherDetail';
import { updatePolicyOther } from '@/services/policy/other/updatePolicyOther';
import { useAttributeStore } from '@/store/attributes/store';
import { useLoadingStore } from '@/store/loading/store';
import { useOtherPolicyStore } from '@/store/other-policy/store';
import {
	TAdultRequire,
	TDocumentRequire,
	TPolicyMinimumCheckInAge,
} from '@/store/other-policy/type';
import { zodResolver } from '@hookform/resolvers/zod';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

export default function MinimumCheckInAge() {
	const router = useRouter();
	const {
		data: { age },
		setOtherPolicy,
	} = useOtherPolicyStore(
		useShallow((state) => ({
			data: state.data,
			setOtherPolicy: state.setOtherPolicy,
		}))
	);
	const setLoading = useLoadingStore((state) => state.setLoading);

	const {
		duccumentRequireList,
		adultRequireList,
		fetchAdultRequireList,
		fetchDuccumentRequireList,
	} = useAttributeStore(
		useShallow((state) => ({
			duccumentRequireList: state.duccumentRequireList,
			adultRequireList: state.adultRequireList,
			fetchAdultRequireList: state.fetchAdultRequireList,
			fetchDuccumentRequireList: state.fetchDuccumentRequireList,
		}))
	);

	useEffect(() => {
		(async () => {
			setLoading(true);
			await Promise.all([
				fetchAdultRequireList(),
				fetchDuccumentRequireList(),
			]);
			setLoading(false);
		})();
	}, []);

	const form = useForm<AgePolicyFormValue>({
		resolver: zodResolver(agePolicySchema),
		defaultValues: age,
	});

	useEffect(() => {
		(async () => {
			setLoading(true);
			const data = await getPolicyOtherDetail<
				TPolicyMinimumCheckInAge['settings']
			>({ slug: 'minimum-check-in-age' });
			if (data) {
				form.reset(data.settings);
			}
			setLoading(false);
		})();
	}, []);

	const onSubmit = async (data: AgePolicyFormValue) => {
		try {
			const updateData = {
				slug: 'minimum-check-in-age',
				settings: {
					...data,
					doccument_require:
						data.duccument_require as TDocumentRequire[],
					adult_require: data.adult_require as TAdultRequire[],
				},
			};
			setLoading(true);
			const res =
				await updatePolicyOther<TPolicyMinimumCheckInAge>(updateData);
			if (res?.status) {
				toast.success(
					'Cập nhật chính sách độ tuổi tối thiểu nhận phòng thành công'
				);
				setOtherPolicy([]);
			}
			setLoading(false);
		} catch (error) {
			console.error(error);
		}
	};

	return (
		<Form {...form}>
			<form onSubmit={form.handleSubmit(onSubmit)}>
				<FormField
					name="age"
					control={form.control}
					render={({ field: { onChange, value, ...props } }) => (
						<FormItem>
							<FormLabel required>
								Độ tuổi tối thiểu nhận phòng
							</FormLabel>
							<FormControl>
								<NumberInput
									inputMode={'numeric'}
									maxLength={2}
									suffix={''}
									placeholder="Nhập số tuổi tối thiểu nhận phòng"
									value={value}
									className={cn(
										'h-[44px] py-2 leading-6',
										TextVariants.caption_14px_400
									)}
									{...props}
									onValueChange={(e) => {
										onChange(
											e.value.length === 0
												? NaN
												: Number(e.value)
										);
									}}
								/>
							</FormControl>
							<FormMessage />
						</FormItem>
					)}
				/>

				<Typography
					tag="p"
					text="Khách đi dưới độ tuổi này phải có người lớn đi cùng khi nhận phòng"
					variant={'caption_12px_500'}
					className={'mb-6 mt-1 text-neutral-400'}
				/>
				<>
					<FormField
						name="duccument_require"
						control={form.control}
						render={({ field }) => (
							<div>
								<FormLabel className="mb-2 text-md font-semibold leading-6 text-neutral-900">
									Yêu cầu giấy tờ xác minh
								</FormLabel>
								<FormItem>
									{duccumentRequireList &&
										duccumentRequireList.length > 0 &&
										duccumentRequireList.map((item) => (
											<div
												key={item.id}
												className="flex flex-row items-center space-x-3 space-y-0">
												<FormControl>
													<Checkbox
														id={`document-${item.id}`}
														checked={field.value.includes(
															item.slug
														)}
														onCheckedChange={(
															checked
														) => {
															field.onChange(
																checked
																	? [
																			...field.value,
																			item.slug,
																		]
																	: field.value.filter(
																			(
																				val
																			) =>
																				val !==
																				item.slug
																		)
															);
														}}
													/>
												</FormControl>
												<FormLabel
													htmlFor={`document-${item.id}`}
													className={`${TextVariants.caption_14px_400} cursor-pointer text-neutral-600`}>
													{item.name}
												</FormLabel>
											</div>
										))}

									<FormMessage />
								</FormItem>
							</div>
						)}
					/>
				</>

				<>
					<Typography
						tag={'p'}
						text={'Yêu cầu người lớn đi kèm'}
						className={'mt-6 text-md font-semibold leading-6'}
					/>
					<Typography
						tag={'p'}
						text={'Đối vs khách dưới độ tổi tối thiểu'}
						className={
							'mb-4 mt-1 text-sm font-medium leading-4 text-neutral-400'
						}
					/>
					<FormField
						name="adult_require"
						control={form.control}
						render={({ field }) => (
							<>
								{adultRequireList &&
									adultRequireList.map((item) => (
										<FormItem
											key={item.id}
											className="mt-2 flex flex-row items-center space-x-3 space-y-0">
											<FormControl>
												<Checkbox
													id={`accompany-${item.id}`}
													checked={field.value?.includes(
														item.slug
													)}
													onCheckedChange={(
														checked
													) => {
														field.onChange(
															checked
																? [
																		...field.value,
																		item.slug,
																	]
																: field.value.filter(
																		(val) =>
																			val !==
																			item.slug
																	)
														);
													}}
												/>
											</FormControl>
											<FormLabel
												htmlFor={`accompany-${item.id}`}
												className={`${TextVariants.caption_14px_400} cursor-pointer text-neutral-600`}>
												{item.name}
											</FormLabel>
										</FormItem>
									))}

								<FormMessage className={'mt-2'} />
							</>
						)}
					/>
				</>
				<div className={'mt-4 flex items-center gap-2'}>
					<FormField
						name="accompanying_adult_proof"
						control={form.control}
						render={({ field }) => (
							<>
								<Switch
									id={'needAccompanyDocument'}
									checked={field.value}
									onCheckedChange={field.onChange}
								/>
								<FormMessage />
							</>
						)}
					/>
					<Label
						htmlFor={'needAccompanyDocument'}
						containerClassName={'m-0'}
						className={
							'm-0 cursor-pointer text-base font-normal leading-6 text-neutral-600'
						}>
						Người lớn đi kèm phải xuất trình giấy tờ chứng minh mối
						quan hệ với trẻ
					</Label>
				</div>
				<ButtonActionGroup actionCancel={() => router.back()} />
			</form>
		</Form>
	);
}
