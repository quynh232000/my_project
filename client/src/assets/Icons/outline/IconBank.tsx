import * as React from 'react';
import { memo, SVGProps } from 'react';

const IconBank = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 20 20"
		fill="none"
		{...props}>
		<path
			d="M3.16148 8.13956V15.4429C2.39072 15.4429 1.76587 16.0678 1.76587 16.8385C1.76587 17.6093 2.39072 18.2341 3.16148 18.2341H16.8385C17.6093 18.2341 18.2341 17.6093 18.2341 16.8385C18.2341 16.0678 17.6093 15.4429 16.8385 15.4429V8.13956M17.375 4.66393L11.0729 1.97954C10.7426 1.84186 10.3802 1.76587 10 1.76587C9.61983 1.76587 9.25739 1.84186 8.92709 1.97954L2.62504 4.66393C2.12053 4.87418 1.76587 5.37203 1.76587 5.95271C1.76587 6.72348 2.39072 7.34833 3.16148 7.34833H16.8385C17.6093 7.34833 18.2341 6.72348 18.2341 5.95271C18.2341 5.37203 17.8795 4.87418 17.375 4.66393Z"
			stroke={props.color || '#777E90'}
			strokeWidth={1.9}
			strokeMiterlimit={10}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M8.60439 15.4429V11.5352C8.60439 10.7644 7.97954 10.1396 7.20877 10.1396C6.43801 10.1396 5.81316 10.7644 5.81316 11.5352V15.4429M14.1868 15.4429V11.5352C14.1868 10.7644 13.562 10.1396 12.7912 10.1396C12.0205 10.1396 11.3956 10.7644 11.3956 11.5352V15.4429"
			stroke={props.color || '#777E90'}
			strokeWidth={1.6}
			strokeMiterlimit={10}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
);
const Memo = memo(IconBank);
export default Memo;
