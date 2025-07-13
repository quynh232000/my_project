import { z } from 'zod';

export const userGroupSchema = z.object({
	name: z.string().min(1, 'Tên nhóm người dùng không được để trống'),
	permissions: z.record(z.string(), z.array(z.string()).optional()),
});

export type UserGroupType = z.infer<typeof userGroupSchema>;
