import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconDots = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" {...props}>
		<path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M10 12C10 10.8955 10.8954 10 12 10C13.1046 10 14 10.8955 14 12C14 13.1046 13.1046 14 12 14C10.8954 14 10 13.1046 10 12Z"
			fill={props.color||"#777E90"}
		/>
		<path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M17 12C17 10.8955 17.8954 10 19 10C20.1046 10 21 10.8955 21 12C21 13.1046 20.1046 14 19 14C17.8954 14 17 13.1046 17 12Z"
			fill={props.color||"#777E90"}
		/>
		<path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M3 12C3 10.8955 3.89543 10 5 10C6.10457 10 7 10.8955 7 12C7 13.1046 6.10457 14 5 14C3.89543 14 3 13.1046 3 12Z"
			fill={props.color||"#777E90"}
		/>
	</svg>
);
const Memo = memo(IconDots);
export default Memo;
