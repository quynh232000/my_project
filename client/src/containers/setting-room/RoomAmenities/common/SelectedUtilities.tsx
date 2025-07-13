import React, { useMemo } from 'react';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { cn } from '@/lib/utils';
import Typography from '@/components/shared/Typography';
import {
	AmenityType,
	RoomAmenitiesType,
} from '@/containers/setting-room/RoomAmenities/data';
import { useWatch } from 'react-hook-form';
import IconArrowRepeat from '@/assets/Icons/outline/IconArrowRepeat';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';

interface Props {
	onOpenDialog: () => void;
	originalList: AmenityType[];
}

const SelectedUtilities = ({ onOpenDialog, originalList }: Props) => {
	const selectedItemList = useWatch<RoomAmenitiesType>();

	const totalSelect = useMemo(() => {
		return Object.values(selectedItemList).reduce(
			(acc, item) => (Array.isArray(item) ? acc + item.length : acc),
			0
		);
	}, [selectedItemList]);

	return (
		<div className={'flex flex-col'}>
			<div className={'flex items-center justify-between'}>
				<h3
					className={cn(
						'text-neutral-600',
						TextVariants.caption_14px_700
					)}>
					Tiện ích đã chọn{' '}
					<span className={'text-neutral-300'}>({totalSelect})</span>
				</h3>
				{totalSelect > 0 && (
					<div
						onClick={onOpenDialog}
						className={cn(
							'flex cursor-pointer items-center gap-2 text-accent-03',
							TextVariants.caption_14px_600
						)}>
						<IconArrowRepeat className={'size-4'} />
						Đặt lại toàn bộ tiện ích
					</div>
				)}
			</div>
			<div className={'mt-4 rounded-2xl border border-blue-100 p-6 pr-4'}>
				<ScrollArea className={'h-[500px]'}>
					<div className={'grid h-full flex-1 grid-cols-2'}>
						{Object.values(selectedItemList).some(
							(item) => Array.isArray(item) && item.length > 0
						) ? (
							Object.entries(selectedItemList)
								.filter(([_, item]) => (item?.length ?? 0) > 0)
								.map(([id, item], index) => {
									const list = originalList.find(
										(data) => `${data.id}` === id
									);
									return (
										list &&
										list.children.length > 0 && (
											<div key={index}>
												<Typography
													tag={'p'}
													variant={'caption_14px_700'}
													className={
														'text-neutral-600'
													}>
													{list.title}
													<span
														className={
															'ml-1 text-neutral-300'
														}>
														({item?.length})
													</span>
												</Typography>
												<div className={'mt-2'}>
													{list.children
														?.filter((amenity) =>
															item?.includes(
																`${amenity.id}`
															)
														)
														.map(
															(
																val,
																index: number
															) => (
																<Typography
																	key={index}
																	tag={'p'}
																	variant={
																		'caption_14px_400'
																	}
																	className={
																		'px-2 py-1 text-neutral-600'
																	}>
																	{val.name}
																</Typography>
															)
														)}
												</div>
											</div>
										)
									);
								})
						) : (
							<div
								className={
									'col-span-2 flex h-[500px] w-full flex-col items-center justify-center gap-4 text-center'
								}>
								<Typography
									tag={'p'}
									variant={'content_16px_700'}
									text={'Chưa có tiện ích nào được chọn'}
									className={'text-neutral-600'}
								/>
								<Typography
									tag={'p'}
									variant={'caption_14px_500'}
									text={
										'Tìm và duyệt các tiện ích mà chỗ nghỉ của bạn đang có ở cột bên trái. Sau khi chọn sẽ xuất hiện tại đây.'
									}
									className={'text-neutral-400'}
								/>
							</div>
						)}
					</div>
					<ScrollBar />
				</ScrollArea>
			</div>
		</div>
	);
};

export default SelectedUtilities;
