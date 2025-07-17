import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconCloseCircle = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 20 20"
		fill="none"
		{...props}>
		<circle cx={10} cy={10} r={10} fill={props.fill || '#FAE8E8'} />
		<path
			d="M5.83337 14.1666L14.1667 5.83325"
			stroke={props.color || '#D94747'}
			strokeWidth={1.41667}
			strokeMiterlimit={10}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M14.1667 14.1666L5.83337 5.83325"
			stroke={props.color || '#D94747'}
			strokeWidth={1.41667}
			strokeMiterlimit={10}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconCloseCircle);
export default Memo;
