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
import { useFormContext } from 'react-hook-form';
import { AmenityType } from '@/containers/setting-room/RoomAmenities/data';

interface Props {
	onClose: () => void;
	open: boolean;
	originalList: AmenityType[];
}

const DialogResetSelect = ({ onClose, open, originalList }: Props) => {
	const { reset } = useFormContext();
	const resetSelectAmenities = () => {
		reset(
			originalList.reduce((acc, curr) => {
				return {
					...acc,
					[`${curr.id}`]: [],
				};
			}, {})
		);
		onClose();
	};

	return (
		<Dialog open={open} onOpenChange={(open) => !open && onClose()}>
			<DialogContent hideButtonClose={true} className="sm:max-w-[500px]">
				<DialogHeader className={'hidden'}>
					<DialogTitle></DialogTitle>
					<DialogDescription></DialogDescription>
				</DialogHeader>
				<div className={'p-8 pt-[50px]'}>
					<Typography
						tag={'h4'}
						variant={'headline_24px_600'}
						className={'text-center text-gray-900'}>
						Xóa tất cả tiện ích đã chọn?
					</Typography>
					<Typography
						tag={'p'}
						variant={'content_16px_400'}
						className={'mt-4 text-center text-neutral-600'}>
						Thao tác này sẽ xóa toàn bộ tiện ích mà bạn đã chọn.Bạn có chắc chắn
						muốn tiếp tục?
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
							onClick={resetSelectAmenities}
							variant={'destructive'}
							className={cn(
								'h-12 rounded-xl bg-accent-03 px-6 py-3 text-white',
								TextVariants.caption_14px_600
							)}>
							Xóa tiện ích
						</Button>
					</div>
				</div>
			</DialogContent>
		</Dialog>
	);
};

export default DialogResetSelect;
