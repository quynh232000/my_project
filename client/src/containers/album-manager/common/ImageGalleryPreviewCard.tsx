'use client';
import React from 'react';
import Image from 'next/image';
import IconTrash from '@/assets/Icons/outline/IconTrash';
import Typography from '@/components/shared/Typography';
import { IconCheckCircleV2, IconCloseCircle } from '@/assets/Icons/filled';
import { cn } from '@/lib/utils';
import { useFormContext } from 'react-hook-form';
import { ImageGallerySectionType } from '@/lib/schemas/album/image-gallery-section';
import { TImageUploadItem } from '@/containers/album-manager/common/DialogUploadImageGallery';
import { FormField, FormItem, FormLabel } from '@/components/ui/form';
import SelectImageGalleryPopup from '@/containers/album-manager/common/SelectImageGalleryPopup';
import { useAttributeStore } from '@/store/attributes/store';
import SelectPopup from '@/components/shared/Select/SelectPopup';
import { mapToLabelValue } from '@/containers/setting-room/helpers';
import { useShallow } from 'zustand/react/shallow';

const ImageGalleryPreviewCard = ({
	img,
	handleRemoveImage,
	idx,
	roomId,
	labelParentId,
}: {
	img: TImageUploadItem;
	handleRemoveImage: (idx: number) => void;
	idx: number;
	roomId?: number;
	labelParentId?: number;
}) => {
	const {
		control,
		formState: { errors, validatingFields },
	} = useFormContext<ImageGallerySectionType>();

	const { imageTypeList, imageRoomList } = useAttributeStore(
		useShallow((state) => ({
			imageTypeList: state.imageTypeList,
			imageRoomList: state.imageRoomList,
		}))
	);

	return (
		<div className={'grid grid-cols-[190px_,1fr] gap-4'}>
			<div className={'group relative'}>
				<Image
					src={img.url}
					alt={`Album Ảnh`}
					width={304}
					height={204}
					className={'aspect-[3/2] rounded-lg object-cover'}
				/>
				<div
					className={
						'absolute inset-0 hidden items-center justify-center rounded-lg bg-black/40 group-hover:flex'
					}>
					<span
						onClick={() => handleRemoveImage(idx)}
						className={'cursor-pointer'}>
						<IconTrash width={32} height={32} color={'#fff'} />
					</span>
				</div>
			</div>
			<div>
				<FormField
					control={control}
					name={`imagesUpload.${idx}.tag`}
					render={({ field: { value, onChange, ...props } }) => (
						<FormItem>
							<FormLabel required>
								Thêm một thẻ để miêu tả ảnh
							</FormLabel>
							{roomId ? (
								<SelectPopup
									disabled={
										errors.filesUpload?.[idx] !== undefined
									}
									className={'h-10 rounded-lg'}
									placeholder={'Thêm thẻ'}
									data={
										imageRoomList
											? mapToLabelValue(imageRoomList)
											: []
									}
									selectedValue={value}
									onChange={(value) => onChange(`${value}`)}
									controllerRenderProps={props}
								/>
							) : labelParentId ? (
								<SelectPopup
									disabled={
										errors.filesUpload?.[idx] !== undefined
									}
									className={'h-10 rounded-lg'}
									placeholder={'Thêm thẻ'}
									data={
										imageTypeList
											? mapToLabelValue(
													imageTypeList.find(
														(imageType) =>
															imageType.id ===
															labelParentId
													)?.children || []
												)
											: []
									}
									selectedValue={value}
									onChange={(value) => onChange(`${value}`)}
									controllerRenderProps={props}
								/>
							) : (
								<SelectImageGalleryPopup
									disabled={
										errors.filesUpload?.[idx] !== undefined
									}
									className={'h-10 rounded-lg'}
									placeholder={'Thêm thẻ'}
									data={imageTypeList?.filter(
										(imageType) =>
											imageType.slug !== 'image_room'
									)}
									selectedValue={value}
									onChange={(value) => onChange(`${value}`)}
									controllerRenderProps={props}
								/>
							)}
						</FormItem>
					)}
				/>

				{!validatingFields.filesUpload ? (
					(errors.filesUpload && errors.filesUpload?.[idx]) ||
					(errors.imagesUpload && errors.imagesUpload?.[idx]) ? (
						<div className={'mt-3 space-y-3'}>
							<div className={'flex items-center gap-2'}>
								<IconCloseCircle />
								<Typography
									tag={'span'}
									variant={'caption_12px_500'}
									className={cn('text-accent-03')}>
									{errors.filesUpload?.[idx]?.message ||
										errors.imagesUpload?.[idx]?.tag
											?.message}
								</Typography>
							</div>
						</div>
					) : (
						<div className={'mt-3 flex items-center gap-2'}>
							<span>
								<IconCheckCircleV2 />
							</span>
							<Typography
								tag={'span'}
								variant={'caption_12px_500'}
								className={cn('text-accent-02')}>
								Tải ảnh thành công
							</Typography>
						</div>
					)
				) : null}
			</div>
		</div>
	);
};

export default ImageGalleryPreviewCard;
