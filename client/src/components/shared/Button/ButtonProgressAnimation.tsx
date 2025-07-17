'use client';
import React, { forwardRef, useState } from 'react';
import { HTMLMotionProps, motion } from 'framer-motion';
import { ButtonVariants } from '@/components/shared/Button/types';
import { cn } from '@/lib/utils';

interface ButtonProgressAnimationProps
	extends Omit<HTMLMotionProps<'button'>, 'ref' | 'onClick' | 'children'> {
	onButtonClick?: () => void;
	children?: React.ReactNode;
	className?:string
}

export const ButtonProgressAnimation = forwardRef<
	HTMLButtonElement,
	ButtonProgressAnimationProps
>(({ className, onButtonClick, children, ...props }, ref) => {
	const [clicked, setClicked] = useState(false);
	return (
		<motion.button
		{...({} as any)}
			ref={ref}
			{...props}
			disabled={clicked}
			onClick={() => {
				setClicked(true);
				onButtonClick?.();
			}}
			layout
			transition={{ duration: 0.4 }}
			style={{ borderRadius: 12 }}
			className={cn(
				ButtonVariants['16px_px24_py12_active'],
				'flex w-full items-center justify-center',
				className,
				clicked && 'cursor-progress'
			)}>
			{!clicked ? (
				<motion.p>{children}</motion.p>
			) : (
				<motion.div
				{...({} as any)}
					initial={{ opacity: 0 }}
					animate={{ opacity: 1 }}
					transition={{ duration: 0.3, delay: 0.4 }}>
					<span className="flex w-fit items-center justify-center px-6">
						<span className="h-5 w-5 animate-spin-slow rounded-full border-2 border-white border-t-transparent" />
					</span>
				</motion.div>
			)}
		</motion.button>
	);
});

ButtonProgressAnimation.displayName = 'ButtonProgressAnimation';
