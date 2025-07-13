import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { Label } from '@/components/ui/label';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import * as React from 'react';
import { useState } from 'react';
import IconChevron from '@/assets/Icons/outline/IconChevron';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { OptionType } from '@/components/shared/Select/SelectPopup';

interface Props extends ClassNameProp {
	data?: OptionType[];
	renderItem: (item: OptionType, index: number) => React.ReactNode;
	label?: string;
	triggerClassName?: string;
	triggerLabel?: string;
	required?: boolean;
}

const SelectPopover = ({
	containerClassName,
	className,
	data,
	triggerLabel,
	label,
	renderItem,
	triggerClassName,
	required,
}: Props) => {
	const [open, setOpen] = useState(false);
	return (
		<Popover onOpenChange={setOpen} open={open}>
			<PopoverTrigger
				className={cn('w-full text-start', triggerClassName)}>
				<Label required={required}>{label}</Label>
				<div
					className={cn(
						TextVariants.caption_14px_400,
						'flex min-h-6 w-full items-center justify-between rounded-lg border-2 border-other-divider p-3',
						className
					)}>
					{triggerLabel ?? <div className={'size-6'} />}
					<IconChevron
						direction={open ? 'up' : 'down'}
						width={12}
						height={12}
						className={'ml-auto inline-block'}
					/>
				</div>
			</PopoverTrigger>
			<PopoverContent
				onClick={() => {
					setOpen(false);
				}}
				align={'center'}
				className={cn(
					'rounded-lg !border border-other-divider shadow-2xl',
					containerClassName
				)}>
				<ScrollArea className={'h-60 min-w-64'}>
					<div className={'flex flex-col p-3'}>
						{data?.map((item, index: number) =>
							renderItem(item, index)
						)}
					</div>
					<ScrollBar className={'hidden'} />
				</ScrollArea>
			</PopoverContent>
		</Popover>
	);
};

export default SelectPopover;
