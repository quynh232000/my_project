'use client';
import DashboardTable, {
	renderStatus,
} from '@/components/shared/DashboardTable';
import { filterData } from '@/containers/setting-room/data';
import { TUser } from '@/containers/user/data';
import UserFormDialog from '@/containers/user/UserFormDialog';
import { useCustomerStore } from '@/store/customer/store';
import { useLoadingStore } from '@/store/loading/store';
import { getClientSideCookie } from '@/utils/cookie';
import { useEffect, useState } from 'react';

const UserTable = () => {
	const [userIdEdit, setUserIdEdit] = useState<number>(NaN);
	const [openDialog, setOpenDialog] = useState<boolean>(false);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { fetchCustomerList, customerList } = useCustomerStore();
	const [userList, setUserList] = useState<TUser[]>([]);
	const hotel_id = getClientSideCookie('hotel_id');

	useEffect(() => {
		setLoading(true);
		fetchCustomerList().finally(() => setLoading(false));
	}, []);

	useEffect(() => {
		if (customerList.length > 0) {
			setUserList(
				customerList.map((customer) => ({
					full_name: customer.full_name,
					email: customer.email,
					role: customer.hotel_customers.find(
						(role) => role.hotel_id === +(hotel_id as string)
					)?.role as string,
					status: customer.status,
					id: customer.id,
					add_by: customer.added_by
						? customer.added_by.full_name
						: customer.created_by.full_name,
				}))
			);
		}
	}, [customerList]);

	return (
		<>
			<DashboardTable<TUser & { id: number }>
				searchPlaceholder={'Tìm kiếm theo tên người dùng'}
				filterPlaceholder={'Trạng thái'}
				addButtonText={'Thêm người dùng mới'}
				fieldSearch={['id', 'full_name']}
				handleAdd={() => setOpenDialog(true)}
				filterData={filterData}
				columns={[
					{
						label: 'Tên người dùng',
						field: 'full_name',
						sortable: true,
					},
					{ label: 'Vai trò', field: 'role', sortable: true },
					{ label: 'Email', field: 'email', sortable: true },
					{
						label: 'Được thêm bởi',
						field: 'add_by',
						sortable: true,
					},
					{
						label: 'Trạng thái',
						field: 'status',
						renderCell: renderStatus,
						sortable: true,
					},
				]}
				rows={
					(userList as Array<Omit<TUser, 'id'> & { id: number }>) ??
					[]
				}
				action={{
					name: 'Thiết lập',
					type: 'edit',
					handle: [
						(row) => {
							setUserIdEdit(row.id);
							setOpenDialog(true);
						},
					],
				}}
			/>
			<UserFormDialog
				onClose={() => {
					setUserIdEdit(NaN);
					setOpenDialog(false);
				}}
				userIdEdit={userIdEdit}
				openDialog={openDialog}
				handleOpenDialog={() => setOpenDialog(!openDialog)}
			/>
		</>
	);
};

export default UserTable;
