import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconTelephone = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" {...props}>
		<g clipPath="url(#clip0_2_441)">
			<path
				d="M21.177 19.4484L19.3108 21.3146C19.3108 21.3146 14.4617 23.3928 7.53443 16.4655C0.607163 9.53823 2.68534 4.68914 2.68534 4.68914L4.55154 2.82295C5.39465 1.97984 6.78904 2.07893 7.50445 3.03281L9.28575 5.40787C9.87078 6.18792 9.79321 7.27945 9.10374 7.96892L7.53443 9.53823C7.53443 9.53823 7.53443 10.9237 10.3053 13.6946C13.0762 16.4655 14.4617 16.4655 14.4617 16.4655L16.031 14.8962C16.7205 14.2067 17.812 14.1291 18.5921 14.7142L20.9671 16.4955C21.921 17.2109 22.0201 18.6053 21.177 19.4484Z"
				fill="#777E90"
			/>
		</g>
		<defs>
			<clipPath id="clip0_2_441">
				<rect width={24} height={24} fill="white" />
			</clipPath>
		</defs>
	</svg>
);
const Memo = memo(IconTelephone);
export default Memo;
