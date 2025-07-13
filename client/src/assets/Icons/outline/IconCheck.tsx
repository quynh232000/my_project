import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconCheck = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 24 24"
		fill="none"
		{...props}>
		<path
			d="M6 12L10 16L18 8"
			stroke={props.color || '#777E90'}
			strokeWidth={2}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconCheck);
export default Memo;
