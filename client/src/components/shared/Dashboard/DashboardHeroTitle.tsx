import { cn } from '@/lib/utils';
import Typography from '@/components/shared/Typography';
import { BreadcrumbURL } from '@/components/shared/BreadcrumbURL';
import React from 'react';

interface IProps {
	title: string;
	pathName: string;
	extraContent?: React.ReactNode;
	extraTitle?: React.ReactNode;
	actionBack?: React.ReactNode;
	displayName?: Record<string, string>;
}

export const DashboardHeroTitle = ({ title, pathName, className, containerClassName, extraContent, extraTitle, actionBack, displayName }: IProps & ClassNameProp) => {

	const path = pathName?.split('/')?.slice?.(1) ?? [];

	return (
		<div className={cn('py-6', containerClassName)}>
			<BreadcrumbURL pathName={path} displayName={displayName}/>
			<div className={'mt-3 flex items-center justify-between gap-5 flex-wrap lg:flex-nowrap'}>
				<div className={"flex items-center gap-2 "}>
					{actionBack}
					<Typography
						tag={'h1'}
						variant={'headline_24px_700'}
						className={cn('text-neutral-700', className)}>
						{title}
					</Typography>
				</div>
				{extraTitle}
			</div>
			{extraContent}
		</div>
	);
};
