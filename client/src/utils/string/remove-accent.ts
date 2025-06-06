export const removeAccent = (str: string): string => {
	return str
		.normalize('NFD')
		.replace(/[\u0300-\u036f]/g, '')
		.replace(/đ/g, 'd')
		.replace(/Đ/g, 'D');
};

export const normalizeText = (str: string): string => {
	return removeAccent(str).toLowerCase().trim();
};
