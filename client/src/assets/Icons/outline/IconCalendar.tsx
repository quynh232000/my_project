import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconCalendar = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 24 24"
		fill="none"
		{...props}>
		<path
			d="M21 10H3M16 2.00002V6.00002M8 2.00002V6.00002M7.8 22H16.2C17.8802 22 18.7202 22 19.362 21.673C19.9265 21.3854 20.3854 20.9265 20.673 20.362C21 19.7203 21 18.8802 21 17.2V8.80002C21 7.11986 21 6.27978 20.673 5.63804C20.3854 5.07356 19.9265 4.61462 19.362 4.327C18.7202 4.00002 17.8802 4.00002 16.2 4.00002H7.8C6.11984 4.00002 5.27976 4.00002 4.63803 4.327C4.07354 4.61462 3.6146 5.07356 3.32698 5.63804C3 6.27978 3 7.11986 3 8.80001V17.2C3 18.8802 3 19.7203 3.32698 20.362C3.6146 20.9265 4.07354 21.3854 4.63803 21.673C5.27976 22 6.11984 22 7.8 22Z"
			stroke={props.color || '#777E90'}
			strokeWidth={2}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconCalendar);
export default Memo;
