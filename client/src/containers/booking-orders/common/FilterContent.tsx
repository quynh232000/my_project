'use client';
import React, { useState } from 'react';
import {
	orderStatus,
	orderTypePrice,
	orderTypeRoom,
	TSelectCheckbox,
} from '../data';
import BookingOrderSearch from '@/containers/booking-orders/common/BookingOrderSearch';
import BookingOrderDatePicker from '@/containers/booking-orders/common/BookingOrderDatePicker';
import SelectCheckbox from '@/components/shared/Select/SelectCheckbox';

const FilterContent = () => {
	const [orderStatusData, setOrderStatusData] =
		useState<TSelectCheckbox[]>(orderStatus);
	const [orderTypeRoomData, setOrderTypeRoomData] =
		useState<TSelectCheckbox[]>(orderTypeRoom);
	const [orderTypePriceData, setOrderTypePriceData] =
		useState<TSelectCheckbox[]>(orderTypePrice);


	return (
		<div className={'mb-[14px] grid grid-cols-5 gap-3'}>
			<BookingOrderSearch />
			<BookingOrderDatePicker containerWidthDefault={600} />

			<SelectCheckbox
				displayLabel={'Loại giá'}
				data={orderTypePriceData}
				handleChangeData={(data) => setOrderTypePriceData(data)}
			/>
			<SelectCheckbox
				displayLabel={'Loại phòng'}
				data={orderTypeRoomData}
				handleChangeData={(data) => setOrderTypeRoomData(data)}
			/>
			<SelectCheckbox
				displayLabel={'Trạng thái'}
				data={orderStatusData}
				handleChangeData={(data) => setOrderStatusData(data)}
			/>
		</div>
	);
};

export default FilterContent;
