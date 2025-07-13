'use client';
import React, { Fragment, useMemo, useState } from 'react';
import Typography from '@/components/shared/Typography';
import { IconSearch } from '@/assets/Icons/outline';
import { Input } from '@/components/ui/input';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Controller, useFormContext } from 'react-hook-form';
import { Separator } from '@/components/ui/separator';
import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import { AmenityType } from '@/containers/setting-room/RoomAmenities/data';
import useDebounce from '@/hooks/use-debounce';
import { normalizeText } from '@/utils/string/remove-accent';
import { IconCloseCircle } from '@/assets/Icons/filled';
import { GlobalUI } from '@/themes/type';

export interface ISearchedAmenity {
	parentId: number;
	id: number;
	name: string;
}

interface Props {
	originalList: AmenityType[];
}

const SearchAndBrowse = ({ originalList }: Props) => {
	const { setValue, control, watch, reset } = useFormContext();
	const selectedItemList = watch();
	const [searchResult, setSearchResult] = useState<ISearchedAmenity[] | null>(
		null
	);
	const [search, setSearch] = useState<string>('');
	const toggleCategoryAll = (checked: boolean) => {
		reset(
			originalList.reduce((acc, cur) => {
				return {
					...acc,
					[`${cur.id}`]: checked
						? cur.children.map((child) => `${child.id}`)
						: [],
				};
			}, {})
		);
	};

	const onSearch = useDebounce((val: string) => {
		if (!val) {
			setSearchResult(null);
			return;
		}
		const results: ISearchedAmenity[] = [];
		originalList.forEach((group) =>
			group.children.forEach((item) => {
				if (normalizeText(item.name).includes(normalizeText(val))) {
					results.push({
						parentId: group.id,
						id: item.id,
						name: item.name,
					});
				}
			})
		);
		setSearchResult(results);
	}, 200);

	const totalAmenities = useMemo(() => {
		return originalList.reduce(
			(acc, amenityGroup) => acc + amenityGroup.children.length,
			0
		);
	}, [originalList]);
	return (
		<div>
			<Typography
				tag={'h3'}
				variant={'caption_14px_700'}
				className={'text-neutral-600'}>
				Tìm và duyệt
			</Typography>
			<div
				className={
					'mt-4 flex h-[550px] flex-col rounded-2xl border border-blue-100 p-4'
				}>
				<Input
					endAdornment={
						search && (
							<IconCloseCircle
								onClick={() => {
									setSearch('');
									onSearch('');
								}}
								fill={GlobalUI.colors.neutrals['300']}
								color="#fff"
								className="size-6 cursor-pointer"
							/>
						)
					}
					startAdornment={<IconSearch className={'size-6'} />}
					id="amenitiesSearch"
					placeholder={'Tìm tiện ích phòng'}
					className={cn(
						'h-12 rounded-xl border-transparent bg-neutral-50 py-2 pr-2 focus:border-primary-500 focus:bg-white',
						TextVariants.caption_14px_600
					)}
					value={search}
					onChange={(e) => {
						setSearch(e.target.value);
						onSearch(e.target.value);
					}}
				/>
				<div
					className={
						'mt-4 flex-1 overflow-y-auto pr-4 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-thumb]:bg-neutral-200 [&::-webkit-scrollbar]:w-[6px]'
					}>
					{!searchResult && (
						<CheckBoxView
							id={'all'}
							value={
								originalList.length > 0 &&
								originalList.every(
									(amenitiesGroup) =>
										amenitiesGroup.children.length ===
										selectedItemList?.[
											`${amenitiesGroup.id}`
										]?.length
								)
							}
							onValueChange={toggleCategoryAll}>
							<Typography
								tag={'p'}
								variant={'caption_14px_700'}
								className={'text-neutral-600'}>
								Chọn tất cả tiện ích
								<span className={'ml-1 text-neutral-300'}>
									({totalAmenities})
								</span>
							</Typography>
						</CheckBoxView>
					)}
					{searchResult ? (
						searchResult.length > 0 ? (
							<>
								{searchResult.map((item, index) => (
									<CheckBoxView
										key={index}
										id={`amenity-${item.parentId}-${index}`}
										value={selectedItemList?.[
											`${item.parentId}`
										]?.includes(`${item.id}`)}
										onValueChange={(val) => {
											let groupSelected: string[] =
												selectedItemList?.[
													`${item.parentId}`
												] ?? [];
											if (val) {
												groupSelected.push(
													`${item.id}`
												);
											} else {
												groupSelected =
													groupSelected.filter(
														(val) =>
															val !== `${item.id}`
													);
											}
											setValue(
												`${item.parentId}`,
												groupSelected
											);
										}}>
										<Typography
											tag={'p'}
											variant={'caption_14px_400'}
											className={'text-neutral-600'}>
											{item.name}
										</Typography>
									</CheckBoxView>
								))}
							</>
						) : (
							<Typography
								className={'text-center'}
								variant={'caption_14px_600'}
								text={'Không tìm thấy kết quả nào'}
							/>
						)
					) : (
						<>
							{originalList.map((amenityGroup, index) => (
								<Controller
									key={`${index}`}
									name={`${amenityGroup.id}`}
									control={control}
									render={({ field }) => (
										<Fragment key={index}>
											<Separator className={'my-4'} />
											<div className={'pl-7'}>
												<CheckBoxView
													id={`amenity-${amenityGroup.id}`}
													value={
														field.value?.length ===
														amenityGroup.children
															.length
													}
													onValueChange={(checked) =>
														field.onChange(
															checked
																? (amenityGroup.children.map(
																		(
																			item
																		) =>
																			`${item.id}`
																	) ?? [])
																: []
														)
													}>
													<Typography
														tag={'p'}
														variant={
															'caption_14px_700'
														}
														className={
															'text-neutral-600'
														}>
														{amenityGroup.title}
													</Typography>
												</CheckBoxView>
												{amenityGroup.children.length >
													0 && (
													<div
														className={cn(
															'mt-3 space-y-1 pl-7'
														)}>
														{amenityGroup.children.map(
															(
																amenity,
																index
															) => (
																<CheckBoxView
																	key={index}
																	id={`amenity-${amenityGroup.id}-${amenity.id}`}
																	value={field.value?.includes(
																		`${amenity.id}`
																	)}
																	onValueChange={(
																		val
																	) => {
																		const newArr =
																			val
																				? [
																						...(field?.value ||
																							[]),
																						`${amenity.id}`,
																					]
																				: (
																						field.value ||
																						[]
																					).filter(
																						(
																							val: string
																						) =>
																							val !==
																							String(
																								amenity.id
																							)
																					);
																		field.onChange(
																			newArr
																		);
																	}}>
																	<Typography
																		tag={
																			'p'
																		}
																		variant={
																			'caption_14px_400'
																		}
																		className={
																			'text-neutral-600'
																		}>
																		{
																			amenity.name
																		}
																	</Typography>
																</CheckBoxView>
															)
														)}
													</div>
												)}
											</div>
										</Fragment>
									)}
								/>
							))}
						</>
					)}
				</div>
			</div>
		</div>
	);
};

export default SearchAndBrowse;
