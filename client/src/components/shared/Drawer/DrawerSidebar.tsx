import React from 'react';
import { Drawer } from '@material-tailwind/react';
import {
	AlignJustify,
	Backpack,
	Badge,
	Banknote,
	Book,
	Heart,
	HeartHandshake,
	Hotel,
	MailOpen,
	MemoryStick,
	Plane,
	Share2,
	Smartphone,
	UserPlus,
	X,
} from 'lucide-react';
import Link from 'next/link';
function DrawerSidebar() {
	const dataMenu = [
		{
			id: 1,
			icon: <MailOpen className="text-[10px] text-blue-500" />,
			name: 'Trang chủ',
			url: '#',
			break: false,
		},
		{
			id: 2,
			icon: <Heart className="text-[10px] text-blue-500" />,
			name: 'Yêu thích',
			url: '#',
			break: true,
		},
		{
			id: 3,
			icon: <Hotel className="text-[10px] text-yellow-500" />,
			name: 'Khách sạn',
			url: '#',
			break: false,
		},
		{
			id: 4,
			icon: <Plane className="text-[10px] text-primary-500" />,
			name: 'Vé máy bay',
			url: '#',
			break: false,
		},
		{
			id: 5,
			icon: <MemoryStick className="text-[10px] text-primary-500" />,
			name: 'The Memories',
			url: '#',
			break: false,
		},
		{
			id: 6,
			icon: <Badge className="text-[10px] text-blue-500" />,
			name: 'Tour & Sư kiện',
			url: '#',
			break: false,
		},
		{
			id: 7,
			icon: <Book className="text-[10px] text-green-500" />,
			name: 'Cẩm nang du lịch',
			url: '#',
			break: true,
		},
		{
			id: 8,
			icon: <Backpack className="text-[10px] text-blue-500" />,
			name: 'Tuyển dụng',
			url: '#',
			break: false,
		},
		{
			id: 9,
			icon: <Banknote className="text-[10px] text-blue-500" />,
			name: 'Hỗ trợ',
			url: '#',
			break: false,
		},
		{
			id: 10,
			icon: <HeartHandshake className="text-[10px] text-blue-500" />,
			name: 'Trở thành đối tác liên kết',
			url: '#',
			break: true,
		},
		{
			id: 11,
			icon: <UserPlus className="text-[10px] text-blue-500" />,
			name: 'Hợp tác với chúng tôi',
			url: '#',
			break: false,
		},
		{
			id: 12,
			icon: <Smartphone className="text-[10px] text-blue-500" />,
			name: 'Tải ứng dụng Quin',
			url: '#',
			break: false,
		},
		{
			id: 13,
			icon: <Share2 className="text-[10px] text-blue-500" />,
			name: 'Giới thiệu nhận quà',
			url: '#',
			break: false,
		},
	];
	const [openRight, setOpenRight] = React.useState(false);

	const openDrawerRight = () => setOpenRight(true);
	const closeDrawerRight = () => setOpenRight(false);
	return (
		<div>
			<div
				onClick={openDrawerRight}
				className="cursor-pointer text-gray-500">
				<AlignJustify className="text-gray-600" />
			</div>

			<div className=''>
                <Drawer
				placement="right"
				open={openRight}
                
				onClose={closeDrawerRight}
				{...({} as any)}
                
				className="flex h-[100vh] flex-col p-4  z-[10]">
				<div className="mb-6 flex items-center justify-between z-10">
					<div>
						<X
							className="cursor-pointer text-gray-600 hover:text-gray-700"
							onClick={closeDrawerRight }
						/>
					</div>
				</div>
				<div className="scrollbar_custom scrollbar_custom_hidden flex flex-1 flex-col gap-2 overflow-y-scroll">
					{dataMenu.map((item) => {
						return (
							<div key={item.id}>
								<Link
									
									href={item.url}
									className="flex items-center gap-4 rounded-lg p-2 px-3 transition-colors hover:bg-primary-50">
									<div>{item.icon}</div>
									<div>{item.name}</div>
								</Link>
								{item.break && <hr />}
							</div>
						);
					})}
				</div>
			</Drawer>
            </div>
		</div>
	);
}

export default DrawerSidebar;
