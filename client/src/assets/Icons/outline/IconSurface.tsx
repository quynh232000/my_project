import * as React from 'react';
import { SVGProps, memo } from 'react';
const IconSurface = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 20 22"
		fill="none"
		{...props}>
		<path
			d="M10 1V2M10 20V21M18.6602 6L17.7942 6.5M2.20575 15.5L1.33972 16M1.33972 6L2.20575 6.5M17.7942 15.5L18.6602 16M16 11C16 14.3137 13.3137 17 10 17C6.68629 17 4 14.3137 4 11C4 7.68629 6.68629 5 10 5C13.3137 5 16 7.68629 16 11Z"
			stroke={props.color || '#777E90'}
			strokeWidth={2}
			strokeLinecap="round"
		/>
	</svg>
);
const Memo = memo(IconSurface);
export default Memo;
