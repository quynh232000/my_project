import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconBed = (props: SVGProps<SVGSVGElement>) => (
	<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" {...props}>
		<path
			d="M18.9407 18.4238V19.8729M5.28814 18.4238V19.8729M19.4746 12.9322V8.81359C19.4746 6.70744 17.7672 5.00003 15.661 5.00003H8.33898C6.23283 5.00003 4.52542 6.70744 4.52542 8.81359V12.9322M16.7288 10.6441C16.7288 10.6441 15.6696 9.69071 14.363 9.69071C13.0564 9.69071 11.9972 10.6441 11.9972 10.6441C11.9972 10.6441 10.9222 9.69071 9.59605 9.69071C8.26992 9.69071 7.19492 10.6441 7.19492 10.6441M18.8644 13.3899H5.13559C3.95614 13.3899 3 14.346 3 15.5255V16.2119C3 17.3914 3.95614 18.3475 5.13559 18.3475H18.8644C20.0439 18.3475 21 17.3914 21 16.2119V15.5255C21 14.346 20.0439 13.3899 18.8644 13.3899Z"
			stroke={'currentColor'}
			strokeWidth={2}
			strokeMiterlimit={10}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconBed);
export default Memo;
