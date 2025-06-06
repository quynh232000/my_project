import * as React from 'react';
import { memo } from 'react';
import { IconProps } from '@/assets/Icons/type';

const IconArrowV2 = ({ direction, ...props }: IconProps) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 24 24"
		fill="none"
		style={{
			transform:
				direction === 'left'
					? 'rotate(180deg)'
					: direction === 'up'
						? 'rotate(90deg)'
						: direction === 'down'
							? 'rotate(-90deg)'
							: 'rotate(0deg)',
		}}
		{...props}>
		<path
			d="M2.01411 11.9848C2.01411 11.4338 2.46111 10.9878 3.01211 10.9878L18.5761 10.9978L15.6081 7.99783L17.0141 6.59183L21.7331 11.2788C22.1231 11.6698 22.1231 12.3258 21.7331 12.7168L17.0141 17.4038L15.6081 15.9978L18.5761 12.9978L3.01211 12.9828C2.46111 12.9828 2.01411 12.5358 2.01411 11.9848Z"
			fill={props.color || '#777E90'}
		/>
	</svg>
);
const Memo = memo(IconArrowV2);
export default Memo;
