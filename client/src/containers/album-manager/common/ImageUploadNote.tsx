import React from 'react';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { cn } from '@/lib/utils';

const ImageUploadNote = () => {
	return (
		<div className={cn('text-neutral-400', TextVariants.caption_14px_500)}>
			Lưu ý khi tải ảnh: JPG/JPEG, dưới 2MB, tối thiểu 798×532px (tỉ lệ
			3:2)
		</div>
	);
};

export default ImageUploadNote;
