import IconEdit from '@/assets/Icons/outline/IconEdit';
import Typography from '@/components/shared/Typography';
import { ALLOW_FILE_SIZE } from '@/constants/common';
import { cn } from '@/lib/utils';
import NextImage from 'next/image';
import React, { useCallback, useEffect, useState } from 'react';
import { ErrorCode, FileRejection, useDropzone } from 'react-dropzone';
import { RefCallBack } from 'react-hook-form';
import { toast } from 'sonner';

interface ImageDropzoneProps {
	defaultImage?: string;
	ref?: RefCallBack;
	label?: string;
	required?: boolean;
	className?: string;
	dropzoneClassName?: string;
	errorMessage?: string;
	onSubmit: (image: File[]) => void;
	placeholder: React.ReactNode;
	dimension?: {
		width: number;
		height: number;
	};
	hoverEffect?: boolean;
	hideOnSelect?: boolean;
	novalidate?: boolean;
}

interface ImageFile extends File {
	width?: number;
	height?: number;
}

export const ImageDropzone: React.FC<ImageDropzoneProps> = (props) => {
	const {
		defaultImage,
		label,
		ref,
		required,
		placeholder,
		hoverEffect,
		className,
		dropzoneClassName,
		errorMessage,
		dimension,
		onSubmit,
		hideOnSelect,
		novalidate,
	} = props;

	const [uploadedImageURL, setUploadedImageURL] = useState<string>('');

	useEffect(() => {
		if (defaultImage) {
			setUploadedImageURL((prev) => {
				if (prev !== defaultImage) {
					URL.revokeObjectURL(prev);
				}
				return defaultImage;
			});
		}
	}, [defaultImage]);

	const onDrop = useCallback(
		(acceptedFiles: File[]) => {
			const file = acceptedFiles?.[0];
			if (file) {
				if (uploadedImageURL) {
					URL.revokeObjectURL(uploadedImageURL);
				}
				const newObjectUrl = URL.createObjectURL(file);
				setUploadedImageURL(!hideOnSelect ? newObjectUrl : '');
				onSubmit && onSubmit(acceptedFiles);
			}
		},
		[onSubmit, hideOnSelect, uploadedImageURL]
	);

	const onDropRejected = (fileRejections: FileRejection[]) => {
		const code = fileRejections?.[0]?.errors?.[0]?.code;
		let message = fileRejections?.[0]?.errors?.[0]?.message;
		switch (code) {
			case ErrorCode.TooManyFiles:
				message = 'Chỉ cho phép tải lên một ảnh!';
				break;
			case ErrorCode.FileTooLarge:
				message = 'Kích thước ảnh tải lên không hợp lệ!';
				break;
			case ErrorCode.FileInvalidType:
				message = 'Ảnh tải lên không đúng định dạng!';
				break;
		}
		if (message) {
			toast.error('Lỗi khi tải ảnh lên!', {
				description: message,
			});
		}
	};

	const dimensionValidate = (file: ImageFile) => {
		if (file.width && file.height && dimension) {
			if (
				file.width < dimension.width ||
				file.height < dimension.height
			) {
				return {
					code: 'dimension-wrong',
					message: `Ảnh không đạt kích thước tối thiểu: ${dimension.width}x${dimension.height}px`,
				};
			}
		}
		return null;
	};

	const { getRootProps, getInputProps, isDragActive } = useDropzone({
		onDrop,
		onDropRejected,
		accept: {
			'image/png': [],
			'image/jpg': [],
			'image/jpeg': [],
		},
		multiple: false,
		...(!novalidate ? { maxSize: ALLOW_FILE_SIZE } : {}),
		...(!dimension || novalidate
			? {}
			: {
					getFilesFromEvent: async (event) => {
						const files =
							'dataTransfer' in event
								? event?.dataTransfer?.files
								: 'target' in event &&
									  event.target instanceof HTMLInputElement
									? event?.target?.files
									: null;
						const promises: Promise<File | DataTransferItem>[] = [];
						if (files) {
							for (let index = 0; index < files.length; index++) {
								const file: ImageFile = files[index];
								const promise: Promise<
									File | DataTransferItem
								> = new Promise((resolve, _) => {
									const image = new Image();
									const url = URL.createObjectURL(file);
									setUploadedImageURL(url);
									image.src = url;
									image.onload = function () {
										file.width = image.width;
										file.height = image.height;
										URL.revokeObjectURL(url);
										resolve(file);
									};
									image.onerror = function (_) {
										URL.revokeObjectURL(url);
										resolve(file);
									};
								});
								promises.push(promise);
							}
						}
						return await Promise.all(promises);
					},
					validator: dimensionValidate,
				}),
	});

	return (
		<div className={cn('relative flex flex-col gap-2', className)}>
			{label ? (
				<Typography
					variant={'caption_14px_500'}
					className={'text-neutral-600'}>
					{label}{' '}
					{required && <span className={'text-red-500'}>*</span>}
				</Typography>
			) : null}
			<input
				className={'absolute h-0 w-0 overflow-hidden'}
				ref={ref}
				title="dropzone-area"
			/>

			<div
				className={cn(
					'relative flex cursor-pointer flex-col items-center justify-center gap-2 overflow-hidden',
					dropzoneClassName,
					`${uploadedImageURL && '!border-none'} ${isDragActive && 'bg-secondary-100/30'}`
				)}
				{...getRootProps()}>
				<input
					{...getInputProps()}
					title="dropzone-area"
					placeholder="Dropzone area"
				/>
				{isDragActive ? (
					<Typography
						variant={'caption_12px_600'}
						className={'text-neutral-700'}>
						Thả tệp vào đây
					</Typography>
				) : uploadedImageURL ? (
					<NextImage
						width={800}
						height={600}
						className={'h-full w-full bg-neutral-200 object-cover'}
						src={uploadedImageURL}
						alt="Uploaded"
					/>
				) : (
					<>{placeholder}</>
				)}
				{!!uploadedImageURL && hoverEffect && (
					<div
						className={
							'group absolute inset-0 bg-transparent transition-all hover:bg-other-overlay'
						}>
						<div
							className={
								'absolute left-1/2 top-1/2 flex h-10 w-10 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white opacity-0 transition-all group-hover:opacity-100'
							}>
							<IconEdit className={'size-6'} />
						</div>
					</div>
				)}
			</div>
			{errorMessage ? <p>{errorMessage}</p> : null}
		</div>
	);
};
