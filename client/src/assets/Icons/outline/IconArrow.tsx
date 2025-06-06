import React from 'react';
import { IconProps } from '@/assets/Icons/type';

const IconArrow = ({ direction, ...props }: IconProps) => {
	return (
		<svg
			width="1em"
			height="1em"
			viewBox="0 0 24 24"
			fill="none"
			xmlns="http://www.w3.org/2000/svg"
			style={{
				transform:
					direction === 'right'
						? 'rotate(180deg)'
						: direction === 'up'
							? 'rotate(90deg)'
							: direction === 'down'
								? 'rotate(-90deg)'
								: 'rotate(0deg)',
			}}
			{...props}>
			<path
				d="M12.7071 5.70714C13.0976 5.31661 13.0976 4.68345 12.7071 4.29292C12.3166 3.9024 11.6834 3.9024 11.2929 4.29292L4.29289 11.2929C3.90237 11.6834 3.90237 12.3166 4.29289 12.7071L11.2929 19.7071C11.6834 20.0977 12.3166 20.0977 12.7071 19.7071C13.0976 19.3166 13.0976 18.6834 12.7071 18.2929L7.41421 13L19 13C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11L7.41421 11L12.7071 5.70714Z"
				fill={props.color || '#777E90'}
			/>
		</svg>
	);
};

export default IconArrow;
