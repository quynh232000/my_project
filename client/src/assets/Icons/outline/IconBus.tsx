import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconBus = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 20 14"
		fill="none"
		{...props}>
		<g clipPath="url(#clip0_396_817)">
			<path
				d="M10.464 5.06375H10.8443H11.264H13.3959H13.9455L14.1672 5.21124L15.5693 6.14426L15.7707 6.27824H16.0125H18.1131H18.681C18.6812 6.41413 18.681 6.61454 18.6807 6.90329L18.6805 7.08513C18.6798 7.75007 18.6788 8.80112 18.6788 10.4345C18.6788 10.8318 18.3541 11.1565 17.9567 11.1565H16.9716H16.6211C16.5246 10.1342 15.6582 9.33214 14.6104 9.33214C13.5603 9.33214 12.7002 10.1317 12.6047 11.1565H12.2544H6.31743H5.96701C5.87117 10.1378 5.01323 9.33214 3.96143 9.33214C2.91532 9.33214 2.04676 10.1281 1.95057 11.1565H1.60021H1.52202C1.12465 11.1565 0.8 10.8318 0.8 10.4345V5.06375H1.2197H3.35158H3.76607H4.15158H4.56607H6.69794H7.11764H7.49794H7.91764H10.0443H10.464Z"
				stroke={props.color || '#777E90'}
				strokeWidth={1.6}
				strokeMiterlimit={10}
			/>
		</g>
		<defs>
			<clipPath id="clip0_396_817">
				<rect width={20} height={14} fill="white" />
			</clipPath>
		</defs>
	</svg>
);
const Memo = memo(IconBus);
export default Memo;
