import React from 'react';
import { Input } from '@/components/ui/input';
import { UserGroupType } from '@/lib/schemas/user/userGroup';
import { useFormContext } from 'react-hook-form';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel, FormMessage,
} from '@/components/ui/form';

const UserGroupFormInfo = () => {
	const { control } = useFormContext<UserGroupType>();
	return (
		<FormField
			control={control}
			name={'name'}
			render={({ field }) => (
				<FormItem>
					<FormLabel required>Tên nhóm người dùng</FormLabel>
					<FormControl>
						<Input placeholder={'Lễ Tân'} {...field} className={'h-10 py-2'} />
					</FormControl>
					<FormMessage/>
				</FormItem>
			)}
		/>
	);
};

export default UserGroupFormInfo;
