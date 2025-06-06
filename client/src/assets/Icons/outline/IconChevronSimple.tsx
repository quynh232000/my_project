import * as React from 'react';
import { memo } from 'react';
import { IconProps } from '@/assets/Icons/type';

const IconChevronSimple = ({ direction = 'up', ...props }: IconProps) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 24 24"
		fill="none"
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
			fillRule="evenodd"
			clipRule="evenodd"
			d="M16.2071 9.79289C15.8166 9.40237 15.1834 9.40237 14.7929 9.79289L12 12.5858L9.20711 9.79289C8.81658 9.40237 8.18342 9.40237 7.79289 9.79289C7.40237 10.1834 7.40237 10.8166 7.79289 11.2071L11.2929 14.7071C11.6834 15.0976 12.3166 15.0976 12.7071 14.7071L16.2071 11.2071C16.5976 10.8166 16.5976 10.1834 16.2071 9.79289Z"
			fill={props.color || '#777E90'}
		/>
	</svg>
);
const Memo = memo(IconChevronSimple);
export default Memo;
