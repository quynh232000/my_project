import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconFilter = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" {...props}>
		<path d="M17 14L17 21" stroke={props.color||"#777E90"} strokeWidth={1.7} strokeLinecap="round" strokeLinejoin="round" />
		<path d="M17 3L17 6" stroke={props.color||"#777E90"} strokeWidth={1.7} strokeLinecap="round" strokeLinejoin="round" />
		<path d="M7 10L7 3" stroke={props.color||"#777E90"} strokeWidth={1.7} strokeLinecap="round" strokeLinejoin="round" />
		<path d="M7 21L7 18" stroke={props.color||"#777E90"} strokeWidth={1.7} strokeLinecap="round" strokeLinejoin="round" />
		<path
			d="M4 15C4 14 4 13 7 13C10 13 10 14 10 15C10 16.1046 10 17 7 17C4 17 4 16.1046 4 15Z"
			stroke={props.color||"#777E90"}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M14 9C14 8 14 7 17 7C20 7 20 8 20 9C20 10.1046 20 11 17 11C14 11 14 10.1046 14 9Z"
			stroke={props.color||"#777E90"}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconFilter);
export default Memo;
