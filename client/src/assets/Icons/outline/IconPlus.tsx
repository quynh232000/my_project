import * as React from 'react';
import { SVGProps, memo } from 'react';

type IconPlusProps = SVGProps<SVGSVGElement> & {
	width?: string | number;
	height?: string | number;
};

const IconPlus = ({ width = 24, height = 24, ...props }: IconPlusProps) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width={width}
		height={height}
		viewBox="0 0 24 24"
		fill="none"
		{...props}>
		<path
			d="M12 3.18042C11.4591 3.18042 11.02 3.61944 11.02 4.16037V11.02H4.16037C3.61944 11.02 3.18042 11.4591 3.18042 12C3.18042 12.5409 3.61944 12.98 4.16037 12.98H11.02V19.8396C11.02 20.3806 11.4591 20.8196 12 20.8196C12.5409 20.8196 12.98 20.3806 12.98 19.8396V12.98H19.8396C20.3806 12.98 20.8196 12.5409 20.8196 12C20.8196 11.4591 20.3806 11.02 19.8396 11.02H12.98V4.16037C12.98 3.61944 12.5409 3.18042 12 3.18042Z"
			fill={props.color || '#777E90'}
		/>
	</svg>
);

const Memo = memo(IconPlus);
export default Memo;
