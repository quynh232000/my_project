import React from 'react';
import { IconProps } from '@/assets/Icons/type';

const ExampleIcon = ({ width = 32, height = 32, className }: IconProps) => {
	return (
		<svg
			width={width}
			height={height}
			viewBox="0 0 32 32"
			fill="none"
			xmlns="http://www.w3.org/2000/svg"
			className={className}>
			{/* Add your svg path here */}
		</svg>
	);
};

export default ExampleIcon;
