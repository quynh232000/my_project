'use client';
import React from 'react';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import UserGroupFormInfo from '@/containers/user/user-group/user-group-detail/UserGroupFormInfo';
import UserGroupPermissions from '@/containers/user/user-group/user-group-detail/UserGroupPermissions';
import { Form } from '@/components/ui/form';
import { useForm } from 'react-hook-form';
import { userGroupSchema, UserGroupType } from '@/lib/schemas/user/userGroup';
import { zodResolver } from '@hookform/resolvers/zod';

const UserGroupForm = () => {
	const form = useForm<UserGroupType>({
		mode: 'onChange',
		resolver: zodResolver(userGroupSchema),
		defaultValues: {
			name: "",
			permissions: {}
		}
	});
	
	const onSubmit = (values: UserGroupType) => {
		console.log(values);
	}
	return (
		<Form {...form}>
			<form onSubmit={form.handleSubmit(onSubmit)}>
				<DashboardCard className={'mb-3'}>
					<UserGroupFormInfo />
				</DashboardCard>
				<DashboardCard>
					<UserGroupPermissions />
				</DashboardCard>
			</form>
		</Form>
	);
};

export default UserGroupForm;
