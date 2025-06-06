import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconHalfMoon = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" {...props}>
		<path
			d="M5.67163 14.8687C10.751 14.8687 14.8687 10.751 14.8687 5.67163C14.8687 4.74246 14.7309 3.84548 14.4746 3C18.251 4.14461 21 7.65276 21 11.803C21 16.8824 16.8824 21 11.803 21C7.65276 21 4.14461 18.251 3 14.4746C3.84548 14.7309 4.74246 14.8687 5.67163 14.8687Z"
			stroke={props.color||"#777E90"}
			strokeWidth={2}
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconHalfMoon);
export default Memo;
