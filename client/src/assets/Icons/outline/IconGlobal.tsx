import * as React from "react"
import { SVGProps, memo } from "react"
const IconGlobal = (props: SVGProps<SVGSVGElement>) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="1em"
		height="1em"
		viewBox="0 0 24 24"
		fill="none"
		{...props}
	>
		<path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M12 20C16.4183 20 20 16.4183 20 12C20 7.58175 16.4183 4.00003 12 4.00003C7.58172 4.00003 4 7.58175 4 12C4 16.4183 7.58172 20 12 20ZM12 22C17.5228 22 22 17.5229 22 12C22 6.47718 17.5228 2.00003 12 2.00003C6.47715 2.00003 2 6.47718 2 12C2 17.5229 6.47715 22 12 22Z"
			fill={props.color||"#777E90"}
		/>
		<path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M13.7467 18.1767C14.4854 16.6993 15 14.5183 15 12C15 9.48177 14.4854 7.3008 13.7467 5.82339C12.9482 4.22636 12.2151 4.00003 12 4.00003C11.7849 4.00003 11.0518 4.22636 10.2533 5.82339C9.51462 7.3008 9 9.48177 9 12C9 14.5183 9.51462 16.6993 10.2533 18.1767C11.0518 19.7737 11.7849 20 12 20C12.2151 20 12.9482 19.7737 13.7467 18.1767ZM12 22C14.7614 22 17 17.5229 17 12C17 6.47718 14.7614 2.00003 12 2.00003C9.23858 2.00003 7 6.47718 7 12C7 17.5229 9.23858 22 12 22Z"
			fill={props.color||"#777E90"}
		/>
		<path
			fillRule="evenodd"
			clipRule="evenodd"
			d="M21.9506 13C21.9833 12.6711 22 12.3375 22 12C22 11.6625 21.9833 11.3289 21.9506 11H2.04938C2.01672 11.3289 2 11.6625 2 12C2 12.3375 2.01672 12.6711 2.04938 13H21.9506Z"
			fill={props.color||"#777E90"}
		/>
	</svg>
)
const Memo = memo(IconGlobal)
export default Memo
