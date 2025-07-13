export const getImageDimensions = (
	file: File
): Promise<{ width: number; height: number }> => {
	return new Promise((resolve, reject) => {
		if (!file.type.startsWith('image/')) {
			reject(new Error('File is not an image'));
			return;
		}
		const url = URL.createObjectURL(file);
		const img = new Image();
		img.onload = () => {
			resolve({
				width: img.naturalWidth,
				height: img.naturalHeight,
			});
			URL.revokeObjectURL(url);
		};
		img.onerror = () => {
			reject(new Error('Failed to load image'));
			URL.revokeObjectURL(url);
		};
		img.src = url;
	});
};
