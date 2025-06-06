import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconMinus = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" {...props}>
		<path
			d="M4 12C4 11.4527 4.44366 11.009 4.99095 11.009H19.009C19.5563 11.009 20 11.4527 20 12C20 12.5473 19.5563 12.991 19.009 12.991H4.99095C4.44366 12.991 4 12.5473 4 12Z"
			fill={props.color || '#777E90'}
		/>
	</svg>
);
const Memo = memo(IconMinus);
export default Memo;
