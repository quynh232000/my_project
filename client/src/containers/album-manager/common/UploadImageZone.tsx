import React from 'react';
import { ImageListDropZone } from '@/components/shared/ImageListDropZone';
import { Controller, useFormContext } from 'react-hook-form';
import { ImageGallerySectionType } from '@/lib/schemas/album/image-gallery-section';

const UploadImageZone = ({placeholder} : {placeholder?: React.ReactNode}) => {
	const { control,setValue } = useFormContext<ImageGallerySectionType>();

	return (
		<Controller
			control={control}
			name={'filesUpload'}
			render={({ field: { onChange, ref } }) => (
				<ImageListDropZone
					ref={ref}
					novalidate
					hideOnSelect
					placeholder={placeholder}
					dropzoneClassName={
						'min-h-[191px] h-full rounded-xl w-auto border border-dashed bg-white border-other-divider-01 '
					}
					onSubmit={(file) => {
						onChange(file);
						setValue(
							'imagesUpload',
							file.map((item) => ({
								url:  URL.createObjectURL(item),
								tag: '',
								file: item,
								priority: 0
							}))
						);
					}}
				/>
			)}
		/>
	);
};

export default UploadImageZone;
