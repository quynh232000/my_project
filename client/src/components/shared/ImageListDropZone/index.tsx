import React, { useCallback, useState } from 'react';
import { ErrorCode, FileRejection, useDropzone } from 'react-dropzone';
import { ALLOW_FILE_SIZE } from '@/constants/common';
import { cn } from '@/lib/utils';
import { RefCallBack } from 'react-hook-form';
import { toast } from 'sonner';
import IconImage from '@/assets/Icons/outline/IconImage';
import Typography from '@/components/shared/Typography';

interface ImageDropzoneProps {
	ref?: RefCallBack;
	className?: string;
	dropzoneClassName?: string;
	errorMessage?: string;
	placeholder?: React.ReactNode;
	onSubmit: (image: File[]) => void;
	dimension?: {
		width: number;
		height: number;
	};
	hideOnSelect?: boolean;
	novalidate?: boolean;
}

interface ImageFile extends File {
	width?: number;
	height?: number;
}

export const ImageListDropZone: React.FC<ImageDropzoneProps> = (props) => {
	const {
		ref,
		className,
		dropzoneClassName,
		errorMessage,
		dimension,
		onSubmit,
		hideOnSelect,
		novalidate,
		placeholder,
	} = props;

	const [, setUploadedImages] = useState<string[]>([]);

	const onDrop = useCallback(
		(acceptedFiles: File[]) => {
			const newImages: string[] = [];

			const readFiles = acceptedFiles.map((file) => {
				return new Promise<void>((resolve) => {
					const reader = new FileReader();
					reader.onload = (event) => {
						if (typeof event?.target?.result === 'string') {
							newImages.push(event.target.result);
							resolve();
						}
					};
					reader.readAsDataURL(file);
				});
			});

			Promise.all(readFiles).then(() => {
				if (!hideOnSelect) {
					setUploadedImages((prev) => [...prev, ...newImages]);
				}
			});

			onSubmit && onSubmit(acceptedFiles);
		},
		[onSubmit, hideOnSelect]
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
		multiple: true,
		...(!novalidate ? { maxSize: ALLOW_FILE_SIZE } : {}),
		...(!dimension || novalidate
			? {}
			: {
					getFilesFromEvent: async (event) => {
						const files =
							'dataTransfer' in event
								? event.dataTransfer?.files
								: 'target' in event &&
									  event.target instanceof HTMLInputElement
									? event.target?.files
									: null;
						const promises: Promise<File | DataTransferItem>[] = [];
						if (files) {
							for (let index = 0; index < files.length; index++) {
								const file: ImageFile = files[index];
								const promise: Promise<
									File | DataTransferItem
								> = new Promise((resolve) => {
									const image = new Image();
									image.onload = function () {
										file.width = image.width;
										file.height = image.height;
										resolve(file);
									};
									image.onerror = function () {
										resolve(file);
									};
									image.src = URL.createObjectURL(file);
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
			<input className={'absolute h-0 w-0 overflow-hidden'} ref={ref} />
			<div
				className={cn(
					'relative flex cursor-pointer flex-col items-center justify-center gap-2 overflow-hidden',
					dropzoneClassName,
					`${isDragActive && 'bg-secondary-100/30'}`
				)}
				{...getRootProps()}>
				<input {...getInputProps()} />
				{isDragActive ? (
					<Typography
						variant={'caption_12px_600'}
						className={'text-neutral-700'}>
						Thả tệp vào đây
					</Typography>
				) : placeholder ? (
					placeholder
				) : (
					<div
						className={'flex flex-col items-center justify-center'}>
						<span className={'rounded-full bg-secondary-50 p-2'}>
							<IconImage />
						</span>
					</div>
				)}
			</div>
			{errorMessage ? <p>{errorMessage}</p> : null}
		</div>
	);
};
