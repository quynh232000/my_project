import { IconSearch } from '@/assets/Icons/outline';
import IconArrowRepeat from '@/assets/Icons/outline/IconArrowRepeat';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import {
	Dialog,
	DialogClose,
	DialogContent,
	DialogDescription,
	DialogFooter,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { Separator } from '@/components/ui/separator';
import useDebounce from '@/hooks/use-debounce';
import { updateHotelServices } from '@/services/accommodation/updateHotelService';
import { IService } from '@/services/service/getServices';
import { useAccommodationProfileStore } from '@/store/accommodation-profile/store';
import { useLoadingStore } from '@/store/loading/store';
import { useServiceStore } from '@/store/services/store';
import { normalizeText } from '@/utils/string/remove-accent';
import { useCallback, useEffect, useMemo, useState } from 'react';
import { Controller, useForm } from 'react-hook-form';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

export interface ISearchedAmenity {
	parentId: number;
	id: number;
	name: string;
}

interface FormValues {
	[key: string]: string[];
}

interface AmenitiesAndServicesProps {
	onNext: () => void;
}

export default function AmenitiesAndServices({
	onNext,
}: AmenitiesAndServicesProps) {
	const setLoading = useLoadingStore((state) => state.setLoading);
	const hotelServiceList = useServiceStore((state) => state.hotelServiceList);
	const { services, fetchServices, setServices } = useAccommodationProfileStore(
		useShallow((state) => ({
			services: state.services,
			fetchServices: state.fetchServices,
			setServices: state.setServices,
		}))
	);
	const fetchHotelServiceList = useServiceStore(
		(state) => state.fetchHotelServiceList
	);

	const { control, handleSubmit, watch, reset, setValue } =
		useForm<FormValues>();

	const selectedItem = watch();

	const [searchResult, setSearchResult] = useState<ISearchedAmenity[] | null>(
		null
	);
	const [showModal, setShowModal] = useState<boolean>(false);

	const bulkSelectOptions = useMemo(
		() =>
			hotelServiceList.reduce(
				(acc, curr) => ({
					...acc,
					[`${curr.id}`]: curr.children.map((item) => `${item.id}`),
				}),
				{}
			),
		[hotelServiceList]
	);

	const handleBulkSelect = useCallback(
		(checked: boolean) => {
			reset(checked ? bulkSelectOptions : { 0: [] });
		},
		[bulkSelectOptions, reset]
	);

	const normalizedAmenities = useMemo(
		() =>
			hotelServiceList.reduce(
				(acc, group) => {
					group.children.forEach((item) => {
						acc[item.id] = normalizeText(item.name);
					});
					return acc;
				},
				{} as Record<number, string>
			),
		[hotelServiceList]
	);

	useEffect(() => {
		(async () => {
			setLoading(true);
			Promise.all([fetchServices(), fetchHotelServiceList()]).finally(() =>
				setLoading(false)
			);
		})();
	}, []);

	useEffect(() => {
		if (!!services) {
			const defaultValues = services.reduce(
				(acc, group) => {
					if (group?.id && Array.isArray(group.children)) {
						acc[group.id] = group.children.map((child) => String(child.id));
					}
					return acc;
				},
				{} as Record<string, string[]>
			);
			reset(defaultValues);
		}
	}, [services]);

	const onSubmit = async (data: FormValues) => {
		try {
			setLoading(true);
			const result = Object.values(data)
				.filter((item) => Array.isArray(item))
				.flat()
				.map((item) => Number(item));
			const res = await updateHotelServices({ type: 'hotel', ids: result });
			if (res && res.status) {
				toast.success(res.message);
				const selectedService: IService[] =
					hotelServiceList?.map((serviceGroup) => ({
						...serviceGroup,
						children:
							serviceGroup?.children?.filter((item) =>
								(data?.[`${serviceGroup.id}`] ?? []).includes(String(item.id))
							) ?? [],
					})) ?? [];
				setServices(selectedService);
			} else {
				toast.error('Có lỗi xảy ra, vui lòng thử lại!');
			}
		} catch (error) {
			toast.error('Có lỗi xảy ra, vui lòng thử lại!');
			console.log(error);
		} finally {
			setLoading(false);
		}
	};

	const onSearch = useDebounce((val: string) => {
		if (!val) {
			setSearchResult(null);
			return;
		}
		const results: ISearchedAmenity[] = [];
		hotelServiceList.forEach((group) =>
			group.children.forEach((item) => {
				if (normalizedAmenities[item.id].includes(normalizeText(val))) {
					results.push({
						parentId: item.parent_id,
						id: item.id,
						name: item.name,
					});
				}
			})
		);
		setSearchResult(results);
	}, 200);

	const selectedItemsCount = useMemo(
		() =>
			Object.values(selectedItem)
				?.filter((item) => !!item)
				?.flat()?.length ?? 0,
		[selectedItem]
	);

	const filteredAmenityGroups = useMemo(
		() =>
			Object.entries(selectedItem)
				.filter(([_, item]) => (item?.length ?? 0) > 0)
				.map(([id, item]) => {
					const amenityGroup = hotelServiceList.find(
						(data) => `${data.id}` === id
					);
					return { id, item, amenityGroup };
				}),
		[selectedItem, hotelServiceList]
	);

	return (
		<form onSubmit={handleSubmit(onSubmit)}>
			<div className={'w-full rounded-xl bg-white'}>
				<div className={'grid grid-cols-5 gap-4'}>
					<div className={'col-span-12 lg:col-span-2'}>
						<Typography
							tag="p"
							text={'Tìm và duyệt'}
							variant={'caption_14px_700'}
							className={'text-secondary-0-6'}
						/>
						<div className={'border-secondary-0-1 mt-4 rounded-xl border p-4'}>
							<div className="relative w-full">
								<IconSearch
									className={
										'absolute left-3 top-1/2 -translate-y-1/2 transform text-gray-500'
									}
								/>
								<Input
									type="text"
									placeholder="Tìm tiện nghi khách sạn"
									clearable={true}
									className={
										'h-12 border-transparent bg-neutral-50 pl-10 font-semibold focus:border-other-divider focus:bg-white'
									}
									startAdornment={<IconSearch width={20} height={20} />}
									onChange={(e) => onSearch(e.target.value)}
								/>
							</div>

							<ScrollArea className="h-[540px]">
								{searchResult ? (
									<div className={'flex flex-col gap-1 py-4'}>
										{searchResult.length > 0 ? (
											<>
												{searchResult?.map((item, index) => (
													<div
														key={index}
														className={'flex flex-row items-center gap-2'}>
														<Checkbox
															id={`amenity-${item.parentId}-${item.id}`}
															checked={
																!!selectedItem?.[`${item.parentId}`]?.includes(
																	`${item.id}`
																)
															}
															onCheckedChange={(checked) => {
																let groupSelected =
																	selectedItem?.[`${item.parentId}`] ?? [];
																if (checked) {
																	groupSelected.push(`${item.id}`);
																} else {
																	groupSelected = groupSelected.filter(
																		(val) => val !== `${item.id}`
																	);
																}
																setValue(`${item.parentId}`, groupSelected);
															}}
															className={
																'duration-800 transition-all ease-in-out'
															}
														/>
														<label
															htmlFor={`amenity-${item.parentId}-${item.id}`}
															className={
																'ml-2 cursor-pointer text-base font-normal leading-6'
															}>
															{item.name}
														</label>
													</div>
												))}
											</>
										) : (
											<Typography className={'text-center'}>
												Không tìm thấy kết quả nào
											</Typography>
										)}
									</div>
								) : (
									<>
										<div className={'my-[16px] flex items-center space-x-2'}>
											<Checkbox
												id="categoryAll"
												onCheckedChange={handleBulkSelect}
												checked={
													hotelServiceList.length > 0 &&
													hotelServiceList.every(
														(group) =>
															(group.children?.length ?? 0) ===
															selectedItem?.[`${group.id}`]?.length
													)
												}
											/>
											<label
												htmlFor="categoryAll"
												className={
													'text-secondary-0-6 ml-2 cursor-pointer text-base font-bold leading-6'
												}>
												Chọn tất cả các tiện ích
												<span
													className={
														'ml-1 text-base font-bold leading-6 text-neutral-300'
													}>
													(
													{hotelServiceList.reduce(
														(total, section) => total + section.children.length,
														0
													)}
													)
												</span>
											</label>
										</div>
										{hotelServiceList?.map((amenityGroup, index) => (
											<div key={index} className={'pr-4'}>
												<Separator />
												<Controller
													name={`${amenityGroup.id}`}
													control={control}
													render={({ field }) => (
														<div className={'my-4 pl-7'}>
															<div
																className={'flex flex-row items-center gap-2'}>
																<Checkbox
																	id={`amenity-${amenityGroup.id}`}
																	checked={
																		field.value?.length ===
																		amenityGroup?.children?.length
																	}
																	onCheckedChange={(checked) => {
																		field.onChange(
																			checked
																				? (amenityGroup?.children?.map(
																						(item) => `${item.id}`
																					) ?? [])
																				: []
																		);
																	}}
																/>
																<label
																	htmlFor={`amenity-${amenityGroup.id}`}
																	className={
																		'text-secondary-0-6 cursor-pointer text-base font-bold leading-6'
																	}>
																	{amenityGroup?.name}
																	<Typography
																		tag="span"
																		className="ml-1 text-neutral-300">
																		({amenityGroup?.children?.length})
																	</Typography>
																</label>
															</div>
															<ul className={'mt-3'}>
																{amenityGroup?.children?.map((item, index) => (
																	<li
																		key={index}
																		className={'mt-1 flex items-center pl-7'}>
																		<Checkbox
																			id={`amenity-${amenityGroup.id}-${item.id}`}
																			checked={
																				!!field.value?.includes(`${item.id}`)
																			}
																			onCheckedChange={(checked) => {
																				const newValues = checked
																					? [
																							...(field.value ?? []),
																							`${item.id}`,
																						]
																					: (field.value?.filter(
																							(val: string) =>
																								val !== `${item.id}`
																						) ?? []);
																				field.onChange(newValues);
																			}}
																		/>
																		<label
																			htmlFor={`amenity-${amenityGroup.id}-${item.id}`}
																			className={
																				'ml-2 cursor-pointer text-base font-normal leading-6'
																			}>
																			{item.name}
																		</label>
																	</li>
																))}
															</ul>
														</div>
													)}
												/>
											</div>
										))}
									</>
								)}
								<ScrollBar />
							</ScrollArea>
						</div>
					</div>

					<div className={'col-span-12 flex flex-col rounded-xl lg:col-span-3'}>
						<div className={'flex justify-between'}>
							<Typography
								tag="p"
								variant="caption_14px_700"
								className={'text-secondary-0-6'}>
								Tiện ích đã chọn
								<Typography tag="span" className={'ml-1 text-neutral-300'}>
									({selectedItemsCount})
								</Typography>
							</Typography>

							{selectedItemsCount > 0 && (
								<p
									onClick={() => setShowModal(true)}
									className={'flex cursor-pointer items-center gap-2'}>
									<IconArrowRepeat />
									<Typography
										tag="span"
										variant="caption_14px_600"
										className={'text-accent-03'}>
										Đặt lại toàn bộ tiện ích
									</Typography>
								</p>
							)}
						</div>

						<ScrollArea
							className={
								'border-secondary-0-1 mt-4 flex-1 rounded-xl border p-6'
							}>
							<div className={'grid grid-cols-2 gap-4'}>
								{filteredAmenityGroups.map(({ id, item, amenityGroup }) => (
									<div key={id} className={''}>
										<Typography
											tag="p"
											variant="caption_14px_700"
											className={'text-secondary-0-6'}>
											{amenityGroup?.name}{' '}
											<Typography
												tag="span"
												variant="caption_14px_700"
												className={'text-neutral-300'}>
												({item.length})
											</Typography>
										</Typography>
										<ul className={'mt-2 space-y-2'}>
											{amenityGroup?.children
												?.filter((amenity) => item.includes(`${amenity.id}`))
												?.map((amenity, index) => (
													<li
														key={index}
														className={
															'text-secondary-0-6 px-2 py-1 text-base font-normal leading-6'
														}>
														{amenity.name}
													</li>
												))}
										</ul>
									</div>
								))}
							</div>

							{selectedItemsCount === 0 && (
								<div
									className={
										'flex h-full w-full flex-col items-center justify-center gap-4'
									}>
									<Typography
										text={'Chưa có tiện ích nào được chọn'}
										className={'text-secondary-0-6 text-md font-bold leading-6'}
									/>
									<Typography
										tag="p"
										variant="caption_14px_500"
										className={'text-secondary-0-6 text-center'}>
										Tìm và duyệt các tiện ích mà chỗ nghỉ của bạn đang có ở cột
										bên trái. <br />
										Sau khi chọn sẽ xuất hiện tại đây.
									</Typography>
								</div>
							)}
							<ScrollBar />
						</ScrollArea>
					</div>
				</div>

				<div className={'mt-5 flex justify-end gap-2'}>
					<Dialog
						open={showModal}
						onOpenChange={(change) => setShowModal(change)}>
						<DialogContent
							hideButtonClose={true}
							className={'gap-10 p-8 pt-[50px] sm:max-w-md'}>
							<DialogHeader>
								<DialogTitle
									className={`text-center ${TextVariants.headline_18px_700}`}>
									Xóa tất cả tiện ích đã chọn
								</DialogTitle>
								<DialogDescription
									className={`text-center ${TextVariants.content_16px_400}`}>
									Thao tác này sẽ xóa toàn bộ tiện ích mà bạn đã chọn. Bạn có
									chắc chắc muốn tiếp tục?
								</DialogDescription>
							</DialogHeader>
							<DialogFooter className={'sm:justify-start'}>
								<div className={'flex w-full justify-center gap-3'}>
									<DialogClose asChild>
										<Button variant={'secondary'}>Giữ lại</Button>
									</DialogClose>
									<DialogClose asChild>
										<Button
											variant={'destructive'}
											className={'rounded-xl bg-red-400 text-white'}
											onClick={() => {
												handleBulkSelect(false);
											}}>
											Xóa tiện ích
										</Button>
									</DialogClose>
								</div>
							</DialogFooter>
						</DialogContent>
					</Dialog>
					<ButtonActionGroup actionCancel={onNext} className={'mt-0'} />
				</div>
			</div>
		</form>
	);
}
