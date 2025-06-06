'use client';
import {
	Sidebar,
	SidebarContent,
	SidebarGroup,
	SidebarGroupContent,
	SidebarHeader,
	SidebarMenu,
	SidebarMenuButton,
	SidebarMenuItem,
	SidebarTrigger,
	useSidebar,
} from '@/components/ui/sidebar';
import Link from 'next/link';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { SidebarConfig } from '@/global.config';
import {
	Collapsible,
	CollapsibleContent,
	CollapsibleTrigger,
} from '@/components/ui/collapsible';
import { ChevronDown } from 'lucide-react';
import AppLogo from '@/assets/Logo/AppLogo';
import IconGrid from '@/assets/Icons/outline/IconGrid';
import Typography from '@/components/shared/Typography';
import { usePathname, useRouter } from 'next/navigation';
import { IconFolderTree } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import { useState } from 'react';

export default function AppSidebar() {
	const pathname = usePathname();
	const router = useRouter();
	const { open, setOpen } = useSidebar();

	const [collapsibleOpenIndex, setCollapsibleOpenIndex] = useState(() => {
		let initialIndex = -1;
		SidebarConfig.menu.forEach((menu) => {
			menu.items.forEach((item, index) => {
				if (item.menu && pathname.includes(`/${menu.url}/${item.url}`)) {
					initialIndex = index;
				}
			});
		});
		return initialIndex;
	});

	return (
		<Sidebar collapsible={'icon'} className={`pt-6`}>
			<SidebarHeader
				className={`flex items-center p-0 pt-[16px] transition-[padding] lg:pt-0 ${open ? 'flex-row justify-between px-8' : 'flex-col-reverse justify-center px-2'}`}>
				<AppLogo hideBrand={!open} />
				<SidebarTrigger />
			</SidebarHeader>
			<SidebarContent className={'text-neutral-600'}>
				{SidebarConfig.menu.map((menu) => (
					<SidebarGroup key={menu.label} className={'p-0'}>
						<SidebarGroupContent
							className={`${open ? 'px-8' : 'px-2'} transition-all`}>
							<Link
								prefetch={false}
								href={`/${menu.url}`}
								className={cn(
									`my-6 flex flex-row items-center justify-between rounded-[10px] bg-secondary-500 text-white shadow-[0px_10px_30px_0px_rgba(42,133,255,0.20)] transition-[padding] duration-300 ${open ? 'px-5 py-4' : 'p-1'}`,
									TextVariants.content_16px_600
								)}>
								<span
									className={`transition-all ${open ? 'w-auto opacity-100' : 'w-0 opacity-0'}`}>
									{menu.label}
								</span>
								<IconGrid />
							</Link>
							<SidebarMenu className={`${open ? 'gap-0' : 'gap-2'}`}>
								{menu.items.map((item, index) => {
									const isActive = pathname.includes(
										`/${menu.url}/${item.url}`
									);
									return item.menu ? (
										<Collapsible
											className={'group/collapsible'}
											key={item.url}
											defaultOpen={isActive}
											open={open && index === collapsibleOpenIndex}
											onOpenChange={(collapsibleOpen) => {
												setCollapsibleOpenIndex(collapsibleOpen ? index : -1);
											}}
											onClick={() => {
												if (!open) {
													setOpen(true);
													router.push(`/${menu.url}/${item.menu[0].url}`);
												}
											}}>
											<SidebarGroup className={'p-0'}>
												<SidebarMenuButton
													tooltip={item.title}
													asChild
													isActive={isActive}>
													<CollapsibleTrigger
														className={'flex h-auto gap-[10px] py-4'}>
														<item.icon
															className={'h-5 w-5'}
															{...(open && {
																color: isActive
																	? GlobalUI.colors.secondary['500']
																	: GlobalUI.colors.neutrals['300'],
															})}
														/>
														<Typography
															variant={'caption_14px_600'}
															className={'truncate'}>
															{item.title}
														</Typography>
														<ChevronDown className="ml-auto transition-transform group-data-[state=open]/collapsible:rotate-180" />
													</CollapsibleTrigger>
												</SidebarMenuButton>
												{open && (
													<CollapsibleContent
														className={
															'overflow-hidden data-[state=closed]:animate-sidebar-slide-up data-[state=open]:animate-sidebar-slide-down'
														}>
														<SidebarMenu
															className={
																'flex flex-col gap-0.5 overflow-hidden'
															}>
															{item.menu.map((subItem) => {
																const isSubmenuActive = item.shouldMatchPrefix
																	? pathname === `/${menu.url}/${subItem.url}`
																	: pathname.includes(
																			`/${menu.url}/${subItem.url}`
																		);
																return (
																	<SidebarMenuItem
																		key={subItem.url}
																		className={'pl-6'}>
																		<IconFolderTree
																			className={'absolute bottom-[50%] left-3'}
																		/>
																		<SidebarMenuButton
																			asChild
																			tooltip={subItem.title}
																			className={`${isSubmenuActive ? '!bg-secondary-00 pl-4 shadow-[inset_0_-2px_1px_0_rgba(0,0,0,0.05),_inset_0_1px_1px_0_#fff]' : 'pl-2'} !py-3`}
																			isActive={isSubmenuActive}>
																			<Link
																				prefetch={false}
																				href={`/${menu.url}/${subItem.url}`}
																				className={'h-auto py-4'}>
																				<span
																					className={
																						TextVariants.caption_14px_500
																					}>
																					{subItem.title}
																				</span>
																			</Link>
																		</SidebarMenuButton>
																	</SidebarMenuItem>
																);
															})}
														</SidebarMenu>
													</CollapsibleContent>
												)}
											</SidebarGroup>
										</Collapsible>
									) : (
										<SidebarMenuItem key={item.url}>
											<SidebarMenuButton
												asChild
												isActive={isActive}
												tooltip={item.title}>
												<Link
													prefetch={false}
													href={`/${menu.url}/${item.url}`}
													className={`h-auto py-4 ${isActive && '!bg-secondary-00'}`}>
													<item.icon
														className={'h-5 w-5'}
														{...(open && {
															color: isActive
																? GlobalUI.colors.secondary['500']
																: GlobalUI.colors.neutrals['300'],
														})}
													/>
													<span className={TextVariants.caption_14px_600}>
														{item.title}
													</span>
												</Link>
											</SidebarMenuButton>
										</SidebarMenuItem>
									);
								})}
							</SidebarMenu>
						</SidebarGroupContent>
					</SidebarGroup>
				))}
			</SidebarContent>
		</Sidebar>
	);
}
