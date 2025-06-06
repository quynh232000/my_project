'use client';

import * as React from 'react';
import { Slot } from '@radix-ui/react-slot';
import { useIsMobile } from '@/hooks/use-mobile';
import { cn } from '@/lib/utils';
import { Button } from '@/components/ui/button';
import {
	Sheet,
	SheetContent,
	SheetDescription,
	SheetHeader,
	SheetTitle,
} from '@/components/ui/sheet';
import {
	Tooltip,
	TooltipContent,
	TooltipProvider,
	TooltipTrigger,
} from '@/components/ui/tooltip';
import { IconChevron } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { Menu } from 'lucide-react';

const SIDEBAR_WIDTH = '16rem';
const SIDEBAR_WIDTH_MOBILE = '18rem';
const SIDEBAR_WIDTH_ICON = '3rem';

type SidebarContextProps = {
	state: 'expanded' | 'collapsed';
	open: boolean;
	setOpen: (open: boolean) => void;
	openMobile: boolean;
	setOpenMobile: (open: boolean) => void;
	isMobile: boolean;
	toggleSidebar: () => void;
};

const SidebarContext = React.createContext<SidebarContextProps | null>(null);

function useSidebar() {
	const context = React.useContext(SidebarContext);
	if (!context) {
		throw new Error('useSidebar must be used within a SidebarProvider.');
	}

	return context;
}

const SidebarProvider = React.forwardRef<
	HTMLDivElement,
	React.ComponentProps<'div'> & {
		defaultOpen?: boolean;
		open?: boolean;
		onOpenChange?: (open: boolean) => void;
	}
>(
	(
		{
			defaultOpen = true,
			open: openProp,
			onOpenChange: setOpenProp,
			className,
			style,
			children,
			...props
		},
		ref
	) => {
		const isMobile = useIsMobile();
		const [openMobile, setOpenMobile] = React.useState(false);

		const [_open, _setOpen] = React.useState(defaultOpen);
		const open = openProp ?? _open;
		const setOpen = React.useCallback(
			(value: boolean | ((value: boolean) => boolean)) => {
				const openState = typeof value === 'function' ? value(open) : value;
				if (setOpenProp) {
					setOpenProp(openState);
				} else {
					_setOpen(openState);
				}
			},
			[setOpenProp, open]
		);

		// Helper to toggle the sidebar.
		const toggleSidebar = React.useCallback(() => {
			return isMobile
				? setOpenMobile((open) => !open)
				: setOpen((open) => !open);
		}, [isMobile, setOpen, setOpenMobile]);

		const state = open ? 'expanded' : 'collapsed';

		const contextValue = React.useMemo<SidebarContextProps>(
			() => ({
				state,
				open,
				setOpen,
				isMobile,
				openMobile,
				setOpenMobile,
				toggleSidebar,
			}),
			[state, open, setOpen, isMobile, openMobile, setOpenMobile, toggleSidebar]
		);

		return (
			<SidebarContext.Provider value={contextValue}>
				<TooltipProvider delayDuration={0}>
					<div
						style={
							{
								'--sidebar-width': SIDEBAR_WIDTH,
								'--sidebar-width-icon': SIDEBAR_WIDTH_ICON,
								...style,
							} as React.CSSProperties
						}
						className={cn(
							'group/sidebar-wrapper flex min-h-svh w-full has-[[data-variant=inset]]:bg-sidebar',
							className
						)}
						ref={ref}
						{...props}>
						{children}
					</div>
				</TooltipProvider>
			</SidebarContext.Provider>
		);
	}
);
SidebarProvider.displayName = 'SidebarProvider';

const Sidebar = React.forwardRef<
	HTMLDivElement,
	React.ComponentProps<'div'> & {
		side?: 'left' | 'right';
		variant?: 'sidebar' | 'floating' | 'inset';
		collapsible?: 'offcanvas' | 'icon' | 'none';
	}
