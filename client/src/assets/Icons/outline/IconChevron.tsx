import React from 'react';
import { IconProps } from '@/assets/Icons/type';

const IconChevron = ({ direction = 'up', ...props }: IconProps) => {
	return (
		<svg
			width="1rem"
			height="1rem"
			viewBox="0 0 14 8"
			fill="none"
			xmlns="http://www.w3.org/2000/svg"
			style={{
				transform:
					direction === 'up'
						? 'rotate(180deg)'
						: direction === 'left'
							? 'rotate(90deg)'
							: direction === 'right'
								? 'rotate(-90deg)'
								: 'rotate(0deg)',
			}}
			{...props}>
			<path
				d="M1 1.00002L7 7.00002L13 1.00002"
				stroke={props.color || '#777E90'}
				strokeWidth="1.7"
				strokeLinecap="round"
				strokeLinejoin="round"
				color={props.color || '#777E90'}
			/>
		</svg>
	);
};

export default IconChevron;
