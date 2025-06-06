import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconCopy = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" {...props}>
		<path
			d="M8 8V6C8 3.79086 9.79086 2 12 2L18 2C20.2091 2 22 3.79086 22 6V12C22 14.2091 20.2091 16 18 16H16M8 8H6C3.79086 8 2 9.79086 2 12V18C2 20.2091 3.79086 22 6 22H12C14.2091 22 16 20.2091 16 18V16M8 8H12C14.2091 8 16 9.79086 16 12V16"
			stroke={props.color || '#777E90'}
			strokeWidth={2}
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconCopy);
export default Memo;
