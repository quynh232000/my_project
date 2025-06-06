import * as React from "react"
import { SVGProps, memo } from "react"
const SvgComponent = (props: SVGProps<SVGSVGElement>) => (
	<svg
		width={14}
		height={79}
		viewBox="0 0 14 79"
		fill="none"
		xmlns="http://www.w3.org/2000/svg"
		{...props}
	>
		<path
			d="M1 1V69.75"
			stroke="#EEF0F1"
			strokeWidth={2}
			strokeLinecap="round"
		/>
		<path
			d="M1 39.5V72C1 75.3137 3.68629 78 7 78H13"
			stroke="#EEF0F1"
			strokeWidth={2}
			strokeLinecap="round"
		/>
	</svg>
)
const Memo = memo(SvgComponent)
export default Memo
