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
import { Controller, useFormContext } from 'react-hook-form';
import { IconCheckCircleV2, IconCloseCircle } from '@/assets/Icons/filled';
import { ImageDropzone } from '@/components/shared/ImageDropzone';
import { useAttributeStore } from '@/store/attributes/store';
import { ImageGallerySectionType } from '@/lib/schemas/album/image-gallery-section';
import SelectImageGalleryPopup from '@/containers/album-manager/common/SelectImageGalleryPopup';
import { useLoadingStore } from '@/store/loading/store';
import { v4 as uuidv4 } from 'uuid';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import { mapToLabelValue } from '@/containers/setting-room/helpers';
import { useAlbumHotelStore } from '@/store/album/store';
import { useShallow } from 'zustand/react/shallow';
import { HotelRoomsResponse } from '@/services/album/getAlbumHotel';
import {
	CreateAlbumRequestBody,
	createAlbum,
	IImage,
	IResponse,
} from '@/services/album/createAlbum';
import kebabCase from 'lodash/kebabCase';
import { useRoomStore } from '@/store/room/store';
import { getClientSideCookie } from '@/utils/cookie';
import {
	UpdateAlbumRequestBody,
	updateAlbum,
} from '@/services/album/updateAlbum';

const DialogEditImageGallery = ({
	open,
	onClose,
	image,
	selectedTag,
	index,
	image_id,
	roomId,
	labelParentId,
	localUpdateOnly = false,
}: {
	open: boolean;
	onClose: () => void;
	image?: File | string;
	selectedTag?: string;
	index?: number;
	image_id: number;
	roomId?: number;
	labelParentId?: number;
	localUpdateOnly?: boolean;
}) => {
	const {
		setValue,
		getValues,
		control,
		formState: { errors },
	} = useFormContext<ImageGallerySectionType>();
	const setLoading = useLoadingStore((state) => state.setLoading);
	const setAlbumHotel = useAlbumHotelStore((state) => state.setAlbumHotel);
	const [imageUrl, setImageUrl] = useState('');
	const [selectTag, setSelectTag] = useState('');
	const { imageTypeList, imageRoomList } = useAttributeStore(
		useShallow((state) => ({
			imageTypeList: state.imageTypeList,
			imageRoomList: state.imageRoomList,
		}))
	);
	const roomList = useRoomStore((state) => state.roomList);

	useEffect(() => {
		if (selectedTag) {
			setSelectTag(selectedTag);
		}
	}, [selectedTag]);

	useEffect(() => {
		if (typeof image === 'string') {
			setImageUrl(image);
		} else {
			if (image) {
				const url = URL.createObjectURL(image);
				setImageUrl(url);
			} else {
				setImageUrl('');
			}
		}
	}, [image]);

	const handleConfirmImage = async () => {
		const promiseArr: Promise<IResponse<HotelRoomsResponse> | null>[] = [];
		setLoading(true);

		const list = getValues('images');
		if (list && index !== undefined && index >= 0 && index < list.length) {
			const imageData = {
				id: uuidv4(),
				url: imageUrl,
				tag: selectTag,
				file:
					image instanceof File
						? image
						: getValues(`images.${index}`).file,
				image_id: image_id,
				priority: getValues(`images.${index}`).priority,
			};

			if (localUpdateOnly) {
				setValue(`images.${index}`, imageData);
			} else {
				if (image instanceof File) {
					const hotel_id = getClientSideCookie('hotel_id');
					const room =
						roomId && (roomList?.length ?? 0) > 0
							? roomList?.find((room) => room.id === +roomId)
							: undefined;
					const slug = room
						? kebabCase(room.name)
						: `all-image-${hotel_id}`;
					const images: IImage[] = [
						{
							image: image,
							priority: String(list[index].priority),
							label_id: selectTag,
						},
					];

					const bodyCreateAlbum: CreateAlbumRequestBody = {
						slug,
						images,
						list_all: true,
						...(roomId && { room_id: String(roomId) }),
					};
					promiseArr.push(
						createAlbum<HotelRoomsResponse>(bodyCreateAlbum)
					);

					const bodyUpdateAlbum: UpdateAlbumRequestBody = {
						...(roomId && { id: String(roomId) }),
						idsDeleteArr: [image_id],
						list_all: true,
					};
					promiseArr.push(
						updateAlbum<HotelRoomsResponse>(bodyUpdateAlbum)
					);
				} else {
					const bodyUpdateAlbum: UpdateAlbumRequestBody = {
						...(roomId && { id: String(roomId) }),
						list_all: true,
						images: [
							{
								label_id: selectTag,
								priority: String(list[index].priority),
								image_id: String(image_id),
							},
						],
					};
					promiseArr.push(
						updateAlbum<HotelRoomsResponse>(bodyUpdateAlbum)
					);
				}
			}
		}
		const [resStore, resUpdate] = await Promise.all(promiseArr).finally(
			() => setLoading(false)
		);

		const lastRes =
			(resStore?.finishAt ?? 0) > (resUpdate?.finishAt ?? 0)
				? resStore
				: resUpdate;

		setAlbumHotel(lastRes?.data);

		setSelectTag('');
		onClose();
	};

	return (
		<Dialog open={open} onOpenChange={(open) => !open && onClose()}>
			<DialogHeader className={'hidden'}>
				<DialogTitle />
				<DialogDescription />
			</DialogHeader>
			<DialogContent
				onPointerDownOutside={onClose}
				hideButtonClose={true}
				className="sm:max-w-[888px]">
				<div className={'space-y-8'}>
					<div className={'flex items-center gap-2'}>
						<Typography
							tag={'h3'}
							variant={'content_16px_600'}
							text={'Chỉnh sửa'}
							className={'flex-1 text-neutral-700'}
						/>
						<DialogClose asChild>
							<Button
								onClick={onClose}
								className={
									'flex size-8 min-w-min cursor-pointer items-center justify-center rounded-full bg-neutral-50 p-2 hover:bg-neutral-200'
								}>
								<IconClose
									color={GlobalUI.colors.neutrals['3']}
									className={'size-5'}
								/>
							</Button>
						</DialogClose>
					</div>
					<div
						className={
							'flex flex-col gap-4 md:grid md:grid-cols-[190px_,1fr]'
						}>
						<div className={'overflow-hidden rounded-lg'}>
							<Controller
								control={control}
								name="imageEdit"
								render={({ field: { ref, onChange } }) => (
									<ImageDropzone
										ref={ref}
										hoverEffect
										defaultImage={imageUrl}
										novalidate
										className={'h-[130px] w-full'}
										dropzoneClassName={'h-full w-full'}
										onSubmit={(file) => onChange(file[0])}
										placeholder={''}
									/>
								)}
							/>
						</div>
						<div>
							<Typography
								tag={'h4'}
								variant={'caption_14px_500'}
								className={'text-neutral-600'}>
								Thêm một thẻ để miêu tả ảnh
								<span className={'ml-1 text-red-500'}>*</span>
							</Typography>

							{roomId ? (
								<SelectPopup
									className="mt-2 h-11 rounded-lg bg-white"
									placeholder={'Thêm thẻ'}
									data={
										imageRoomList
											? mapToLabelValue(imageRoomList)
											: []
									}
									selectedValue={selectTag}
									onChange={(value) =>
										setSelectTag(`${value}`)
									}
								/>
							) : labelParentId ? (
								<SelectPopup
									className="mt-2 h-11 rounded-lg bg-white"
									placeholder={'Thêm thẻ'}
									data={
										imageTypeList
											? mapToLabelValue(
													imageTypeList?.find(
														(imageType) =>
															imageType.id ===
															labelParentId
													)?.children || []
												)
											: []
									}
									selectedValue={selectTag}
									onChange={(value) =>
										setSelectTag(`${value}`)
									}
								/>
							) : (
								<SelectImageGalleryPopup
									className="mt-2 h-11 rounded-lg bg-white"
									placeholder={'Thêm thẻ'}
									data={imageTypeList?.filter(
										(imageType) =>
											imageType.slug !== 'image_room'
									)}
									selectedValue={selectTag}
									onChange={(value) =>
										setSelectTag(`${value}`)
									}
								/>
							)}

							<div className={'mt-2'}>
								<div className={'space-y-2'}>
									{errors.imageEdit ? (
										<div className={'mt-3 space-y-3'}>
											<div
												className={
													'flex items-center gap-2'
												}>
												<IconCloseCircle />
												<Typography
													tag={'span'}
													variant={'caption_12px_500'}
													className={cn(
														'text-accent-03'
													)}>
													{errors.imageEdit?.message}
												</Typography>
											</div>
										</div>
									) : (
										<div
											className={
												'mt-3 flex items-center gap-2'
											}>
											<span>
												<IconCheckCircleV2 />
											</span>
											<Typography
												tag={'span'}
												variant={'caption_12px_500'}
												className={cn(
													'text-accent-02'
												)}>
												Tải ảnh thành công
											</Typography>
										</div>
									)}
								</div>
							</div>
						</div>
					</div>
					<div className={'text-right'}>
						<DialogClose asChild>
							<Button
								variant={'outline'}
								className={cn(
									'mr-2 rounded-xl border-2 border-neutral-100 bg-white px-6 py-3 text-neutral-700',
									TextVariants.caption_14px_600
								)}
								type={'button'}
								onClick={() => {
									if (image instanceof File) {
										URL.revokeObjectURL(imageUrl);
									}
									onClose();
								}}>
								Hủy bỏ
							</Button>
						</DialogClose>
						<Button
							variant={'secondary'}
							className={cn(
								'rounded-xl border-2 border-neutral-100 bg-secondary-500 px-6 py-3 text-white',
								TextVariants.caption_14px_600
							)}
							disabled={
								Object.values(errors).length > 0 || !selectTag
							}
							onClick={handleConfirmImage}>
							Áp dụng
						</Button>
					</div>
				</div>
			</DialogContent>
		</Dialog>
	);
};

export default DialogEditImageGallery;
