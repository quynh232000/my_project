import * as React from 'react';
import { SVGProps, memo } from 'react';
const IconEmojiHeartEyes = (props: SVGProps<SVGSVGElement>) => (
	<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 40 40" fill="none" {...props}>
		<path
			d="M6.90834 22.3578L22.5021 0.766447C23.5336 -0.661728 25.7868 0.27853 25.4972 2.01626L23.3332 15.0003H31.7403C33.0999 15.0003 33.8875 16.5406 33.0914 17.6428L17.4977 39.2341C16.4662 40.6623 14.2129 39.722 14.5025 37.9843L16.6665 25.0003H8.25947C6.89986 25.0003 6.1123 23.46 6.90834 22.3578Z"
			fill={props.color || 'white'}
		/>
	</svg>
);
const Memo = memo(IconEmojiHeartEyes);
export default Memo;
