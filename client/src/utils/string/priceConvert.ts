/**
 * Converts numeric values to Vietnamese currency format
 * @param {number | string} value - Number or numeric string to convert to currency
 * @returns {string} Formatted price string in VND with Vietnamese formatting
 * @example
 * // Number input
 * priceConvert(1000000)
 * // Returns: "1.000.000 đ"
 *
 * // String input
 * priceConvert("500000")
 * // Returns: "500.000 đ"
 *
 * // Invalid input
 * priceConvert("invalid")
 * // Returns: "0 đ"
 * // Logs error: "Invalid input for price conversion: invalid"
 *
 * // Decimal input
 * priceConvert(1500.50)
 * // Returns: "1.500,5 đ"
 */
export const priceConvert = (value: number | string): string => {
	const numValue = Math.abs(
		typeof value === 'string' ? parseFloat(value) : value
	);

	if (isNaN(numValue)) {
		return '0 đ';
	}
	return numValue
		.toLocaleString('vi-VN', {
			style: 'currency',
			currency: 'VND',
		})
		.replace(/[.\s]|₫/g, (match) =>
			match === '.' ? ',' : match === '₫' ? 'đ' : ''
		);
};
