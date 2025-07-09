'use client';
import React from 'react';
import { useFormContext, useWatch } from 'react-hook-form';
import { ImageGallerySectionType } from '@/lib/schemas/album/image-gallery-section';
import { SortableList } from '@/containers/album-manager/common/SortableList';
import UploadImageZone from '@/containers/album-manager/common/UploadImageZone';

export type ImageType = {
	id: string | number;
	url: string;
	tag: string;
	file: File | string;
	image_id: number | null;
	priority: number;
};

const ImageGalleryList = ({
	onCheck,
	onRemove,
	onEdit,
	roomId,
}: {
	onCheck: (id: number | string, checked: boolean) => void;
	onRemove: (id: number | string) => void;
	onEdit: (id: number | string) => void;
	roomId?: number;
}) => {
	const { control, setValue } = useFormContext<ImageGallerySectionType>();

	const imageListWatch = useWatch({
		control,
		name: 'images',
	});

	return (
		<div className={'relative rounded-xl bg-white'}>
			{imageListWatch && imageListWatch.length > 0 ? (
				<div className={'space-y-2'}>
					<SortableList
						roomId={roomId}
						list={imageListWatch}
						onCheck={onCheck}
						onRemove={onRemove}
						onEdit={onEdit}
						onMove={(list) => {
							setValue('images', list);
						}}
					/>
				</div>
			) : (
				<div className={'grid grid-cols-6'}>
					<UploadImageZone />
				</div>
			)}
		</div>
	);
};

export default ImageGalleryList;