>(
	(
		{
			side = 'left',
			variant = 'sidebar',
			collapsible = 'offcanvas',
			className,
			children,
			...props
		},
		ref
	) => {
		const { isMobile, state, openMobile, setOpenMobile } = useSidebar();

		if (collapsible === 'none') {
			return (
				<div
					className={cn(
						'flex h-full w-[--sidebar-width] flex-col bg-sidebar',
						className
					)}
					ref={ref}
					{...props}>
					{children}
				</div>
			);
		}

		if (isMobile) {
			return (
				<Sheet open={openMobile} onOpenChange={setOpenMobile} {...props}>
					<SheetContent
						data-mobile="true"
						className="w-[--sidebar-width] bg-sidebar p-0 [&>button]:hidden"
						style={
							{
								'--sidebar-width': SIDEBAR_WIDTH_MOBILE,
							} as React.CSSProperties
						}
						side={side}>
						<SheetHeader className="sr-only">
							<SheetTitle>Sidebar</SheetTitle>
							<SheetDescription>Displays the mobile sidebar.</SheetDescription>
						</SheetHeader>
						<div className="flex h-full w-full flex-col">{children}</div>
					</SheetContent>
				</Sheet>
			);
		}

		return (
			<div
				ref={ref}
				className="group peer hidden md:block"
				data-state={state}
				data-collapsible={state === 'collapsed' ? collapsible : ''}
				data-variant={variant}
				data-side={side}>
				{/* This is what handles the sidebar gap on desktop */}
				<div
					className={cn(
						'relative w-[--sidebar-width] bg-transparent transition-[width] duration-200 ease-linear',
						variant === 'floating' || variant === 'inset'
							? 'group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)_+_theme(spacing.4))]'
							: 'group-data-[collapsible=icon]:w-[--sidebar-width-icon]'
					)}
				/>
				<div
					className={cn(
						'fixed z-10 hidden h-svh w-[--sidebar-width] transition-[left,right,width] duration-200 ease-linear md:flex',
						side === 'left'
							? 'left-0 group-data-[collapsible=offcanvas]:left-[calc(var(--sidebar-width)*-1)]'
							: 'right-0 group-data-[collapsible=offcanvas]:right-[calc(var(--sidebar-width)*-1)]',
						// Adjust the padding for floating and inset variants.
						variant === 'floating' || variant === 'inset'
							? 'p-2 group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)_+_theme(spacing.4)_+2px)]'
							: 'group-data-[collapsible=icon]:w-[--sidebar-width-icon] group-data-[side=left]:border-r group-data-[side=right]:border-l',
						className
					)}
					{...props}>
					<div
						className="flex h-full w-full flex-col bg-sidebar group-data-[variant=floating]:rounded-lg group-data-[variant=floating]:border group-data-[variant=floating]:border-sidebar-border group-data-[variant=floating]:shadow">
						{children}
					</div>
				</div>
			</div>
		);
	}
);
Sidebar.displayName = 'Sidebar';

interface SidebarTriggerProps extends React.ComponentProps<typeof Button> {
	icon?: React.ReactNode;
}

const SidebarTrigger = React.forwardRef<
	React.ComponentRef<typeof Button>,
	SidebarTriggerProps
>(({ icon, className, onClick, ...props }, ref) => {
	const { toggleSidebar, open } = useSidebar();
	return (
		<Button
			ref={ref}
			variant="ghost"
			size="icon"
			className={cn('h-7 w-7', className)}
			onClick={(event) => {
				onClick?.(event);
				toggleSidebar();
			}}
			{...props}>
			{icon ? (
				<Menu className="mt-[10px] block !h-6 !w-6 md:hidden" />
			) : (
				<div
					className={`flex flex-row transition-transform ${open ? 'rotate-y-180' : 'rotate-y-0'}`}>
					<IconChevron
						className={'!size-3'}
						direction={'right'}
						color={GlobalUI.colors.neutrals['1']}
					/>
					<IconChevron
						direction={'right'}
						className={'ml-[-5px] !size-3'}
						color={GlobalUI.colors.neutrals['1']}
					/>
				</div>
			)}

			<span className="sr-only">Toggle Sidebar</span>
		</Button>
	);
});
SidebarTrigger.displayName = 'SidebarTrigger';

