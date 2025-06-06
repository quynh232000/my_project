'use client';

import * as React from 'react';
import * as LabelPrimitive from '@radix-ui/react-label';
import { cva, type VariantProps } from 'class-variance-authority';
import { cn } from '@/lib/utils';

const labelVariants = cva(
	'text-base font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70 leading-6 text-neutral-500'
);

interface LabelProps extends VariantProps<typeof labelVariants> {
	required?: boolean;
}

const Label = React.forwardRef<
	React.ComponentRef<typeof LabelPrimitive.Root>,
	React.ComponentPropsWithoutRef<typeof LabelPrimitive.Root> &
		LabelProps &
		ClassNameProp
>(({ className, containerClassName, required, ...props }, ref) => (
	<div className={cn('mb-2 flex items-center gap-1', containerClassName)}>
		<LabelPrimitive.Root
			ref={ref}
			className={cn(labelVariants(), className)}
			{...props}
		/>
		{required && (
			<span
				className={cn('leading-6 !text-red-500', className)}
				aria-hidden="true">
				{' *'}
			</span>
		)}
	</div>
));
Label.displayName = LabelPrimitive.Root.displayName;

export { Label };
