import React from 'react';
import { IconSearchBar } from '@/assets/Icons/outline';
import { Input } from '@/components/ui/input';
import SelectPopup, { OptionType } from '@/components/shared/Select/SelectPopup';
import { GlobalUI } from '@/themes/type';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import Link from 'next/link';

interface PromotionTableToolbarProps {
	href: string;
	title: string;
	selectOptions: OptionType[];
	searchPlaceholder: string;
}


const TableToolbar = ({searchPlaceholder, selectOptions, title, href}: PromotionTableToolbarProps) => {
	return (
		<div className={'flex items-center justify-between'}>
			<div className={'flex items-center gap-4'}>
				<div
					className={
						'flex h-10 min-w-[360px] items-center gap-2 rounded-lg border-2 border-other-divider-02 p-2 pr-3'
					}>
					<IconSearchBar
						className={'size-6'}
						color={GlobalUI.colors.neutrals['4']}
					/>
					<Input
						name={'search'}
						placeholder={searchPlaceholder}
						className={cn(
							'reset-input h-6 flex-1 p-0',
							TextVariants.caption_14px_400
						)}
					/>
				</div>
				<SelectPopup
					className={'h-10 w-[160px] rounded-lg px-3 py-2'}
					placeholder={'Trạng thái'}
					searchInput={false}
					selectedValue={''}
					data={selectOptions}
				/>
			</div>
			<Link
				href={href}
				className={cn(
					'rounded-lg bg-secondary-500 px-4 py-2 text-white hover:bg-secondary-500/80',
					TextVariants.caption_14px_600
				)}>
				{title}
			</Link>
		</div>
	);
};

export default TableToolbar;