const SidebarHeader = React.forwardRef<
	HTMLDivElement,
	React.ComponentProps<'div'>
>(({ className, ...props }, ref) => {
	return (
		<div
			ref={ref}
			className={cn('flex flex-col gap-2 p-2', className)}
			{...props}
		/>
	);
});
SidebarHeader.displayName = 'SidebarHeader';

const SidebarContent = React.forwardRef<
	HTMLDivElement,
	React.ComponentProps<'div'>
>(({ className, ...props }, ref) => {
	return (
		<ScrollArea>
			<div
				ref={ref}
				className={cn(
					'flex min-h-0 flex-1 flex-col gap-2 pb-10 group-data-[collapsible=icon]:overflow-hidden',
					className
				)}
				{...props}
			/>
			<ScrollBar />
		</ScrollArea>
	);
});
SidebarContent.displayName = 'SidebarContent';

const SidebarGroup = React.forwardRef<
	HTMLDivElement,
	React.ComponentProps<'div'>
>(({ className, ...props }, ref) => {
	return (
		<div
			ref={ref}
			className={cn('relative flex w-full min-w-0 flex-col p-2', className)}
			{...props}
		/>
	);
});
SidebarGroup.displayName = 'SidebarGroup';

const SidebarGroupContent = React.forwardRef<
	HTMLDivElement,
	React.ComponentProps<'div'>
>(({ className, ...props }, ref) => (
	<div
		ref={ref}
		className={cn('w-full text-sm', className)}
		{...props}
	/>
));
SidebarGroupContent.displayName = 'SidebarGroupContent';

const SidebarMenu = React.forwardRef<
	HTMLUListElement,
	React.ComponentProps<'ul'>
>(({ className, ...props }, ref) => (
	<ul
		ref={ref}
		className={cn('flex w-full min-w-0 flex-col gap-1', className)}
		{...props}
	/>
));
SidebarMenu.displayName = 'SidebarMenu';

const SidebarMenuItem = React.forwardRef<
	HTMLLIElement,
	React.ComponentProps<'li'>
>(({ className, ...props }, ref) => (
	<li
		ref={ref}
		className={cn('relative', className)}
		{...props}
	/>
));
SidebarMenuItem.displayName = 'SidebarMenuItem';

const SidebarMenuButton = React.forwardRef<
	HTMLButtonElement,
	React.ComponentProps<'button'> & {
		asChild?: boolean;
		isActive?: boolean;
		tooltip?: string | React.ComponentProps<typeof TooltipContent>;
	}
>(
	(
		{ asChild = false, isActive = false, tooltip, className, ...props },
		ref
	) => {
		const Comp = asChild ? Slot : 'button';
		const { isMobile, state } = useSidebar();

		const button = (
			<Comp
				ref={ref}
				data-active={isActive}
				className={cn(
					'flex w-full items-center gap-2 rounded-[10px] p-2 transition-[width,height,padding] hover:bg-secondary-00 data-[active=true]:bg-secondary-00 data-[active=true]:text-secondary-500 group-data-[collapsible=icon]:!size-8 group-data-[collapsible=icon]:!p-1 [&>span:last-child]:truncate [&>svg]:shrink-0',
					className
				)}
				{...props}
			/>
		);

		if (!tooltip) {
			return button;
		}

		if (typeof tooltip === 'string') {
			tooltip = {
				children: tooltip,
			};
		}

		return (
			<Tooltip>
				<TooltipTrigger asChild>{button}</TooltipTrigger>
				<TooltipContent
					side="right"
					align="center"
					hidden={state !== 'collapsed' || isMobile}
					{...tooltip}
				/>
			</Tooltip>
		);
	}
);
SidebarMenuButton.displayName = 'SidebarMenuButton';

export {
	Sidebar,
	SidebarContent,
	SidebarGroup,
	SidebarGroupContent,
	SidebarHeader,
	SidebarMenu,
	SidebarMenuButton,
	SidebarMenuItem,
	SidebarProvider,
	SidebarTrigger,
	useSidebar,
};
