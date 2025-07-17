import { IProperty } from '@/services/property/getPropertyList';

import DashboardTable, {
	renderStatus,
} from '@/components/shared/DashboardTable';
import { DashboardRouter } from '@/constants/routers';
import { filterData } from '../setting-room/data';

interface IPropertyTableProps {
	propertyList: IProperty[];
	onSelectProperty: (property: IProperty) => void;
}

export const PropertyTable = ({
	propertyList,
	onSelectProperty,
}: IPropertyTableProps) => {
	return (
		<DashboardTable<IProperty>
			searchPlaceholder={'Tìm kiếm theo tên/ID chỗ nghỉ'}
			filterPlaceholder={'Trạng thái'}
			filterData={filterData}
			fieldSearch={['id', 'name']}
			columns={[
				{
					label: 'ID chỗ nghỉ',
					field: 'id',
					sortable: true,
					style: { width: '127px' },
				},
				{ label: 'Tên chỗ nghỉ', field: 'name', sortable: true },

				{ label: 'Địa chỉ', field: 'address', sortable: true },
				{
					label: 'Trạng thái',
					field: 'status',
					renderCell: renderStatus,
					sortable: true,
				},
			]}
			rows={propertyList ?? []}
			action={{
				name: 'Thiết lập',
				type: 'navigate',
				url: `${DashboardRouter.profile}`,
				handle: [onSelectProperty],
			}}
			searchInputClassName={'w-[800px]'}
		/>
	);
};
