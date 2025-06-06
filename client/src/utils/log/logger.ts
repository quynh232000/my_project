/**
 * Custom logger that only outputs in non-production environments
 */
export const logger = {
	log: (...args: Parameters<typeof console.log>) => {
		if (process.env.NEXT_PUBLIC_APP_ENV === 'development') {
			console.log(...args);
		}
	},
	error: (...args: Parameters<typeof console.error>) => {
		if (process.env.NEXT_PUBLIC_APP_ENV === 'development') {
			console.error(...args);
		}
	},
	warn: (...args: Parameters<typeof console.warn>) => {
		if (process.env.NEXT_PUBLIC_APP_ENV === 'development') {
			console.warn(...args);
		}
	},
};

type StyledConsoleLogOptions = {
	backgroundColor?: string;
	color?: string;
	fontSize?: string;
	padding?: string;
	borderRadius?: string;
};

/**
 * Logs a styled message to console
 * @param {string} message - Message to log
 * @param {StyledConsoleLogOptions} options - Styling options
 * @example
 * styledConsoleLog('Success!', {
 *   backgroundColor: '#4CAF50',
 *   color: '#ffffff',
 *   fontSize: '16px'
 * })
 *
 * styledConsoleLog('Error', {
 *   backgroundColor: '#f44336',
 *   padding: '4px 8px'
 * })
 */
export const styledConsoleLog = (
	message: string,
	{
		backgroundColor = 'transparent',
		color = '#ffffff',
		fontSize = '14px',
		padding = '2px 6px',
		borderRadius = '3px',
	}: StyledConsoleLogOptions
) => {
	const styles = [
		`background: ${backgroundColor}`,
		`color: ${color}`,
		`font-size: ${fontSize}`,
		`padding: ${padding}`,
		`border-radius: ${borderRadius}`,
		'font-weight: bold',
	].join(';');

	console.log(`%c${message}`, styles);
};
