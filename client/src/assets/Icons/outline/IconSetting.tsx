import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconSetting = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 25 24"
		fill="none"
		{...props}>
		<path
			d="M17.5 14L17.5 21"
			stroke="#002499"
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M17.5 3L17.5 6"
			stroke="#002499"
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M7.5 10L7.5 3"
			stroke="#002499"
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M7.5 21L7.5 18"
			stroke="#002499"
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M4.5 15C4.5 14 4.5 13 7.5 13C10.5 13 10.5 14 10.5 15C10.5 16.1046 10.5 17 7.5 17C4.5 17 4.5 16.1046 4.5 15Z"
			stroke={props.color || '#002499'}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M14.5 9C14.5 8 14.5 7 17.5 7C20.5 7 20.5 8 20.5 9C20.5 10.1046 20.5 11 17.5 11C14.5 11 14.5 10.1046 14.5 9Z"
			stroke={props.color || '#002499'}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconSetting);
export default Memo;
