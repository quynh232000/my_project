import React, { useState } from 'react';
import { cn } from '@/lib/utils';
import { IconSearchBar } from '@/assets/Icons/outline';
import { Input } from '@/components/ui/input';
import Typography from '@/components/shared/Typography';
import {
	bookingOrderList,
	TBookingOrder,
} from '@/containers/booking-orders/data';
import { removeAccent } from '@/utils/string/remove-accent';

const BookingOrderSearch = () => {
	const [search, setSearch] = useState('');
	const [data, setData] = useState<TBookingOrder[]>(bookingOrderList);
	const highlightMatch = (text: string, keyword: string) => {
		if (!keyword) return <span className="text-neutral-600">{text}</span>;

		const lowerText = text.toLowerCase();
		const lowerKeyword = keyword.toLowerCase();

		if (lowerText.startsWith(lowerKeyword)) {
			const matchPart = text.slice(0, keyword.length);
			const restPart = text.slice(keyword.length);

			return (
				<>
					<span className="font-semibold text-secondary-500">{matchPart}</span>
					<span className="text-neutral-600">{restPart}</span>
				</>
			);
		}

		return <span className="text-neutral-600">{text}</span>;
	};

	const handleSearch = (text: string) => {
		const searchStr = removeAccent(text.toLowerCase().trim().replace(/\s+/g, ' '));

		const result = bookingOrderList.filter((row) => {
			const normalizedName = removeAccent(row.name.toLowerCase().trim().replace(/\s+/g, ' '));
			return normalizedName.startsWith(searchStr);
		});

		setSearch(text);
		setData(result);
	};

	return (
		<div className={'relative'}>
			<Input
				className={cn('h-8 border-[1.5px] py-2')}
				startAdornment={<IconSearchBar width={24} height={24} />}
				placeholder={'Mã đặt phòng/Tên khách'}
				value={search}
				onChange={(e) => handleSearch(e.target.value ?? '')}
			/>
			{search && (
				<div
					className={
						'absolute left-0 top-[calc(100%+8px)] z-[9999] rounded-lg border border-stroke-subtle bg-other-white p-4 shadow-[0px_24px_24px_-16px_rgba(15,15,15,0.20)]'
					}>
					{data.length > 0 ? (
						<>
							<Typography
								tag={'p'}
								variant={'caption_14px_500'}
								className={'mb-3 text-neutral-600'}>
								Kết quả tìm kiếm
							</Typography>
							<div className={'space-y-2'}>
								{data.map((bookingOrder) => (
									<div key={bookingOrder.id} className={'flex gap-6 p-1'}>
										<Typography
											tag={'p'}
											variant={'caption_14px_400'}
											className={'text-nowrap text-neutral-600'}>
											{bookingOrder.id}
										</Typography>
										<Typography
											tag="p"
											variant="caption_14px_400"
											className="text-nowrap">
											{highlightMatch(bookingOrder.name, search)}
										</Typography>
										<Typography
											tag={'p'}
											variant={'caption_14px_400'}
											className={'text-nowrap text-neutral-600'}>
											{bookingOrder.time_order}
										</Typography>
										<Typography
											tag={'p'}
											variant={'caption_14px_400'}
											className={'text-nowrap text-neutral-600'}>
											Ngày ở: {bookingOrder.date.from.toLocaleDateString("vi-vn")} - {bookingOrder.date.to.toLocaleDateString("vi-vn")}
										</Typography>
									</div>
								))}
							</div>
						</>
					) : (
						<div
							className={
								'flex h-[200px] w-[400px] items-center justify-center'
							}>
							Không có kết quả tìm kiếm
						</div>
					)}
				</div>
			)}
		</div>
	);
};

export default BookingOrderSearch;
