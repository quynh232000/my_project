import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconPassenger = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 12 16"
		fill="none"
		{...props}>
		<circle cx={6} cy={4.5701} r={4} fill="#777E90" />
		<path
			d="M0 15.5701C0 12.2564 2.68629 9.5701 6 9.5701C9.31371 9.5701 12 12.2564 12 15.5701H0Z"
			fill="#777E90"
		/>
	</svg>
);
const Memo = memo(IconPassenger);
export default Memo;
