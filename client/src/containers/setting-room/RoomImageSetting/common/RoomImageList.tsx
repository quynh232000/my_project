import React from 'react';
import Typography from '@/components/shared/Typography';
import { useFormContext, useWatch } from 'react-hook-form';
import { SortableList } from '@/containers/setting-room/RoomImageSetting/common/SortableList';
import { ImageGallerySectionType } from '@/lib/schemas/album/image-gallery-section';

export type ImageType = {
	id: string | number;
	url: string;
	tag: string;
	file: File | string;
	image_id: number | null;
	priority: number ;
};

const RoomImageList = ({
	onEdit,
	onRemove,
}: {
	onEdit: (id: number | string) => void;
	onRemove: (id: number | string) => void;
}) => {
	const { control, setValue } = useFormContext<ImageGallerySectionType>();

	const imageListWatch = useWatch({
		control,
		name: 'images',
	});

	return (
		<div className={'relative min-h-[264px] rounded-xl bg-white'}>
			{imageListWatch && imageListWatch.length > 0 ? (
				<div>
					<Typography
						tag={'p'}
						variant={'content_16px_700'}
						className={'px-4 pb-2 pt-4 text-neutral-600'}
						text={'Ảnh đang hoạt động'}
					/>
						<SortableList
							list={imageListWatch}
							onRemove={onRemove}
							onEdit={onEdit}
							onMove={(list) => {
								setValue("images", list)
							}}
						/>
				</div>
			) : (
				<div
					className={
						'absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 p-4 text-center'
					}>
					<Typography
						tag={'p'}
						variant={'content_16px_700'}
						className={'text-neutral-600'}>
						Quý đối tác chưa tải bất kỳ ảnh nào lên
					</Typography>
					<Typography
						tag={'p'}
						variant={'caption_14px_500'}
						className={'text-neutral-400'}>
						Kéo thả hoặc duyệt ảnh ở cột bên trên để thêm ảnh phòng này
					</Typography>
				</div>
			)}
		</div>
	);
};

export default RoomImageList;
