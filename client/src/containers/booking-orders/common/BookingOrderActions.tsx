'use client';
import React, { useState } from 'react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { IconDownload } from '@/assets/Icons/outline';
import IconGrid from '@/assets/Icons/outline/IconGrid';
import { gridViewData } from '@/containers/booking-orders/data';
import SelectCheckbox from '@/components/shared/Select/SelectCheckbox';

const BookingOrderActions = () => {
	const [gridView, setGridView] = useState(gridViewData);

	return (
		<div className={'flex items-center gap-2'}>
			<Button
				className={cn(
					'h-8 rounded-lg bg-secondary-500 px-3 py-1 text-white hover:bg-secondary-500 hover:opacity-80',
					TextVariants.caption_14px_600
				)}>
				<IconDownload color={'#fff'} className={'size-5'} />
				Xuất file (.csv)
			</Button>
			<SelectCheckbox
				isIconChevronLight={true}
				containerWidthDefault={320}
				displayLabel={<IconGrid color={'#fff'} className={'size-5'} />}
				className={'border-none bg-secondary-500'}
				data={gridView}
				handleChangeData={(data) => setGridView(data)}
			/>
		</div>
	);
};

export default BookingOrderActions;
