'use client';
import DashboardTable, { renderStatus } from '@/components/shared/DashboardTable';
import { DashboardRouter } from '@/constants/routers';
import { filterData } from '@/containers/setting-room/data';
import { TGroupUser, userGroupList } from '@/containers/user/data';
import { useRouter } from 'next/navigation';

const UserGroupTable = () => {
	const router = useRouter();
	return (
		<>
			<DashboardTable<TGroupUser & { id: number }>
				searchPlaceholder={'Tìm kiếm theo tên nhóm người dùng'}
				filterPlaceholder={'Trạng thái'}
				addButtonText={'Thêm người dùng mới'}
				fieldSearch={['id', 'name']}
				handleAdd={() => router.push(DashboardRouter.userGroupCreate)}
				filterData={filterData}
				columns={[
					{ label: 'Nhóm người dùng', field: 'name', sortable: true },
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
					// data ? (data as Array<Omit<TPriceType, 'id'> & { id: number }>) : []
					(userGroupList as Array<Omit<TGroupUser, 'id'> & { id: number }>) ??
					[]
				}
				action={{
					name: 'Thiết lập',
					type: 'edit',
					handle: [
						(row) => {
							console.log(row);
						},
					],
				}}
			/>
		</>
	);
};

export default UserGroupTable;
