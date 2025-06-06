import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconMenu = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" {...props}>
		<path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M2 8.5C2 7.94772 2.44772 7.5 3 7.5H21C21.5523 7.5 22 7.94772 22 8.5C22 9.05228 21.5523 9.5 21 9.5H3C2.44772 9.5 2 9.05228 2 8.5Z"
			fill={props.color||"#777E90"}
		/>
		<path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M2 15.5C2 14.9477 2.44772 14.5 3 14.5H21C21.5523 14.5 22 14.9477 22 15.5C22 16.0523 21.5523 16.5 21 16.5H3C2.44772 16.5 2 16.0523 2 15.5Z"
			fill={props.color||"#777E90"}
		/>
	</svg>
);
const Memo = memo(IconMenu);
export default Memo;
