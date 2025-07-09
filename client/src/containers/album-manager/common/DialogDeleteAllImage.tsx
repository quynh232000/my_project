"use client"
import React from 'react';
import {
	Dialog,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import Typography from '@/components/shared/Typography';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { useAlbumHotelStore } from '@/store/album/store';
import { useShallow } from 'zustand/react/shallow';
import { useLoadingStore } from '@/store/loading/store';
import { toast } from 'sonner';
import { HotelRoomsResponse, RoomImage } from '@/services/album/getAlbumHotel';
import { IAlbumUpdate, UpdateAlbumRequestBody, updateAlbum } from '@/services/album/updateAlbum';

interface Props {
	onClose: () => void;
	open: boolean;
}

const DialogDeleteAllImage = ({ onClose, open }: Props) => {
	const { deletedAlbumIds, setDeletedAlbumIds, setAlbumHotel, albumHotel } =
		useAlbumHotelStore(
			useShallow((state) => ({
				deletedAlbumIds: state.deletedAlbumIds,
				setDeletedAlbumIds: state.setDeletedAlbumIds,
				setAlbumHotel: state.setAlbumHotel,
				albumHotel: state.albumHotel,
			}))
		);

	const setLoading = useLoadingStore((state) => state.setLoading);

	const handleDeleteAlbumImage = async () => {
		if (deletedAlbumIds.length > 0) {
			setLoading(true);
			const arr = deletedAlbumIds.reduce(
				(acc, { id, room_id }) => {
					const key = room_id ?? 'all';
					if (!acc[key]) {
						acc[key] = {
							room_id: room_id ? room_id : undefined,
							images_id: [],
						};
					}
					acc[key].images_id.push(id);
					return acc;
				},
				{} as Record<
					string,
					{ room_id: string | undefined; images_id: string[] }
				>
			);

			const promises = Object.values(arr).map(({ room_id, images_id }) => {
				let images: RoomImage[] = [];
				if (albumHotel) {
					images = (
						!room_id
							? albumHotel.hotel
							: (Object.values(albumHotel.rooms).find(
									(room) => room.room.id === Number(room_id)
								)?.images ?? [])
					)
						.filter((item) => !images_id.includes(String(item.id)))
						.sort((a, b) => a.priority - b.priority);
				}

				const albumUpdate: IAlbumUpdate[] = images.length > 0 ?
					images.map((image, index) => ({
						priority: String(index),
						image_id: String(image.id)
					}) as IAlbumUpdate) : [];


				const bodyUpdateAlbum: UpdateAlbumRequestBody = {
					...(room_id && {id: String(room_id)}),
					list_all: true,
					idsDeleteArr: images_id.map(item => Number(item)),
					images: albumUpdate
				};

				return updateAlbum<HotelRoomsResponse>(bodyUpdateAlbum);
			});

			const result = await Promise.all(promises).finally(() =>
				setLoading(false)
			);
			const lastResult = result.sort(
				(a, b) =>
					(b?.finishAt?.getTime?.() ?? 0) - (a?.finishAt?.getTime?.() ?? 0)
			)[0];
			if (lastResult) {
				setAlbumHotel(lastResult.data);
				toast.success('Xóa ảnh thành công');
			}
		}
		setDeletedAlbumIds([]);
		onClose();
	};

	return (
		<Dialog open={open} onOpenChange={(open) => !open && onClose()}>
			<DialogContent hideButtonClose={true} className="sm:max-w-[500px] sm:max-h-[266px] p-0">
				<DialogHeader className={'hidden'}>
					<DialogTitle></DialogTitle>
					<DialogDescription></DialogDescription>
				</DialogHeader>
				<div className={'p-8 pt-[50px]'}>
					<Typography
						tag={'h4'}
						variant={'headline_24px_600'}
						className={'text-center text-gray-900'}>
						Xóa {deletedAlbumIds.length > 1 ? 'tất cả các ảnh' : 'ảnh mà bạn'}{' '}
						đã chọn?
					</Typography>
					<Typography
						tag={'p'}
						variant={'content_16px_400'}
						className={'mt-4 text-center text-neutral-600'}>
						Thao tác này sẽ xóa{' '}
						{deletedAlbumIds.length > 1 ? 'toàn bộ ảnh' : 'ảnh'} mà bạn đã
						chọn.Bạn có chắc chắn muốn tiếp tục?
					</Typography>
					<div className={'mt-10 flex items-center justify-center gap-4'}>
						<Button
							onClick={onClose}
							variant={'secondary'}
							className={cn(
								'h-12 rounded-xl bg-secondary-500 text-white',
								TextVariants.caption_14px_600
							)}>
							Giữ lại
						</Button>
						<Button
							onClick={handleDeleteAlbumImage}
							variant={'destructive'}
							className={cn(
								'h-12 rounded-xl bg-accent-03 px-6 py-3 text-white',
								TextVariants.caption_14px_600
							)}>
							Xóa
						</Button>
					</div>
				</div>
			</DialogContent>
		</Dialog>
	);
};

export default DialogDeleteAllImage;
