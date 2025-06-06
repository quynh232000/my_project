import { SVGProps } from 'react';

export type IconProps = SVGProps<SVGSVGElement> & {
	direction?: 'up' | 'down' | 'left' | 'right';
};
