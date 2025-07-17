import * as React from 'react';
import { SVGProps, memo } from 'react';
const IconStarFill = (props: SVGProps<SVGSVGElement>) => (
	<svg
		width="1em"
		height="1em"
		viewBox="0 0 18 19"
		fill="none"
		xmlns="http://www.w3.org/2000/svg"
		{...props}>
		<g id="Icons/Filled/IconStarFill">
			<path
				id="Vector"
				d="M9.01779 2.00586C8.58961 2.00571 8.15236 2.27211 7.89338 2.80236L6.30046 6.08189L2.66956 6.59721C1.50189 6.75966 1.12359 7.90522 1.96681 8.72872L4.59039 11.2825L3.98139 14.8667C3.78084 16.027 4.74316 16.7282 5.78514 16.1785C6.18774 15.9655 8.25781 14.893 9.01779 14.4917L12.2504 16.1785C13.2936 16.7282 14.2589 16.0277 14.0542 14.8667L13.4217 11.2825L16.0454 8.72872C16.8926 7.90822 16.5338 6.76296 15.366 6.59721L11.7117 6.08189L10.1422 2.80236C9.88359 2.27189 9.44596 2.00608 9.01779 2.00586Z"
				fill={props.color || '#F5D93D'}
			/>
		</g>
	</svg>
);
const Memo = memo(IconStarFill);
export default Memo;
