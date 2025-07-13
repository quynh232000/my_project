import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconSortArrowDown = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 24 24"
		fill="none"
		{...props}>
		<path
			d="M16 3V21"
			stroke={props.color || '#777E90'}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M11 16L16 21L21 16"
			stroke={props.color || '#777E90'}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M3 4H11"
			stroke={props.color || '#777E90'}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M5 8H11"
			stroke={props.color || '#777E90'}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M7 12H11"
			stroke={props.color || '#777E90'}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconSortArrowDown);
export default Memo;
