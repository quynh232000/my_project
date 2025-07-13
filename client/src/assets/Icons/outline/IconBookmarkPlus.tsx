import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconBookmarkPlus = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 24 24"
		fill="none"
		{...props}>
		<path
			d="M11.544 17.7336L5.45597 20.8527C4.79054 21.1936 4 20.7104 4 19.9627V5C4 3.34315 5.34315 2 7 2H17C18.6569 2 20 3.34315 20 5V19.9627C20 20.7104 19.2095 21.1936 18.544 20.8527L12.456 17.7336C12.1697 17.5869 11.8303 17.5869 11.544 17.7336Z"
			stroke={props.color || '#777E90'}
			strokeWidth={2}
			strokeLinejoin="round"
		/>
		<path
			d="M12 7L12 13"
			stroke={props.color || '#777E90'}
			strokeWidth={2}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M15 10L9 10"
			stroke={props.color || '#777E90'}
			strokeWidth={2}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconBookmarkPlus);
export default Memo;
