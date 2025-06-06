import React from 'react';

import {
	Breadcrumb,
	BreadcrumbItem,
	BreadcrumbLink,
	BreadcrumbList,
	BreadcrumbSeparator,
} from '@/components/ui/breadcrumb';
import Typography from '@/components/shared/Typography';

const Dictionary: { [key: string]: string } = {
	dashboard: '',
	profile: 'Hồ sơ chỗ nghỉ',
	room: 'Quản lý phòng',
	policy: 'Chính sách',
	general: 'Chính sách chung',
	children: 'Chính sách cho trẻ em',
	cancel: 'Chính sách hoàn huỷ',
	establish: 'Thiết lập',
	'add-new-policy': 'Thêm mới chính sách',
	other: 'Chính sách khác',
	'extra-bed': 'Nôi/cũi và giường phụ',
	'deposit-policy': 'Chính sách đặt cọc',
	'minimum-check-in-age': 'Độ tuổi tối thiểu nhận phòng',
	'serves-breakfast': 'Phục vụ bữa sáng',
	price: 'Quản lý giá',
	type: 'Loại giá',
	availability: 'Giá và phòng trống',
	promotion: 'Khuyến mãi',
	user: 'Danh sách người dùng',
	'user-group': 'Nhóm người dùng',
	create: 'Thêm mới',
	'booking-orders': 'Đơn đặt phòng',
	album: "Thư viện ảnh"
};

export function BreadcrumbURL({
	pathName,
	displayName,
}: {
	pathName: string[];
	displayName?: Record<string, string>;
}) {
	const isLast = (text: string) => {
		return pathName[pathName.length - 1] === text;
	};

	const translate = (text: string) => {
		return Dictionary[text] || text;
	};
	return (
		<Breadcrumb>
			<BreadcrumbList>
				{pathName.map((text, i) => {
					const title = translate(text);
					return (
						<React.Fragment key={i}>
							<BreadcrumbItem>
								<BreadcrumbLink
									href={`/${pathName.slice(0, i + 1).join('/')}`}
									prefetch={false}
									className={
										isLast(text) ? 'text-secondary-500' : 'text-neutral-400'
									}>
									<Typography tag="p" variant={'caption_12px_600'}>
										{displayName?.[text] ??
											title.slice(0, 1).toUpperCase() + title.slice(1)}
									</Typography>
								</BreadcrumbLink>
							</BreadcrumbItem>
							{pathName.length - 1 !== i && (
								<BreadcrumbSeparator>
									<Typography
										variant={'caption_12px_600'}
										className={'text-neutral-400'}>
										/
									</Typography>
								</BreadcrumbSeparator>
							)}
						</React.Fragment>
					);
				})}
			</BreadcrumbList>
		</Breadcrumb>
	);
}
