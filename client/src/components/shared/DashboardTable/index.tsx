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
	TableFooter,
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
import React, { CSSProperties, useEffect, useState } from 'react';

export type TCellType = string | number | boolean | object;
export type TActionType =
	| 'checkbox'
	| 'edit'
	| 'delete'
	| 'navigate'
	| 'detail'
	| 'editAndDelete';

interface ColumnDef<T extends { id: string | number }> {
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
	filterContent?: React.ReactElement<FilterComponentProps<T>> | React.ReactNode;
	onCustomFilterChange?: (filters: IFilterItem<T>) => void;
	searchInputClassName?: string;
	searchContainerClassName?: string;
	tableClassName?: string;
	customAction?: React.ReactNode;
	rowName?: string;
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
	filterContent,
	onCustomFilterChange,
	searchInputClassName,
	searchContainerClassName,
	tableClassName,
	customAction,
	rowName,
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
		rowsPerPage: 10,
		page: 1,
	});

	const [handledRows, setHandledRows] = useState<T[]>(rows);
	const [paginatedRows, setPaginatedRows] = useState<T[]>([]);

	const pageStart = handledRows.length
		? (pagination.page - 1) * pagination.rowsPerPage + 1
		: 0;

	const onMovePage = (page: 1 | -1) => {
		const maxPage = Math.ceil(handledRows.length / pagination.rowsPerPage);
		setPagination({
			...pagination,
			page: Math.min(Math.max(1, pagination.page + page), maxPage),
		});
	};

	useEffect(() => {
		let result = [...rows];
		if (conditional.filter && conditional.filter !== 'all') {
			result = result.filter(
				(row) =>
					typeof row === 'object' &&
					row !== null &&
					'status' in row &&
					row['status'] === conditional.filter
			);
		}
		if (conditional.search && !!conditional.search.trim()) {
			const searchStr = removeAccent(conditional.search.toLowerCase());
			result = result.filter((row) =>
				fieldSearch?.some((field) => {
					const fieldValue = row[field];
					if (!fieldValue) return false;
					return removeAccent(String(fieldValue).toLowerCase()).includes(
						searchStr
					);
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
		if (conditional && conditional.sort) {
			const field = conditional.sort.field;
			const type = conditional.sort.type;
			result.sort((a, b) => {
				return typeof b[field] === 'number' && typeof a[field] === 'number'
					? (Number(b[field]) - Number(a[field])) * (type === 'asc' ? -1 : 1)
					: String(a[field]).localeCompare(String(b[field])) *
							(type === 'asc' ? 1 : -1);
			});
		}
		setPagination((prev) => {
			return {
				...prev,
				page:
					result.length < (prev.page - 1) * prev.rowsPerPage ? 1 : prev.page,
			};
		});
		setHandledRows(result);
	}, [conditional, rows]);

	useEffect(() => {
		const offset = (pagination.page - 1) * pagination.rowsPerPage;
		setPaginatedRows(
			handledRows.slice(offset, pagination.rowsPerPage * pagination.page)
		);
	}, [handledRows, pagination]);

	useEffect(() => {
		if (onCustomFilterChange) {
			onCustomFilterChange(conditional.customFilter || {});
		}
	}, [conditional.customFilter, onCustomFilterChange]);

	const updateCustomFilter = (filters: IFilterItem<T>) => {
		setConditional((prev) => ({
			...prev,
			customFilter: filters,
		}));
	};

	const renderFieldAction = (
		fieldType: TActionType,
		val: T
	): React.ReactNode => {
		switch (fieldType) {
			case 'checkbox':
				return (
					<div className={'flex items-center justify-center hover:opacity-80'}>
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
										prev.filter((item) => String(item.id) !== String(val.id))
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
					<div className={'flex w-[150px] items-center justify-center gap-4'}>
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
					'border-r !px-3 py-1.5 text-neutral-600 last:border-r-0',
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
								} else {
									setConditional({
										...conditional,
										sort: {
											field: col.field!,
											type:
												conditional.sort?.field === col.field ? 'desc' : 'asc',
										},
									});
								}
							}
						}}
						className={`relative flex ${col.sortable && 'cursor-pointer'} select-none items-center`}>
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
	}, 200);

	return (
		<div className={'flex flex-col gap-6'}>
			<div
				className={cn(
					'flex flex-row flex-wrap items-center gap-4 lg:flex-nowrap',
					searchContainerClassName
				)}>
				<Input
					className={cn('h-10 w-[300px] py-2', searchInputClassName)}
					startAdornment={<IconSearchBar width={24} height={24} />}
					placeholder={searchPlaceholder}
					onChange={(e) => handleSearch(e.target.value ?? '')}
				/>
				{customAction ? (
					customAction
				) : (
					<SelectPopup
						searchInput={false}
						className="h-10 w-[160px] rounded-lg bg-white py-2"
						containerClassName="w-fit"
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
						}}
						selectedValue={conditional.filter}
					/>
				)}
				{!!addButtonText && !!handleAdd && (
					<Button
						onClick={handleAdd}
						className={'ml-auto h-10'}
						variant={'secondary'}>
						{addButtonText}
					</Button>
				)}
			</div>
			{filterContent && React.isValidElement(filterContent)
				? React.cloneElement(
						filterContent as React.ReactElement<FilterComponentProps<T>>,
						{
							onFilterChange: updateCustomFilter,
							currentFilters: conditional.customFilter || {},
						}
					)
				: filterContent}
			<div className={tableClassName}>
				{paginatedRows.length > 0 ? (
					<Table
						className={'border-collapse'}
						containerClassname="border rounded-lg">
						<TableHeader className="bg-neutral-100">
							<TableRow>
								{checkboxSelection
									? renderTableHead({ actionType: 'checkbox' })
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
										(item) => String(item.id) === String(row.id)
									) >= 0
										? { className: '!bg-secondary-00' }
										: {})}>
									{checkboxSelection
										? renderTableCell({ actionType: 'checkbox' }, row)
										: null}
									{columns.map((col) => renderTableCell(col, row))}
									{action
										? renderTableCell(
												{
													label: action.name,
													actionType: action.type,
													fieldClassName: action.className,
												},
												row
											)
										: null}
								</TableRow>
							))}
						</TableBody>
						<TableFooter>
							<TableRow className={'!bg-white'}>
								<TableCell colSpan={100} className="px-3 py-2">
									<div
										className={
											'flex min-h-6 flex-row items-center justify-between'
										}>
										{selectedItems.length > 0 && (
											<Typography>
												{selectedItems.length} {rowName ?? 'dòng'} đã được chọn
											</Typography>
										)}
										<div
											className={
												'sticky right-[14px] ml-auto flex flex-row items-center gap-3'
											}>
											<Typography
												className={'w-fit select-none whitespace-nowrap'}>
												Hiển thị
											</Typography>
											<SelectPopup
												showCheck={false}
												containerClassName={'w-fit'}
												className={'h-8 w-[80px] rounded-lg px-3 py-2'}
												placeholder={'Dòng'}
												searchInput={false}
												selectedValue={pagination.rowsPerPage}
												data={[10, 25, 50, 100].map((item) => ({
													label: `${item}`,
													value: item,
												}))}
												classItemList={'h-auto'}
												onChange={(value) => {
													setPagination({
														rowsPerPage: +value,
														page: 1,
													});
												}}
											/>
											<Typography
												className={'mx-6 w-fit select-none whitespace-nowrap'}>
												{pageStart}-
												{Math.min(
													handledRows.length,
													pageStart + pagination.rowsPerPage - 1
												)}{' '}
												of {handledRows.length}
											</Typography>
											<div>
												<button
													disabled={pagination.page <= 1}
													className={`p-2 ${pagination.page > 1 ? 'cursor-pointer' : 'opacity-25'}`}
													onClick={() => onMovePage(-1)}>
													<IconChevron
														color={GlobalUI.colors.neutrals['600']}
														className={`h-4 w-4`}
														direction={'left'}
													/>
												</button>
												<button
													disabled={
														pagination.page >=
														Math.ceil(
															handledRows.length / pagination.rowsPerPage
														)
													}
													className={`p-2 ${pagination.page < Math.ceil(handledRows.length / pagination.rowsPerPage) ? 'cursor-pointer' : 'opacity-25'}`}
													onClick={() => onMovePage(1)}>
													<IconChevron
														color={GlobalUI.colors.neutrals['600']}
														className={`ml-2 h-4 w-4`}
														direction={'right'}
													/>
												</button>
											</div>
										</div>
									</div>
								</TableCell>
							</TableRow>
						</TableFooter>
					</Table>
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
	const statusPalete = statusesPalete?.[status as keyof typeof statusesPalete];
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
