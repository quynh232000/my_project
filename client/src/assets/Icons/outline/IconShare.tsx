import * as React from "react"
import { SVGProps, memo } from "react"
const IconShare = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 24 24"
		fill="none"
		{...props}
	>
		<circle
			cx={16}
			cy={5}
			r={2}
			stroke={props.color||"#777E90"}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<circle
			cx={16}
			cy={19}
			r={2}
			stroke={props.color||"#777E90"}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<circle
			cx={6}
			cy={12}
			r={2}
			stroke={props.color||"#777E90"}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M7.5 10.5L14 6"
			stroke={props.color||"#777E90"}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
		<path
			d="M7.5 13.5L14 18"
			stroke={props.color||"#777E90"}
			strokeWidth={1.7}
			strokeLinecap="round"
			strokeLinejoin="round"
		/>
	</svg>
)
const Memo = memo(IconShare);
export default Memo
