'use client';
import React, { useState } from 'react';
import Typography from '@/components/shared/Typography';
import {
	Accordion,
	AccordionContent,
	AccordionItem,
} from '@/components/ui/accordion';
import { CheckBoxView } from '@/components/shared/CheckBox/CheckBoxView';
import { Controller, useFormContext } from 'react-hook-form';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { permissionList } from '@/containers/user/data';
import { Checkbox } from '@/components/ui/checkbox';
import { IconChevron } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { UserGroupType } from '@/lib/schemas/user/userGroup';

const UserGroupPermissions = () => {
	const { control, setValue } = useFormContext<UserGroupType>();
	const [openItems, setOpenItems] = useState<string[]>([]);
	const toggleItem = (value: string) => {
		setOpenItems((prev) =>
			prev.includes(value)
				? prev.filter((v) => v !== value)
				: [...prev, value]
		);
	};

	const handleToggleAll = () => {
		const allPermissions = permissionList.reduce(
			(acc, cur) => {
				acc[cur.id] = cur.children.map((item) => item.id);
				return acc;
			},
			{} as { [key: string]: string[] }
		);

		setValue('permissions', allPermissions, { shouldValidate: true });
	};

	const handleToggleOpenAllAccordion = () => {
		if (openItems.length === permissionList.length) {
			setOpenItems([]);
		} else {
			setOpenItems(permissionList.map((item) => `group-${item.id}`));
		}
	};

	return (
		<>
			<div className={'space-y-4'}>
				<div
					className={'justify-space-between flex items-center gap-2'}>
					<Typography
						tag={'h2'}
						variant={'caption_18px_700'}
						className={'flex-1 text-neutral-600'}>
						Danh sách quyền quản trị
					</Typography>
					<div className={'flex items-center gap-4'}>
						<div
							className={cn(
								'cursor-pointer text-secondary-500',
								TextVariants.caption_14px_700
							)}
							onClick={handleToggleAll}>
							Chọn tất cả
						</div>
						<div
							className={cn(
								'cursor-pointer text-secondary-500',
								TextVariants.caption_14px_700
							)}
							onClick={handleToggleOpenAllAccordion}>
							Mở tất cả
						</div>
					</div>
				</div>
				<Accordion
					type="multiple"
					className={'space-y-2'}
					value={openItems}
					onValueChange={setOpenItems}>
					{permissionList.map((permissionGroup, index) => {
						const isOpen = openItems.includes(
							`group-${permissionGroup.id}`
						);
						return (
							<Controller
								key={index}
								name={`permissions.${permissionGroup.id}`}
								control={control}
								render={({ field }) => (
									<AccordionItem
										className={
											'border-other-divider-01 rounded-lg border'
										}
										value={`group-${permissionGroup.id}`}>
										<div
											className={cn(
												'flex h-[52px] cursor-pointer items-center px-4 py-3',
												isOpen &&
													'border-other-divider-01 border-b bg-neutral-50'
											)}>
											<div className="flex items-center gap-2">
												<Checkbox
													id={`permission-${permissionGroup.id}`}
													checked={
														field.value?.length ===
														permissionGroup.children
															.length
													}
													onCheckedChange={(
														checked
													) => {
														field.onChange(
															checked
																? (permissionGroup.children.map(
																		(
																			item
																		) =>
																			item.id
																	) ?? [])
																: []
														);
													}}
													className={
														'border-2 border-other-divider data-[state=checked]:border-secondary-500 data-[state=checked]:bg-secondary-500 data-[state=checked]:text-white'
													}
												/>
												<label
													htmlFor={`permission-${permissionGroup.id}`}
													className={cn(
														'cursor-pointer text-neutral-600',
														TextVariants.caption_14px_400
													)}>
													{permissionGroup.name}
												</label>
											</div>

											<div
												className={
													'flex flex-1 items-center gap-3'
												}
												onClick={() =>
													toggleItem(
														`group-${permissionGroup.id}`
													)
												}>
												<div
													className={cn(
														'ml-auto mr-3 w-[43px] rounded bg-neutral-300 px-3 py-[2px] text-other-white',
														TextVariants.caption_14px_600
													)}>
													<span>
														{field.value?.length ??
															0}
													</span>
													<span>
														/
														{
															permissionGroup
																.children.length
														}
													</span>
												</div>
												<div
													className={`transition-transform ${isOpen ? 'rotate-180' : 'rotate-0'}`}>
													<IconChevron
														direction={'down'}
														width={16}
														height={16}
														color={
															GlobalUI.colors
																.neutrals['400']
														}
													/>
												</div>
											</div>
										</div>
										<AccordionContent
											className={'space-y-3 px-4 py-3'}>
											{permissionGroup.children.map(
												(permission, index) => (
													<CheckBoxView
														key={`${index}`}
														id={`permission-${permissionGroup.id}-${permission.id}`}
														value={field.value?.includes(
															`${permission.id}`
														)}
														onValueChange={(
															val
														) => {
															const newArr = val
																? [
																		...(field?.value ||
																			[]),
																		`${permission.id}`,
																	]
																: (
																		field.value ||
																		[]
																	).filter(
																		(
																			val: string
																		) =>
																			val !==
																			`${permission.id}`
																	);
															setValue(
																field.name,
																newArr,
																{
																	shouldValidate: true,
																}
															);
														}}>
														<Typography
															tag={'p'}
															variant={
																'caption_14px_400'
															}
															className={
																'text-neutral-600'
															}>
															{permission.name}
														</Typography>
													</CheckBoxView>
												)
											)}
										</AccordionContent>
									</AccordionItem>
								)}
							/>
						);
					})}
				</Accordion>
			</div>
			<ButtonActionGroup />
		</>
	);
};

export default UserGroupPermissions;
