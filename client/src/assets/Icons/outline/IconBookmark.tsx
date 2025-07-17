import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconBookmark = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 24 24"
		fill="none"
		{...props}>
		<path
			d="M11.5039 18.2835L6.49614 21.1451C5.82948 21.526 5 21.0446 5 20.2768V6C5 4.34315 6.34315 3 8 3H16C17.6569 3 19 4.34315 19 6V20.2768C19 21.0446 18.1705 21.526 17.5039 21.1451L12.4961 18.2835C12.1887 18.1078 11.8113 18.1078 11.5039 18.2835Z"
			stroke="white"
			strokeWidth={2}
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconBookmark);
export default Memo;
