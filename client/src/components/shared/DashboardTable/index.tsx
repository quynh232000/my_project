'use client';

import {
	IconChevron,
	IconChevronSimple,
	IconEdit,
	IconSearchBar,
} from '@/assets/Icons/outline';
import IconTrash from '@/assets/Icons/outline/IconTrash';
import SelectPopup, {
	OptionType,
} from '@/components/shared/Select/SelectPopup';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import {
	Table,
	TableBody,
	TableCell,
	TableHead,
	TableHeader,
	TableRow,
} from '@/components/ui/table';
import useDebounce from '@/hooks/use-debounce';
import { cn } from '@/lib/utils';
import { GlobalUI } from '@/themes/type';
import { removeAccent } from '@/utils/string/remove-accent';
import { startHolyLoader } from 'holy-loader';
import { EyeIcon } from 'lucide-react';
import { useRouter } from 'next/navigation';
import React, { CSSProperties, useEffect, useMemo, useState } from 'react';
import {
	Pagination,
	PaginationContent,
	PaginationEllipsis,
	PaginationItem,
	PaginationLink,
	PaginationNext,
	PaginationPrevious,
} from '@/components/ui/pagination';
import { ERoomStatus } from '@/services/room/getRoomList';
import { IPromotionResponse } from '@/services/promotion/getPromotionList';
import { QueryParams } from '@/hooks/use-query-pagination-params';

export type TCellType = string | number | boolean | object;
export type TActionType =
	| 'checkbox'
	| 'edit'
	| 'delete'
	| 'navigate'
	| 'detail'
	| 'editAndDelete';

export interface ColumnDef<T extends { id: string | number }> {
	label?: string;
	field?: keyof T;
	fieldClassName?: string;
	actionType?: TActionType;
	renderCell?: (val: TCellType, row: T) => React.ReactNode;
	style?: CSSProperties;
	sortable?: boolean;
}

interface IFilterItem<T> {
	[key: string]: {
		value: string;
		handler: (val: T) => boolean;
	};
}

export interface FilterComponentProps<T> {
	onFilterChange?: (filters: IFilterItem<T>) => void;
	currentFilters?: IFilterItem<T>;
}

interface DashboardTableProps<T extends { id: string | number }> {
	searchPlaceholder?: string;
	filterPlaceholder?: string;
	filterData?: OptionType[];
	addButtonText?: string;
	handleAdd?: () => void;
	checkboxSelection?: boolean;
	columns: ColumnDef<T>[];
	rows: T[];
	action?: {
		name: string;
		type: TActionType;
		handle: ((val: T) => void)[];
		url?: string;
		className?: string;
	};
	fieldSearch?: (keyof T)[];
	filterContent?:
		| React.ReactElement<FilterComponentProps<T>>
		| React.ReactNode;
	onCustomFilterChange?: (filters: IFilterItem<T>) => void;
	searchInputClassName?: string;
	searchContainerClassName?: string;
	tableClassName?: string;
	customAction?: React.ReactNode;
	showSearchComponent?: boolean;
	handleChangeStatus?: (status: ERoomStatus, room_ids: number[]) => void;
	onPaginationModelChange?: ({
		page,
		limit,
	}: {
		page?: number;
		limit?: number;
	}) => void;
	onFilterModelChange?: ({
		search,
		status,
	}: {
		search?: string;
		status?: string;
	}) => void;
	onSortModelChange?: ({
		direction,
		column,
	}: {
		direction: string;
		column: string;
	}) => void;
	meta?: IPromotionResponse['meta'];
	params?: QueryParams;
}

