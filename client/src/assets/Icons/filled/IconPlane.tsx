import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconPlane = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="none" {...props}>
		<path
			d="M4.80018 15.5997L6.40019 15.5997L10.4002 9.19973L14.8002 9.19973C15.4642 9.19973 16.0002 8.66374 16.0002 7.99973C16.0002 7.33572 15.4642 6.79973 14.8002 6.79973L10.4002 6.79973L6.40019 0.399765L4.80018 0.399765L6.80017 6.79977L2.40018 6.79977L1.20019 5.19976L0.00018671 5.19976L0.800172 7.99977L0.000186466 10.7997L1.20019 10.7997L2.40018 9.19973L6.80021 9.19973L4.80018 15.5997Z"
			fill={props.color || '#777E90'}
		/>
	</svg>
);
const Memo = memo(IconPlane);
export default Memo;
