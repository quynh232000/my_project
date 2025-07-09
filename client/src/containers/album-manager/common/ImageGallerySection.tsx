'use client';
import React, { useEffect, useState } from 'react';
import Typography from '@/components/shared/Typography';
import DialogUploadImageGallery from '@/containers/album-manager/common/DialogUploadImageGallery';
import { Form } from '@/components/ui/form';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { imageGallerySectionSchema } from '@/lib/schemas/album/image-gallery-section';
import { TImageGalleryData } from '@/containers/album-manager/data';
import ImageGalleryList from '@/containers/album-manager/common/ImageGalleryList';
import DialogEditImageGallery from '@/containers/album-manager/common/DialogEditImageGallery';
import { useAlbumHotelStore } from '@/store/album/store';
import { useShallow } from 'zustand/react/shallow';
import DialogDeleteAllImage from '@/containers/album-manager/common/DialogDeleteAllImage';

const ImageGallerySection = ({
	title,
	imageList,
	roomId,
	labelParentId,
}: {
	title?: string;
	imageList: TImageGalleryData[];
	roomId?: number;
	labelParentId?: number;
}) => {
	const [dialogEditImage, setDialogEditImage] = useState<
		| {
				image: string | File;
				selectedTag?: string;
				index?: number;
				image_id?: number | null;
		  }
		| undefined
	>(undefined);
	const [dialogDeleteImageAlbum, setDialogDeleteImageAlbum] = useState<
		string | undefined
	>(undefined);
	const { setDeletedAlbumIds, deletedAlbumIds } = useAlbumHotelStore(
		useShallow((state) => ({
			setDeletedAlbumIds: state.setDeletedAlbumIds,
			deletedAlbumIds: state.deletedAlbumIds,
		}))
	);

	const method = useForm({
		mode: 'onChange',
		resolver: zodResolver(imageGallerySectionSchema(true)),
	});
	const imageEdit = method.watch('imageEdit');

	useEffect(() => {
		method.setValue('images', imageList);
	}, [imageList]);

	const filesUpload = method.watch('filesUpload');

	useEffect(() => {
		if (imageEdit) {
			setDialogEditImage((prev) => ({
				...prev,
				image: imageEdit,
			}));
		}
	}, [imageEdit]);

	useEffect(() => {
		if (!dialogEditImage) {
			method.setValue('imageEdit', '');
		}
	}, [dialogEditImage]);
	return (
		<Form {...method}>
			<form>
				<div className={'mt-8'}>
					{title && (
						<Typography
							tag={'h2'}
							variant={'content_16px_600'}
							className={'mb-4 text-neutral-700'}
							text={title}
						/>
					)}

					<ImageGalleryList
						roomId={roomId}
						onEdit={(id) => {
							const images = method.getValues('images') ?? [];
							const idx = images.findIndex((item) => item.id === id);
							if (idx >= 0) {
								setDialogEditImage({
									image: images?.[idx]?.file || images?.[idx]?.url,
									index: idx,
									selectedTag: images?.[idx]?.tag,
									image_id: images?.[idx]?.image_id,
								});
							}
						}}
						onCheck={(id, checked: boolean) => {
							let newArr = [...deletedAlbumIds];
							if (checked) {
								newArr.push({
									id: String(id),
									room_id: roomId ? String(roomId) : undefined,
								});
							} else {
								newArr = newArr.filter((item) => item.id !== String(id));
							}
							setDeletedAlbumIds(newArr);
						}}
						onRemove={(id) => {
							const images = method.getValues('images') ?? [];
							const idx = images.findIndex((item) => item.id === id);
							if (idx >= 0) {
								setDialogDeleteImageAlbum(String(images?.[idx]?.image_id));
								const arr = {
									id: String(images?.[idx]?.image_id),
									room_id: roomId ? String(roomId) : undefined,
								};
								setDeletedAlbumIds([...deletedAlbumIds, arr]);
							}
						}}
					/>
				</div>
				<DialogDeleteAllImage
					onClose={() => {
						setDeletedAlbumIds(
							deletedAlbumIds.filter(
								(item) => item.id !== dialogDeleteImageAlbum
							)
						);
						setDialogDeleteImageAlbum(undefined);
					}}
					open={!!dialogDeleteImageAlbum}
				/>

				<DialogEditImageGallery
					labelParentId={labelParentId}
					roomId={roomId}
					open={!!dialogEditImage}
					image={dialogEditImage?.image}
					onClose={() => {
						setDialogEditImage(undefined);
						method.setValue('imageEdit', '');
					}}
					selectedTag={dialogEditImage?.selectedTag}
					index={dialogEditImage?.index}
					image_id={dialogEditImage?.image_id as number}
				/>

				<DialogUploadImageGallery
					labelParentId={labelParentId}
					roomId={roomId}
					open={!!filesUpload && filesUpload?.length > 0}
					onClose={() => {
						method.setValue('filesUpload', []);
						method.setValue('imagesUpload', []);
					}}
				/>
			</form>
		</Form>
	);
};

export default ImageGallerySection;
