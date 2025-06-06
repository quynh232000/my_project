'use client';

import { IconChevron, IconEnvelope } from '@/assets/Icons/outline';
import IconChatText from '@/assets/Icons/outline/IconChatText';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/components/ui/popover';
import { AuthRouters, PropertySelectRouters } from '@/constants/routers';
import { cn } from '@/lib/utils';
import { getUser } from '@/services/auth/getUser';
import { useLoadingStore } from '@/store/loading/store';
import { useUserInformationStore } from '@/store/user-information/store';
import { GlobalUI } from '@/themes/type';
import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { useEffect, useState } from 'react';
import AppImage from '../Image/AppImage';
import Typography from '../Typography';

const data = [
	{
		title: 'Tài liệu hướng dẫn',
		href: '#',
	},
	{
		title: 'Tin tức',
		href: '#',
	},
	{
		title: 'Hỗ trợ',
		href: '#',
	},
];
const DashboardMenu = () => {
	const { userInformation, setUserInformationState } =
		useUserInformationStore();

	const [open, setOpen] = useState(false);
	const router = useRouter();
	const setLoading = useLoadingStore((state) => state.setLoading);

	useEffect(() => {
		setLoading(true);
		const fetchDataUser = async () => {
			if (userInformation.username === '') {
				const user = await getUser();
				if (user) {
					setUserInformationState(user);
				}
			}
		};
		fetchDataUser().finally(() => setLoading(false));
	}, [userInformation.username]);

	const handleLogout = async () => {
		try {
			setLoading(true);
			await fetch('/api/auth/logout', { method: 'POST' });
			setLoading(false);
			router.push(AuthRouters.signIn);
		} catch (error) {
			router.push(AuthRouters.signIn);
		}
	};

	return (
		<div
			className={cn(
				'sticky left-0 flex flex-col items-end gap-5 bg-white px-8 py-6 lg:flex-row lg:items-center lg:gap-9'
			)}>
			<div className={'flex-1'}>
				<ul className={'flex items-center gap-10'}>
					{data.map((item, index) => (
						<li key={index}>
							<Link
								className={cn(
									TextVariants.caption_14px_500,
									'text-neutral-600'
								)}
								href={item.href}>
								{item.title}
							</Link>
						</li>
					))}
				</ul>
			</div>
			<div className={'flex items-center gap-6'}>
				<div className={'flex items-center gap-4'}>
					<div className={'relative cursor-pointer'}>
						<IconEnvelope className={'size-6'} />
						<span
							className={
								'absolute right-0 top-0 inline-block size-2 rounded-full border-2 border-white bg-alert-error-base'
							}></span>
					</div>
					<div className={'relative cursor-pointer'}>
						<IconChatText className={'size-6'} />
						<span
							className={
								'absolute right-0 top-0 inline-block size-2 rounded-full border-2 border-white bg-alert-error-base'
							}></span>
					</div>
				</div>
				<Popover open={open} onOpenChange={setOpen}>
					<PopoverTrigger asChild>
						<button className={'flex cursor-pointer items-center gap-2'}>
							<AppImage
								alt={'avatar'}
								src={userInformation.image}
								width={32}
								height={32}
								errorSrc="/images/pages/dashboard/avatar.png"
								className={'h-8 w-8 rounded-full object-cover'}
							/>
							<div
								className={`transition-transform ${open ? 'rotate-180' : 'rotate-0'}`}>
								<IconChevron
									direction={'down'}
									width={14}
									height={14}
									color={GlobalUI.colors.neutrals['4']}
								/>
							</div>
						</button>
					</PopoverTrigger>
					<PopoverContent className="mr-2 flex w-40 min-w-[200px] flex-col gap-2 rounded-lg bg-white px-4 py-4 shadow-md">
						<div
							className={'cursor-pointer'}
							onClick={() => router.push(PropertySelectRouters.index)}>
							<Typography
								tag={'p'}
								variant={'caption_14px_500'}
								text={'Danh sách chỗ nghỉ'}
							/>
						</div>
						<div className={'cursor-pointer'} onClick={handleLogout}>
							<Typography
								tag={'p'}
								variant={'caption_14px_500'}
								text={'Đăng xuất'}
							/>
						</div>
					</PopoverContent>
				</Popover>
			</div>
		</div>
	);
};

export default DashboardMenu;
