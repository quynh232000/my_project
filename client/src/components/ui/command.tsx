'use client';

import { Command as CommandPrimitive } from 'cmdk';
import { Search } from 'lucide-react';
import * as React from 'react';
import { cn } from '@/lib/utils';
import { TextVariants } from '../shared/Typography/TextVariants';

const Command = React.forwardRef<
	React.ComponentRef<typeof CommandPrimitive>,
	React.ComponentPropsWithoutRef<typeof CommandPrimitive>
>(({ className, ...props }, ref) => (
	<CommandPrimitive ref={ref} className={className} {...props} />
));
Command.displayName = CommandPrimitive.displayName;

const CommandInput = React.forwardRef<
	React.ComponentRef<typeof CommandPrimitive.Input>,
	React.ComponentPropsWithoutRef<typeof CommandPrimitive.Input>
>(({ className, ...props }, ref) => (
	<div className="mx-3 mt-3 flex h-9 items-center rounded-lg bg-neutral-50 px-3">
		<Search className="mr-2 h-4 w-4 shrink-0 opacity-50" />
		<CommandPrimitive.Input
			ref={ref}
			className={cn(
				`w-full flex-1 !cursor-auto bg-transparent outline-none ${TextVariants.caption_14px_400}`,
				className
			)}
			{...props}
		/>
	</div>
));

CommandInput.displayName = CommandPrimitive.Input.displayName;

const CommandList = React.forwardRef<
	React.ComponentRef<typeof CommandPrimitive.List>,
	React.ComponentPropsWithoutRef<typeof CommandPrimitive.List>
>(({ className, ...props }, ref) => (
	<CommandPrimitive.List
		ref={ref}
		className={cn('mt-2 overflow-y-auto overflow-x-hidden', className)}
		{...props}
	/>
));

CommandList.displayName = CommandPrimitive.List.displayName;

const CommandEmpty = React.forwardRef<
	React.ComponentRef<typeof CommandPrimitive.Empty>,
	React.ComponentPropsWithoutRef<typeof CommandPrimitive.Empty>
>((props, ref) => (
	<CommandPrimitive.Empty
		ref={ref}
		className={`${TextVariants.caption_14px_500} mx-3 py-3 text-center`}
		{...props}
	/>
));

CommandEmpty.displayName = CommandPrimitive.Empty.displayName;

const CommandGroup = React.forwardRef<
	React.ComponentRef<typeof CommandPrimitive.Group>,
	React.ComponentPropsWithoutRef<typeof CommandPrimitive.Group>
>(({ className, ...props }, ref) => (
	<CommandPrimitive.Group
		ref={ref}
		className={cn(`${TextVariants.caption_14px_400} mx-3 mb-3`, className)}
		{...props}
	/>
));

CommandGroup.displayName = CommandPrimitive.Group.displayName;

interface CommandItemProps
	extends React.ComponentPropsWithoutRef<typeof CommandPrimitive.Item> {
	title?: string;
}
const CommandItem = React.forwardRef<
	React.ComponentRef<typeof CommandPrimitive.Item>,
	CommandItemProps
>(({ className, ...props }, ref) => (
	<CommandPrimitive.Item
		ref={ref}
		title={props.title}
		className={cn(
			'mb-0.5 cursor-pointer rounded-md px-3 py-1 data-[selected="true"]:!bg-neutral-100',
			className
		)}
		{...props}
	/>
));

CommandItem.displayName = CommandPrimitive.Item.displayName;

export {
	Command,
	CommandEmpty,
	CommandGroup,
	CommandInput,
	CommandItem,
	CommandList,
};
