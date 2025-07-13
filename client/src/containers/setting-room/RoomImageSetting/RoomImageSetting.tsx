'use client';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { Form } from '@/components/ui/form';
import RoomImageList from '@/containers/setting-room/RoomImageSetting/common/RoomImageList';
import { useAlbumHotelStore } from '@/store/album/store';
import { useAttributeStore } from '@/store/attributes/store';
import { useLoadingStore } from '@/store/loading/store';
import { useRoomDetailStore } from '@/store/room-detail/store';
import { zodResolver } from '@hookform/resolvers/zod';
import kebabCase from 'lodash/kebabCase';
import React, { useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import { toast } from 'sonner';
import { v4 as uuidv4 } from 'uuid';
import UploadImageZone from '@/containers/album-manager/common/UploadImageZone';
import IconImage from '@/assets/Icons/outline/IconImage';
import Typography from '@/components/shared/Typography';
import { Label } from '@/components/ui/label';
import DialogUploadImageGallery from '@/containers/album-manager/common/DialogUploadImageGallery';
import DialogEditImageGallery from '@/containers/album-manager/common/DialogEditImageGallery';
import { IAlbumItem } from '@/services/album/getAlbum';
import {
	imageGallerySectionSchema,
	ImageGallerySectionType,
} from '@/lib/schemas/album/image-gallery-section';
import { useShallow } from 'zustand/react/shallow';
import {
	CreateAlbumRequestBody,
	createAlbum,
	IImage,
	IResponse,
} from '@/services/album/createAlbum';
import {
	IAlbumUpdate,
	UpdateAlbumRequestBody,
	updateAlbum,
} from '@/services/album/updateAlbum';

interface RoomImageSettingProps {
	onNext: () => void;
}

const RoomImageSetting = ({ onNext }: RoomImageSettingProps) => {
	const [dialogEditImage, setDialogEditImage] = useState<
		| {
				image: string | File;
				selectedTag?: string;
				index?: number;
				image_id?: number | null;
		  }
		| undefined
	>(undefined);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { fetchImageRoomList, fetchImageTypeList, fetchRoomTypeList } =
		useAttributeStore(
			useShallow((state) => ({
				fetchImageRoomList: state.fetchImageRoomList,
				fetchImageTypeList: state.fetchImageTypeList,
				fetchRoomTypeList: state.fetchRoomTypeList,
			}))
		);
	const setNeedFetch = useAlbumHotelStore((state) => state.setNeedFetch);
	const { roomDetail, fetchAlbum, album, setAlbum } = useRoomDetailStore();
	const [idsDeleted, setIdsDeleted] = useState<number[]>([]);
	const form = useForm<ImageGallerySectionType>({
		resolver: zodResolver(imageGallerySectionSchema(false)),
		mode: 'onChange',
	});

	const { handleSubmit, watch, setValue, reset } = form;
	const filesUpload = watch('filesUpload');
	const imagesUpload = watch('imagesUpload');
	const images = watch('images');
	const imageEdit = watch('imageEdit');

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
			setValue('imageEdit', '');
		}
	}, [dialogEditImage]);

	useEffect(() => {
		setLoading(true);
		Promise.all([
			fetchImageRoomList(),
			fetchAlbum(),
			fetchImageTypeList(),
			fetchRoomTypeList(),
		]).finally(() => setLoading(false));
	}, []);

	useEffect(() => {
		if (album && album.length > 0) {
			reset({
				images: album.map((item) => ({
					id: uuidv4(),
					url: item.image_url,
					tag: String(item.label_id),
					file: '',
					image_id: item.id,
					priority: item.priority ? item.priority : 0,
				})),
			});
		}
	}, [album]);

	const handleCloseDialogUploadImageGallery = () => {
		setValue('filesUpload', undefined);
		setValue('imagesUpload', undefined);
	};

	const onSubmit = async (data: ImageGallerySectionType) => {
		setLoading(true);

		const idsDeleteArr = [...idsDeleted];
		const promiseArr: Promise<IResponse<IAlbumItem[]> | null>[] = [];

		if (data.images) {
			const imagesStore = data.images.reduce(
				(acc, cur, index) => {
					if (cur.file instanceof File) {
						cur.image_id && idsDeleteArr.push(cur.image_id);
						acc[index] = {
							image: cur.file as File,
							label_id: String(cur.tag),
							priority: String(cur.priority),
						};
					}
					return acc;
				},
				{} as Record<
					string,
					{ image: File; label_id: string; priority: string }
				>
			);

			const imagesUpdate = data.images.reduce(
				(acc, cur) => {
					if (!cur.image_id) return acc;
					const original = album?.find(
						(item) => item.id === cur.image_id
					);
					if (!original) return acc;

					const tagChanged = Number(cur.tag) !== original.label_id;
					const priorityChanged =
						Number(cur.priority) !== original.priority;

					if (tagChanged || priorityChanged) {
						acc[cur.image_id] = {
							label_id: String(cur.tag),
							priority: String(cur.priority),
						};
					}
					return acc;
				},
				{} as Record<string, { label_id: string; priority: string }>
			);

			const imagesStoreKey = Object.keys(imagesStore);
			if (imagesStoreKey.length > 0) {
				const images: IImage[] = imagesStoreKey.map((key) => ({
					image: imagesStore[key].image,
					priority: imagesStore[key].priority,
					label_id: imagesStore[key].label_id,
				}));

				const body: CreateAlbumRequestBody = {
					slug: kebabCase(roomDetail.name),
					room_id: String(roomDetail.id),
					images,
				};

				promiseArr.push(createAlbum<IAlbumItem[]>(body));
			}

			const imageUpdateKeys = Object.keys(imagesUpdate);
			if (imageUpdateKeys.length > 0 || idsDeleteArr.length > 0) {
				const albumUpdate: IAlbumUpdate[] =
					imageUpdateKeys.length > 0
						? imageUpdateKeys.map(
								(key) =>
									({
										label_id: String(
											imagesUpdate[key].label_id
										),
										priority: String(
											imagesUpdate[key].priority
										),
										image_id: key,
									}) as IAlbumUpdate
							)
						: [];

				const bodyUpdateAlbum: UpdateAlbumRequestBody = {
					...(roomDetail.id && { id: String(roomDetail.id) }),
					idsDeleteArr,
					images: albumUpdate,
				};
				promiseArr.push(updateAlbum<IAlbumItem[]>(bodyUpdateAlbum));
			}

			const [resUpdate, resStore] = await Promise.all(promiseArr).finally(
				() => setLoading(false)
			);

			setIdsDeleted([]);

			if (resUpdate?.status || resStore?.status) {
				const lastRes =
					(resStore?.finishAt ?? 0) > (resUpdate?.finishAt ?? 0)
						? resStore
						: resUpdate;
				setAlbum(lastRes?.data);
				setNeedFetch(true);

				data?.images?.forEach((item) => {
					if (item.file instanceof File) {
						URL.revokeObjectURL(item.url);
					}
				});

				toast.success(
					resUpdate?.message ||
						resStore?.message ||
						'Thao tác thành công'
				);
			}
		}
	};

	return (
		<Form {...form}>
			<form
				onSubmit={handleSubmit(onSubmit)}
				encType={'multipart/form-data'}>
				<div className={'mt-6 space-y-4 rounded-2xl bg-white p-4'}>
					<UploadImageZone
						placeholder={
							<div
								className={
									'flex flex-col items-center justify-center'
								}>
								<span
									className={
										'rounded-full bg-secondary-50 p-2'
									}>
									<IconImage />
								</span>
								<Typography
									tag={'h3'}
									variant={'caption_14px_600'}
									className={'flex gap-1 text-neutral-600'}>
									Kéo và thả tệp vào đây, hoặc{' '}
									<Label
										htmlFor={'image'}
										className={
											'cursor-pointer text-secondary-500'
										}>
										duyệt
									</Label>
								</Typography>
							</div>
						}
					/>
					<RoomImageList
						onEdit={(id) => {
							const idx =
								images?.findIndex((item) => item.id === id) ??
								-1;
							if (idx >= 0) {
								setDialogEditImage({
									image:
										images?.[idx]?.file ||
										images?.[idx]?.url ||
										'',
									index: idx,
									selectedTag: images?.[idx]?.tag,
									image_id: images?.[idx]?.image_id,
								});
							}
						}}
						onRemove={async (id) => {
							const idx =
								images?.findIndex((item) => item.id === id) ??
								-1;
							if (idx >= 0) {
								const image_id = images?.[idx]?.image_id;
								image_id &&
									setIdsDeleted((ids) => [...ids, image_id]);
								setValue(
									'images',
									images
										?.filter(
											(_, indexItem: number) =>
												indexItem !== idx
										)
										.map((item, index) => ({
											...item,
											priority: index,
										}))
								);
								const url = images?.[idx]?.url;
								if (url?.startsWith('blob:')) {
									URL.revokeObjectURL(url);
								}
							}
						}}
					/>
				</div>
				<DialogUploadImageGallery
					roomId={roomDetail.id}
					open={!!filesUpload && filesUpload?.length > 0}
					onClose={handleCloseDialogUploadImageGallery}
					handleClick={() => {
						if (imagesUpload && imagesUpload.length > 0) {
							setValue('images', [
								...(images ? images : []),
								...imagesUpload.map((image, index) => ({
									...image,
									id: uuidv4(),
									image_id: null,
									priority: index + (images?.length ?? 0),
								})),
							]);
							handleCloseDialogUploadImageGallery();
						}
					}}
				/>
				<DialogEditImageGallery
					roomId={roomDetail.id}
					open={!!dialogEditImage}
					image={dialogEditImage?.image}
					onClose={() => {
						setDialogEditImage(undefined);
						setValue('imageEdit', '');
					}}
					selectedTag={dialogEditImage?.selectedTag}
					index={dialogEditImage?.index}
					image_id={dialogEditImage?.image_id as number}
					localUpdateOnly={true}
				/>

				<ButtonActionGroup
					actionCancel={onNext}
					disabledBtnConfirm={
						images?.length === album?.length &&
						images?.every((img) => {
							if (img.file instanceof File) return false;
							const imgIndex = album?.find(
								(item) => item.id === img.image_id
							);
							if (imgIndex) {
								if (String(imgIndex.label_id) !== img.tag)
									return false;
								if (
									imgIndex.priority !== img.priority &&
									imgIndex.priority !== null
								)
									return false;
							}
							return true;
						})
					}
				/>
			</form>
		</Form>
	);
};

export default RoomImageSetting;
