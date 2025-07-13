import {
	Tooltip,
	TooltipArrow,
	TooltipContent,
	TooltipTrigger,
} from '@/components/ui/tooltip';
import Typography from '@/components/shared/Typography';
import React from 'react';
import { PopperContentProps } from '@radix-ui/react-popper';

interface AppTooltipProps {
	icon: React.ReactNode;
	content: string;
	contentProps?: PopperContentProps;
	arrow?: boolean;
}

export const AppTooltip: React.FC<AppTooltipProps> = ({
	icon,
	content,
	contentProps,
	arrow,
}) => {
	return (
		<Tooltip>
			<TooltipTrigger asChild>{icon}</TooltipTrigger>
			<TooltipContent side="right" align="center" {...contentProps}>
				<Typography tag="p" variant={'caption_12px_400'}>
					{content}
				</Typography>
				{arrow && <TooltipArrow />}
			</TooltipContent>
		</Tooltip>
	);
};