const DashboardTable = <T extends { id: string | number }>({
	searchPlaceholder,
	filterPlaceholder,
	filterData,
	addButtonText,
	handleAdd,
	checkboxSelection,
	columns,
	rows,
	action,
	fieldSearch,
	onCustomFilterChange,
	searchInputClassName,
	searchContainerClassName,
	tableClassName,
	showSearchComponent = true,
	handleChangeStatus,
	onPaginationModelChange,
	onFilterModelChange,
	onSortModelChange,
	meta,
	params,
}: DashboardTableProps<T>) => {
	const router = useRouter();
	const [selectedItems, setSelectedItems] = useState<T[]>([]);
	const [conditional, setConditional] = useState<{
		sort:
			| {
					field: keyof T;
					type: 'asc' | 'desc';
			  }
			| undefined;
		filter: string | number;
		search: string;
		customFilter?: IFilterItem<T>;
	}>({
		sort: undefined,
		filter: '',
		search: '',
	});
	const [pagination, setPagination] = useState<{
		rowsPerPage: number;
		page: number;
	}>({
		rowsPerPage: meta?.per_page || 10,
		page: meta?.current_page || 1,
	});

	const [handledRows, setHandledRows] = useState<T[]>(rows);
	const [paginatedRows, setPaginatedRows] = useState<T[]>([]);
	const [searchValue, setSearchValue] = useState(params?.search || '');

	const totalPages = useMemo(
		() =>
			onPaginationModelChange
				? (meta?.total_page as number)
				: (Math.ceil(handledRows.length / pagination.rowsPerPage) ?? 0),
		[handledRows, pagination, meta]
	);

	useEffect(() => {
		if (meta) {
			setPagination({
				page: meta.current_page,
				rowsPerPage: meta.per_page,
			});
		}
	}, [meta]);

	const onMovePage = (page: 1 | -1) => {
		const maxPage = onPaginationModelChange
			? (meta?.total_page as number)
			: Math.ceil(handledRows.length / pagination.rowsPerPage);
		setPagination({
			...pagination,
			page: Math.min(Math.max(1, pagination.page + page), maxPage),
		});

		onPaginationModelChange?.({
			page: Math.min(Math.max(1, pagination.page + page), maxPage),
			limit: pagination.rowsPerPage,
		});
	};

	useEffect(() => {
		let result = [...rows];
		if (
			conditional.filter &&
			conditional.filter !== 'all' &&
			!onFilterModelChange
		) {
			result = result.filter(
				(row) =>
					typeof row === 'object' &&
					row !== null &&
					'status' in row &&
					row['status'] === conditional.filter
			);
		}
		if (
			conditional.search &&
			!!conditional.search.trim() &&
			!onFilterModelChange
		) {
			const searchStr = removeAccent(conditional.search.toLowerCase());
			result = result.filter((row) =>
				fieldSearch?.some((field) => {
					const fieldValue = row[field];
					if (!fieldValue) return false;
					return removeAccent(
						String(fieldValue).toLowerCase()
					).includes(searchStr);
				})
			);
		}
		if (!!conditional.customFilter) {
			const customFilter = conditional.customFilter;
			result = result.filter((row) => {
				return Object.entries(customFilter).every(([_, filter]) => {
					return filter.handler(row);
				});
			});
		}
		if (conditional && conditional.sort && !onSortModelChange) {
			const field = conditional.sort.field;
			const type = conditional.sort.type;
			result.sort((a, b) => {
				return typeof b[field] === 'number' &&
					typeof a[field] === 'number'
					? (Number(b[field]) - Number(a[field])) *
							(type === 'asc' ? -1 : 1)
					: String(a[field]).localeCompare(String(b[field])) *
							(type === 'asc' ? 1 : -1);
			});
		}
		// setPagination((prev) => {
		// 	return {
		// 		...prev,
		// 		page: onFilterModelChange
		// 			? 1
		// 			: result.length < (prev.page - 1) * prev.rowsPerPage
		// 				? 1
		// 				: prev.page,
		// 	};
		// });
		setHandledRows(result);
	}, [conditional, rows]);

	useEffect(() => {
		const offset = (pagination.page - 1) * pagination.rowsPerPage;
		setPaginatedRows(
			onPaginationModelChange
				? handledRows
				: handledRows.slice(
						offset,
						pagination.rowsPerPage * pagination.page
					)
		);
	}, [handledRows, pagination]);

	useEffect(() => {
		if (onCustomFilterChange) {
			onCustomFilterChange(conditional.customFilter || {});
		}
	}, [conditional.customFilter, onCustomFilterChange]);

	const renderFieldAction = (
		fieldType: TActionType,
		val: T
	): React.ReactNode => {
		switch (fieldType) {
			case 'checkbox':
				return (
					<div
						className={
							'flex items-center justify-center hover:opacity-80'
						}>
						<Checkbox
							checked={
								selectedItems.findIndex(
									(item) => String(item.id) === String(val.id)
								) >= 0
							}
							onCheckedChange={(checked) => {
								if (checked) {
									setSelectedItems((prev) => [...prev, val]);
								} else {
									setSelectedItems((prev) =>
										prev.filter(
											(item) =>
												String(item.id) !==
												String(val.id)
										)
									);
								}
							}}
						/>
					</div>
				);
			case 'edit':
				return (
					<button
						onClick={() => action?.handle?.[0]?.(val)}
						className={'mx-auto flex hover:opacity-80'}>
						<IconEdit width={24} height={24} />
					</button>
				);
			case 'delete':
				return (
					<button
						onClick={() => action?.handle?.[0]?.(val)}
						className={'mx-auto flex hover:opacity-80'}>
						<IconTrash width={24} height={24} />
					</button>
				);
			case 'navigate':
				return (
					<button
						onClick={async () => {
							startHolyLoader();
							await action?.handle?.[0]?.(val);
							action?.url && router.push(action.url);
						}}
						className={'mx-auto flex hover:opacity-80'}>
						<IconChevron
							direction={'right'}
							className="p-1"
							width={24}
							height={24}
						/>
					</button>
				);
			case 'detail':
				return (
					<button
						onClick={async () => {
							await action?.handle?.[0]?.(val);
							action?.url && router.push(action.url);
						}}
						className={'mx-auto flex hover:opacity-80'}>
						<EyeIcon className="p-1" width={24} height={24} />
					</button>
				);
			case 'editAndDelete':
				return (
					<div
						className={
							'flex w-[150px] items-center justify-center gap-4'
						}>
						<button
							onClick={() => action?.handle?.[0]?.(val)}
							className={'hover:opacity-80'}>
							<IconEdit width={24} height={24} />
						</button>
						<button
							onClick={() => action?.handle?.[1]?.(val)}
							className={'hover:opacity-80'}>
							<IconTrash width={24} height={24} />
						</button>
					</div>
				);
			default:
				return null;
		}
	};

	const renderTableHead = (col: ColumnDef<T>) => {
		return (
			<TableHead
				key={col.field ? String(col.field) : undefined}
				style={{ ...col?.style }}
				className={cn(
					'h-8 border-r !px-3 py-0 text-neutral-600 last:border-r-0',
					TextVariants.caption_14px_700,
					!!col.actionType && 'w-[100px]',
					col.fieldClassName
				)}>
				{col.actionType === 'checkbox' ? (
					<div className={'flex items-center justify-center'}>
						<Checkbox
							className="bg-white"
							checked={selectedItems.length === rows.length}
							onCheckedChange={(checked) =>
								setSelectedItems(checked ? [...rows] : [])
							}
						/>
					</div>
				) : (
					<div
						onClick={(_) => {
							if (col.sortable && col.field) {
								if (
									col.field === conditional.sort?.field &&
									conditional.sort?.type === 'desc'
								) {
									setConditional({
										...conditional,
										sort: undefined,
									});
									onSortModelChange?.({
										direction: '',
										column: '',
									});
								} else {
									setConditional({
										...conditional,
										sort: {
											field: col.field!,
											type:
												conditional.sort?.field ===
												col.field
													? 'desc'
													: 'asc',
										},
									});
									onSortModelChange?.({
										direction:
											conditional.sort?.field ===
											col.field
												? 'desc'
												: 'asc',
										column: col.field! as string,
									});
								}
							}
						}}
						className={`relative flex h-6 ${col.sortable && 'cursor-pointer'} select-none items-center`}>
						<Typography
							tag="p"
							variant={'caption_14px_700'}
							className={'select-none truncate pr-4'}>
							{col.label}
						</Typography>
						{col.sortable && (
							<div className="ml-auto">
								<IconChevronSimple
									width={22}
									height={22}
									direction={'up'}
									color={
										conditional.sort?.field === col.field &&
										conditional.sort?.type === 'asc'
											? GlobalUI.colors.neutrals['400']
											: GlobalUI.colors.neutrals['300']
									}
								/>
								<IconChevronSimple
									width={22}
									height={22}
									direction={'down'}
									className="-mt-[14px]"
									color={
										conditional.sort?.field === col.field &&
										conditional.sort?.type === 'desc'
											? GlobalUI.colors.neutrals['400']
											: GlobalUI.colors.neutrals['300']
									}
								/>
							</div>
						)}
					</div>
				)}
			</TableHead>
		);
	};

	const renderTableCell = (col: ColumnDef<T>, row: T) => {
		return (
			<TableCell
				key={col.field ? String(col.field) : undefined}
				className={cn(
					'border-r !px-3 py-2 last:border-r-0',
					col.fieldClassName
				)}>
				{col.actionType ? (
					renderFieldAction(col.actionType, row)
				) : col.renderCell && col.field ? (
					col.renderCell(row[col.field] as TCellType, row)
				) : (
					<Typography
						tag={'p'}
						variant={'caption_14px_400'}
						className={'text-neutral-600'}>
						{col.field ? String(row[col.field]) : ''}
					</Typography>
				)}
			</TableCell>
		);
	};

	const handleSearch = useDebounce((val: string) => {
		setConditional({
			...conditional,
			search: val,
		});
		onFilterModelChange?.({
			search: val,
			status: String(conditional.filter),
		});
	}, 500);
	const showActions = useMemo(
		() => !!handleChangeStatus || (!!addButtonText && !!handleAdd),
		[]
	);

	useEffect(() => {
		const urlSearch = params?.search ?? '';
		if (urlSearch && searchValue !== urlSearch) {
			setSearchValue(urlSearch);
		}
	}, [params?.search]); // chỉ phụ thuộc vào params.search

	return (
		<div className={'flex flex-col gap-6'}>
			{showSearchComponent && (
				<div
					className={cn(
						'items-center gap-4',
						searchContainerClassName,
						showActions
							? 'flex flex-row flex-wrap lg:flex-nowrap'
							: 'grid grid-cols-2'
					)}>
					<Input
						className={cn(
							'h-8 py-1',
							searchInputClassName,
							showActions && 'w-[300px]'
						)}
						startAdornment={
							<IconSearchBar width={24} height={24} />
						}
						placeholder={searchPlaceholder}
						onChange={(e) => {
							handleSearch(e.target.value ?? '');
							setSearchValue(e.target.value);
						}}
						value={searchValue}
					/>

					<SelectPopup
						searchInput={false}
						className={cn(
							'h-8 rounded-lg bg-white py-1',
							showActions && 'w-[160px]'
						)}
						containerClassName={
							showActions ? 'w-fit ' : 'w-full col-span-1'
						}
						labelClassName="mb-2"
						classItemList={'h-auto'}
						required
						placeholder={filterPlaceholder}
						data={filterData}
						onChange={(value) => {
							setConditional({
								...conditional,
								filter: value,
							});
							onFilterModelChange?.({
								status: String(value),
								search: conditional.search,
							});
						}}
						selectedValue={
							(params?.['status'] ?? 'all') || conditional.filter
						}
					/>
					{showActions && (
						<div className={'ml-auto space-x-2'}>
							{selectedItems.length > 0 && (
								<>
									<Button
										onClick={() => {
											handleChangeStatus?.(
												ERoomStatus.inactive,
												selectedItems.map(
													(item) => +item.id
												)
											);
											setSelectedItems([]);
										}}
										disabled={selectedItems.length === 0}
										className={
											'h-10 border-2 border-accent-03 bg-transparent text-accent-03 hover:bg-neutral-50 disabled:cursor-not-allowed disabled:!bg-transparent'
										}>
										Hủy kích hoạt{' '}
										{selectedItems.length > 0
											? `(${selectedItems.length})`
											: null}
									</Button>
									<Button
										onClick={() => {
											handleChangeStatus?.(
												ERoomStatus.active,
												selectedItems.map(
													(item) => +item.id
												)
											);
											setSelectedItems([]);
										}}
										disabled={selectedItems.length === 0}
										className={
											'h-10 border-2 border-secondary-500 bg-transparent text-secondary-500 hover:bg-neutral-50 disabled:cursor-not-allowed disabled:!bg-transparent'
										}>
										Kích hoạt{' '}
										{selectedItems.length > 0
											? `(${selectedItems.length})`
											: null}
									</Button>
								</>
							)}
							{!!addButtonText && !!handleAdd && (
								<Button
									onClick={handleAdd}
									className={
										'h-8 rounded-lg border-none py-1'
									}
									variant={'secondary'}>
									{addButtonText}
								</Button>
							)}
						</div>
					)}
				</div>
			)}
			<div className={tableClassName}>
				{paginatedRows.length > 0 ? (
					<>
						<Table
							className={'border-collapse'}
							containerClassname="border rounded-lg">
							<TableHeader className="bg-neutral-100">
								<TableRow>
									{checkboxSelection
										? renderTableHead({
												actionType: 'checkbox',
											})
										: null}
									{columns.map((col) => renderTableHead(col))}
									{action
										? renderTableHead({
												label: action.name,
												actionType: action.type,
											})
										: null}
								</TableRow>
							</TableHeader>
							<TableBody>
								{paginatedRows.map((row, index) => (
									<TableRow
										key={index}
										{...(selectedItems.findIndex(
											(item) =>
												String(item.id) ===
												String(row.id)
										) >= 0
											? { className: '!bg-secondary-00' }
											: {})}>
										{checkboxSelection
											? renderTableCell(
													{ actionType: 'checkbox' },
													row
												)
											: null}
										{columns.map((col) =>
											renderTableCell(col, row)
										)}
										{action
											? renderTableCell(
													{
														label: action.name,
														actionType: action.type,
														fieldClassName:
															action.className,
													},
													row
												)
											: null}
									</TableRow>
								))}
							</TableBody>
						</Table>
						<div
							className={
								'mt-4 flex min-h-6 flex-row items-center justify-between'
							}>
							<div
								className={
									'sticky flex w-full flex-row items-center justify-between gap-3'
								}>
								<SelectPopup
									selectedPrefix={'Số dòng đang hiển thị: '}
									selectedSuffix={'dòng'}
									selectedClassName={'font-semibold'}
									showCheck={false}
									containerClassName={'w-fit'}
									className={
										'h-8 rounded-lg border px-3 py-1'
									}
									placeholder={'Dòng'}
									searchInput={false}
									selectedValue={pagination.rowsPerPage}
									data={[5, 10, 25, 50, 100].map((item) => ({
										label: `${item}`,
										value: item,
									}))}
									classItemList={'h-auto'}
									onChange={(value) => {
										onPaginationModelChange?.({
											limit: +value,
											page: 1,
										});
									}}
								/>
								<Pagination>
									<PaginationContent>
										<PaginationItem
											onClick={() => onMovePage(-1)}>
											<PaginationPrevious
												disabled={
													pagination.page <= 1
												}></PaginationPrevious>
										</PaginationItem>

										{pagination.page > 1 && (
											<PaginationItem>
												<PaginationLink
													onClick={() => {
														onPaginationModelChange
															? onPaginationModelChange(
																	{
																		page: 1,
																		limit: pagination.rowsPerPage,
																	}
																)
															: setPagination({
																	...pagination,
																	page: 1,
																});
													}}>
													1
												</PaginationLink>
											</PaginationItem>
										)}

										{pagination.page > 4 && (
											<PaginationItem>
												<PaginationEllipsis></PaginationEllipsis>
											</PaginationItem>
										)}

										{Array.from({ length: 2 })
											.map(
												(_, index) =>
													pagination.page -
														index -
														1 >
														1 && (
														<PaginationItem
															key={index}>
															<PaginationLink
																onClick={() => {
																	onPaginationModelChange
																		? onPaginationModelChange(
																				{
																					page:
																						pagination.page -
																						index -
																						1,
																					limit: pagination.rowsPerPage,
																				}
																			)
																		: setPagination(
																				{
																					...pagination,
																					page:
																						pagination.page -
																						index -
																						1,
																				}
																			);
																}}>
																{pagination.page -
																	index -
																	1}
															</PaginationLink>
														</PaginationItem>
													)
											)
											.reverse()}

										<PaginationItem>
											<PaginationLink isActive>
												{pagination.page}
											</PaginationLink>
										</PaginationItem>

										{Array.from({ length: 2 }).map(
											(_, index) =>
												pagination.page + index + 1 <
													totalPages && (
													<PaginationItem key={index}>
														<PaginationLink
															onClick={() => {
																onPaginationModelChange
																	? onPaginationModelChange(
																			{
																				page:
																					pagination.page +
																					index +
																					1,
																				limit: pagination.rowsPerPage,
																			}
																		)
																	: setPagination(
																			{
																				...pagination,
																				page:
																					pagination.page +
																					index +
																					1,
																			}
																		);
															}}>
															{pagination.page +
																index +
																1}
														</PaginationLink>
													</PaginationItem>
												)
										)}

										{pagination.page < totalPages - 3 && (
											<>
												<PaginationItem>
													<PaginationEllipsis></PaginationEllipsis>
												</PaginationItem>
											</>
										)}
										{pagination.page <= totalPages - 1 && (
											<PaginationItem>
												<PaginationLink
													onClick={() => {
														onPaginationModelChange
															? onPaginationModelChange(
																	{
																		page: totalPages,
																		limit: pagination.rowsPerPage,
																	}
																)
															: setPagination({
																	...pagination,
																	page: totalPages,
																});
													}}>
													{totalPages}
												</PaginationLink>
											</PaginationItem>
										)}
										<PaginationItem>
											<PaginationNext
												disabled={
													pagination.page >=
													totalPages
												}
												onClick={() =>
													onMovePage(1)
												}></PaginationNext>
										</PaginationItem>
									</PaginationContent>
								</Pagination>
							</div>
						</div>
					</>
				) : (
					<div className={'space-y-2 py-14 text-center'}>
						<Typography
							tag={'p'}
							variant={'content_16px_700'}
							className={'text-neutral-600'}>
							{rows.length === 0
								? 'Chưa có dữ liệu nào được tạo'
								: 'Không tìm thấy kết quả'}
						</Typography>
						<Typography
							tag={'p'}
							variant={'caption_14px_500'}
							className={'text-neutral-400'}>
							{rows.length === 0 && !!addButtonText
								? 'Nhấn vào nút "thêm mới" để tạo mới dữ liệu của bạn'
								: !!conditional.search
									? 'Hãy thử kiểm tra lỗi chính tả hoặc sử dụng từ đầy đủ.'
									: ''}
						</Typography>
					</div>
				)}
			</div>
		</div>
	);
};

