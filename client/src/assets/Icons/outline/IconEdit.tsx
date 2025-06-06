import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconEdit = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20" fill="none" {...props}>
		<path
			d="M10 16.6667H17.5M2.50002 16.6667H3.89548C4.30313 16.6667 4.50695 16.6667 4.69876 16.6206C4.86883 16.5798 5.0314 16.5125 5.18052 16.4211C5.34871 16.318 5.49284 16.1739 5.78109 15.8856L16.25 5.41669C16.9404 4.72633 16.9404 3.60704 16.25 2.91669C15.5597 2.22633 14.4404 2.22633 13.75 2.91669L3.28107 13.3856C2.99282 13.6739 2.84869 13.818 2.74562 13.9862C2.65424 14.1353 2.5869 14.2979 2.54607 14.468C2.50002 14.6598 2.50002 14.8636 2.50002 15.2713V16.6667Z"
			stroke={props.color||"#777E90"}
			strokeWidth={2}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconEdit);
export default Memo;
