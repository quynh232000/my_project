import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconCheckCircle = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20" fill="none" {...props}>
		<circle cx={10} cy={10} r={10} fill="#EEFBF4" />
		<path
			d="M5.83331 10.2778L8.36924 13.125L14.1666 6.875"
			stroke="#4B9F70"
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconCheckCircle);
export default Memo;