export function renderStatus<T>(
	status: TCellType,
	_: T,
	meta:
		| {
				onToggleStatus?: () => void;
				statusesPalete?: {
					[key: string]: {
						label: string;
						backgroundColor: string;
						color: string;
					};
				};
		  }
		| undefined = undefined
) {
	const { onToggleStatus, statusesPalete } = {
		onToggleStatus: meta?.onToggleStatus,
		statusesPalete: meta?.statusesPalete || {
			active: {
				label: 'Hoạt động',
				backgroundColor: 'bg-green-50',
				color: 'text-green-500',
			},
			inactive: {
				label: 'Ẩn',
				backgroundColor: 'bg-red-50',
				color: 'text-red-500',
			},
		},
	};
	const statusPalete =
		statusesPalete?.[status as keyof typeof statusesPalete];
	if (!statusPalete) return 'undefined';

	return (
		<div
			className={cn(
				`${onToggleStatus ? 'cursor-pointer' : ''} rounded-lg py-1`,
				statusPalete.backgroundColor
			)}
			{...(!!onToggleStatus && {
				onClick: onToggleStatus,
			})}>
			<Typography
				tag={'p'}
				variant={'caption_12px_600'}
				className={cn('text-center', statusPalete.color)}>
				{statusPalete.label}
			</Typography>
		</div>
	);
}

export default DashboardTable;
