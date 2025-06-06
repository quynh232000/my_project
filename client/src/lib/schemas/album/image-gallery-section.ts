import {  z as validate } from 'zod';
import { ALLOW_FILE_SIZE, ALLOW_FILE_TYPE } from '@/constants/common';

export const imageGallerySectionSchema = () => {
	return validate.object({
		filesUpload: validate
			.array(validate.custom<File>())
			.superRefine(async (files, ctx) => {
				for (const [index, file] of files.entries()) {
					const errors = await checkErrorImage(file);

					if (errors.length > 0) {
						ctx.addIssue({
							code: 'custom',
							message: `Vui lòng tải ảnh lên ${errors.join(', ')}`,
							path: [index], // Chỉ định file lỗi theo index
						});
					}
				}
			}),
		imagesUpload: validate.array(
			validate.object({
				url: validate.string(),
				tag: validate.string().min(1, "Bạn phải chọn 1 tag miêu tả ảnh"),
				file: validate.custom<File | string>(),
				priority: validate.number(),
			})
		),

		images: validate.array(
			validate.object({
				id: validate.union([validate.string(), validate.number()]),
				url: validate.string(),
				tag: validate.string(),
				file: validate.custom<File | string>(),
				image_id: validate.number().nullable(),
				priority: validate.number().default(0),
			})
		).optional(),
		imageEdit: validate.custom<File | string>().superRefine(async (file, ctx) => {
			const errors = await checkErrorImage(file);
			if (errors.length > 0) {
				ctx.addIssue({
					code: 'custom',
					message: `Vui lòng tải ảnh lên ${errors.join(', ')}`,
				});
			}
		}),
	})
};

const checkErrorImage = async (file: string | File) => {
	const errors: string[] = [];
	if (file instanceof File) {
		if (
			!ALLOW_FILE_TYPE.map(
				(type) => `image/${type.toLowerCase()}`
			).includes(file.type)
		) {
			errors.push(`định dạng JPG/JPEG`);
		}
		if (file.size > ALLOW_FILE_SIZE) {
			errors.push(`dưới 2MB`);
		}
		const isValidDimensions = await checkImageDimensions(file);
		if (!isValidDimensions) {
			errors.push('tối thiểu 798x532px (tỉ lệ 3:2)');
		}
	}
	return errors;
}
export const checkImageDimensions = (file: File): Promise<boolean> => {
	return new Promise((resolve) => {
		const reader = new FileReader();
		reader.onload = (e) => {
			const img = new Image();
			img.onload = () => {
				resolve(img.width >= 798 && img.height >= 532); // Đảm bảo kích thước tối thiểu
			};
			img.src = e.target?.result as string;
		};
		reader.readAsDataURL(file);
	});
};
export type ImageGallerySectionType = validate.infer<
	ReturnType<typeof imageGallerySectionSchema>
>;
