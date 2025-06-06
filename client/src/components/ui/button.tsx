import * as React from 'react';
import { Slot } from '@radix-ui/react-slot';
import { cva, type VariantProps } from 'class-variance-authority';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';

const buttonVariants = cva(
	`inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md ${TextVariants.caption_14px_600} disabled:!bg-neutral-200`,
	{
		variants: {
			variant: {
				default: `bg-neutral-900 text-neutral-50 hover:bg-neutral-200/90`,
				destructive: 'bg-accent-03 text-neutral-50 hover:bg-red-500/90',
				outline:
					'border-2 border-neutral-100 bg-white hover:bg-neutral-100 hover:text-neutral-900 text-neutral-700',
				secondary:
					'border-2 bg-secondary-500 text-white hover:bg-secondary-500/85 border-transparent disabled:!bg-secondary-100',
				ghost: 'hover:bg-neutral-100 hover:text-neutral-900',
				link: 'text-neutral-900 underline-offset-4 hover:underline',
			},
			size: {
				default: 'min-w-[126px] px-6 py-2.5 rounded-xl',
				sm: 'h-9 rounded-md px-3',
				lg: 'h-11 rounded-md px-8',
				icon: 'h-10 w-10',
			},
		},
		defaultVariants: {
			variant: 'default',
			size: 'default',
		},
	}
);

export interface ButtonProps
	extends React.ButtonHTMLAttributes<HTMLButtonElement>,
		VariantProps<typeof buttonVariants> {
	asChild?: boolean;
}

const Button = React.forwardRef<HTMLButtonElement, ButtonProps>(
	({ className, variant, size, asChild = false, ...props }, ref) => {
		const Comp = asChild ? Slot : 'button';
		return (
			<Comp
				className={cn(buttonVariants({ variant, size, className }))}
				ref={ref}
				{...props}
			/>
		);
	}
);
Button.displayName = 'Button';

export { Button, buttonVariants };
