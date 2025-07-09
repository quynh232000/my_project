'use client';
import React, { useEffect, useState } from 'react';
import {
	Dialog,
	DialogClose,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import Typography from '@/components/shared/Typography';
import { Button } from '@/components/ui/button';
import { IconClose } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { ImageGallerySectionType } from '@/lib/schemas/album/image-gallery-section';
import { useFormContext, useWatch } from 'react-hook-form';
import { useLoadingStore } from '@/store/loading/store';
import ImageGalleryPreviewCard from '@/containers/album-manager/common/ImageGalleryPreviewCard';
import { getClientSideCookie } from '@/utils/cookie';
import { useRoomStore } from '@/store/room/store';
import kebabCase from 'lodash/kebabCase';
import { toast } from 'sonner';
import { useAlbumHotelStore } from '@/store/album/store';
import { HotelRoomsResponse } from '@/services/album/getAlbumHotel';
import { CreateAlbumRequestBody, createAlbum, IImage } from '@/services/album/createAlbum';

export type TImageUploadItem = {
	url: string;
	file: File | string;
	selected_tag?: string;
};
const DialogUploadImageGallery = ({
	open,
	onClose,
	roomId,
	labelParentId,
	handleClick,
}: {
	open: boolean;
	onClose: () => void;
	roomId?: number;
	labelParentId?: number;
	handleClick?: () => void;
}) => {
	const [imageUploadList, setImageUploadList] = useState<TImageUploadItem[]>(
		[]
	);
	const {
		clearErrors,
		handleSubmit,
		watch,
		setValue,
		control,
		getValues,
		formState: { errors },
	} = useFormContext<ImageGallerySectionType>();
	const setLoading = useLoadingStore((state) => state.setLoading);
	const setAlbumHotel = useAlbumHotelStore((state) => state.setAlbumHotel);
	const roomList = useRoomStore((state) => state.roomList);
	const imagesUpload = useWatch({ control, name: 'imagesUpload' });

	useEffect(() => {
		if (imagesUpload) {
			setImageUploadList(imagesUpload);
		}
	}, [imagesUpload]);

	const handleRemoveImage = (index: number) => {
		setValue(
			'filesUpload',
			imageUploadList
				.filter((img, idx) => index !== idx)
				.map((item) => item.file as File),
			{ shouldValidate: true }
		);

		const updatedImages = imagesUpload?.filter((_, idx) => index !== idx);

		setValue('imagesUpload', updatedImages);
		clearErrors('imagesUpload');
		if (watch('filesUpload')?.length === 0) {
			onClose();
		}
	};
	const onSubmit = async (data: ImageGallerySectionType) => {
		const hotel_id = getClientSideCookie('hotel_id');
		const room =
			roomId && (roomList?.length ?? 0) > 0
				? roomList?.find((room) => room.id === +roomId)
				: undefined;
		const slug = room ? kebabCase(room.name) : `all-image-${hotel_id}`;

		setLoading(true);

		const images: IImage[] = data?.imagesUpload?.map((img, idx) => ({
			image: img.file as File,
			label_id: img.tag,
			priority: String(idx + (getValues('images')?.length ?? 0)),
		})) as IImage[];

		const body: CreateAlbumRequestBody = {
			slug,
			list_all: true,
			...(roomId && { room_id: String(roomId) }),
			images
		};

		const res = await createAlbum<HotelRoomsResponse>(body).finally(() =>
			setLoading(false)
		);

		if (res && res.status) {
			toast.success(`Upload ảnh thành công`);
			setAlbumHotel(res.data);
			onClose();
		}
	};
	return (
		<Dialog
			open={open}
			onOpenChange={(open) => {
				if (!open) {
					onClose();
					setImageUploadList([]);
				}
			}}>
			<DialogHeader className={'hidden'}>
				<DialogTitle />
				<DialogDescription />
			</DialogHeader>
			<DialogContent
				onPointerDownOutside={onClose}
				hideButtonClose={true}
				className="flex max-h-[90vh] flex-col py-0 sm:max-w-[888px]">
				<div className={'z-10 flex items-center gap-2 pb-8 pt-6'}>
					<Typography
						tag={'h3'}
						variant={'content_16px_600'}
						text={'Tải lên ảnh mới'}
						className={'flex-1 text-neutral-700'}
					/>
					<DialogClose asChild>
						<Button
							onClick={onClose}
							className={
								'flex size-8 min-w-min cursor-pointer items-center justify-center rounded-full bg-neutral-50 p-2 hover:bg-neutral-200'
							}>
							<IconClose
								color={GlobalUI.colors.neutrals['500']}
								className={'size-5'}
							/>
						</Button>
					</DialogClose>
				</div>
				<div className={'flex-1 space-y-6 overflow-y-auto pr-4'}>
					{imageUploadList.length > 0 &&
						imageUploadList.map((img, idx) => (
							<ImageGalleryPreviewCard
								roomId={roomId}
								labelParentId={labelParentId}
								key={idx}
								handleRemoveImage={handleRemoveImage}
								idx={idx}
								img={img}
							/>
						))}
				</div>

				<div className={'left-0 pb-6 pt-8 text-right'}>
					<DialogClose asChild>
						<Button
							variant={'outline'}
							className={cn(
								'mr-2 rounded-xl border-2 border-neutral-100 bg-white px-6 py-3 text-neutral-700',
								TextVariants.caption_14px_600
							)}
							type={'button'}
							onClick={onClose}>
							Hủy bỏ
						</Button>
					</DialogClose>
					<Button
						onClick={handleClick ? handleClick : handleSubmit(onSubmit)}
						disabled={
							Object.values(errors).length > 0 ||
							(handleClick && imagesUpload?.some((image) => !image.tag))
						}
						type={'submit'}
						variant={'secondary'}
						className={cn(
							'rounded-xl border-2 border-neutral-100 bg-secondary-500 px-6 py-3 text-white',
							TextVariants.caption_14px_600
						)}>
						Áp dụng
					</Button>
				</div>
			</DialogContent>
		</Dialog>
	);
};
export default DialogUploadImageGallery;
