'use client';
import { forwardRef, memo, Ref, useState } from 'react';
import Image, { ImageProps } from 'next/image';
import isEqual from 'lodash/fp/isEqual';
import { DefaultImages } from '@/assets';

interface AppImageProps extends ImageProps {
	alt: string;
	errorSrc?: string;
}

const AppImage = forwardRef(
	(props: AppImageProps, ref: Ref<HTMLImageElement>) => {
		const [status, setStatus] = useState(true);
		const { errorSrc, ...imageProps } = props;
		const defaultSrc = errorSrc || DefaultImages.banners.blue;
		return (
			<Image
				{...imageProps}
				ref={ref}
				src={status ? props.src || defaultSrc : defaultSrc}
				alt={props.alt}
				onError={() => {
					setStatus(false);
				}}
			/>
		);
	}
);

AppImage.displayName = 'AppImage';
export default memo(AppImage, (prevProps, nextProps) =>
	isEqual(prevProps, nextProps)
);
