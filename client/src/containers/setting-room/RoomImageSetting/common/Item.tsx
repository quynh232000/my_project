import React, { CSSProperties, HTMLAttributes } from 'react';
import Image from 'next/image';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import IconTrash from '@/assets/Icons/outline/IconTrash';
import Typography from '@/components/shared/Typography';
import { ImageType } from '@/containers/setting-room/RoomImageSetting/common/RoomImageList';
import { useAttributeStore } from '@/store/attributes/store';

export type ItemProps = HTMLAttributes<HTMLDivElement> & {
	item: ImageType;
	withOpacity?: boolean;
	isDragging?: boolean;
	onEdit?: (id: number | string) => void;
	onRemove?: (id: number | string) => void;
};

const Item = React.forwardRef<HTMLDivElement, ItemProps>(
	(
		{ item, onEdit, onRemove, withOpacity, isDragging, style, ...props },
		ref
	) => {
		const imageRoomList = useAttributeStore((state) => state.imageRoomList);
		const getSelectedTagName = (value: string) => {
			const tagItem =
				imageRoomList &&
				imageRoomList.find((item) => Number(item.id) === Number(value));
			return tagItem?.name || '';
		};

		const inlineStyles: CSSProperties = {
			opacity: withOpacity ? '0.2' : '1',
			cursor: isDragging ? 'grabbing' : 'grab',
			...style,
		};

		return (
			<div ref={ref} style={inlineStyles} {...props}>
				<div className={'space-y-2'}>
					<div
						className={
							'group relative h-[169px] w-full overflow-hidden rounded-lg'
						}>
						<Image
							src={item.url}
							alt={'Hình ảnh đang hoạt động'}
							width={400}
							height={300}
							className={'h-full w-full object-cover bg-neutral-200'}
						/>
						{!!onEdit && !!onRemove ? (
							<div
								className={
									'absolute inset-0 hidden flex-col items-center justify-center gap-2 bg-other-overlay transition-all group-hover:flex'
								}>
								<div className={'flex items-center gap-2'}>
									<Button
										type={'button'}
										onClick={(e) => {
											e.stopPropagation();
											onEdit(item.id);
										}}
										className={cn(
											'h-10 min-w-[117px] bg-white px-6 py-3 text-neutral-600 hover:bg-secondary-500 hover:text-white',
											TextVariants.caption_14px_600
										)}>
										Chỉnh sửa
									</Button>
									<Button
										onClick={() => {
											onRemove(item.id);
										}}
										className={
											'h-10 min-w-min bg-white px-6 py-3 text-neutral-600 hover:bg-neutral-300 hover:text-white'
										}>
										<IconTrash />
									</Button>
								</div>
								<Typography
									tag={'p'}
									variant={'caption_12px_400'}
									className={'text-center text-white'}
									text={'Kéo ảnh để thay đổi thứ tự'}
								/>
							</div>
						) : null}
					</div>
					{!!onEdit && (
						<Typography
							tag={'p'}
							variant={'caption_14px_500'}
							className={'text-neutral-600'}
							text={getSelectedTagName(item.tag)}
						/>
					)}
				</div>
			</div>
		);
	}
);

Item.displayName = 'ImageItem';

export default Item;
