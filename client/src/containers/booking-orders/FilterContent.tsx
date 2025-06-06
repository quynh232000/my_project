import React from 'react';
import Typography from '@/components/shared/Typography';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import { Button } from '@/components/ui/button';
import { IconDownload } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { FilterComponentProps } from '@/components/shared/DashboardTable';
import { TBookingOrder } from './data';

const FilterContent = ({onFilterChange, currentFilters}: FilterComponentProps<TBookingOrder>) => {
	return (
		<div className={'border-t border-other-divider-02 px-6 pt-6 flex items-center justify-between'}>
			<div className={'flex items-center gap-4'}>
				<Typography
					tag={'p'}
					variant={'caption_12px_600'}
					text={'Bộ lọc'}
					className={'text-neutral-400'}
				/>
				<SelectPopup
					containerClassName={"w-auto"}
					className="h-10 w-[200px] rounded-lg bg-white py-2"
					labelClassName="mb-2"
					classItemList={'h-auto'}
					required
					placeholder={'Loại giá'}
					data={[]}
					onChange={(value) => {
						console.log(value);
					}}
					selectedValue={''}
				/>
				<SelectPopup
					containerClassName={"w-auto"}
					className="h-10 w-[200px] rounded-lg bg-white py-2 "
					labelClassName="mb-2"
					classItemList={'h-auto'}
					required
					placeholder={'Loại phòng'}
					data={[]}
					onChange={(value) => {
						console.log(value);
					}}
					selectedValue={''}
				/>
				<SelectPopup
					containerClassName={"w-auto"}
					className="h-10 w-[200px] rounded-lg bg-white py-2"
					labelClassName="mb-2"
					classItemList={'h-auto'}
					required
					placeholder={'Trạng thái: Tất cả'}
					data={[
						{value: 'all', label: 'Tất cả'},
						{value: 'active', label: 'Đã xác nhận'},
						{value: 'inactive', label: 'Đã huỷ bỏ'},
						{value: 'pending', label: 'Chờ xác nhận'},
					]}
					onChange={(value) => {
						onFilterChange?.({
							...currentFilters,
							'status': {
								value: String(value),
								handler: (row) => value === 'all' || row?.status === value
							}
						});
					}}
					selectedValue={currentFilters?.status?.value ?? 'all'}
				/>
			</div>
			<Button className={cn("rounded-lg py-3 px-8 h-10 bg-white hover:bg-white text-secondary-500", TextVariants.caption_14px_600)}>
				<IconDownload color={GlobalUI.colors.secondary["500"]} className={'size-6'}/>
				Tải về (.csv)
			</Button>
		</div>
	);
};

export default FilterContent;