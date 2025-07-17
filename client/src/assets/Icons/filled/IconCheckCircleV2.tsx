import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconCheckCircleV2 = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 20 20"
		fill="none"
		{...props}>
		<path
			d="M0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10Z"
			fill="#1E874C"
		/>
		<path
			d="M6.66666 10.2222L8.6954 12.5L13.3333 7.5"
			stroke="#FCFCFD"
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconCheckCircleV2);
export default Memo;
