'use client';

import { useTheme } from 'next-themes';
import { Toaster as Sonner } from 'sonner';
import { TextVariants } from '@/components/shared/Typography/TextVariants';

type ToasterProps = React.ComponentProps<typeof Sonner>;

const Toaster = ({ position = 'top-right', ...props }: ToasterProps) => {
	const { theme = 'system' } = useTheme();

	return (
		<Sonner
			theme={theme as ToasterProps['theme']}
			className="toaster group !font-[inherit]"
			toastOptions={{
				classNames: {
					content: 'text-inherit',
					title: `!text-[14px] !font-medium !leading-[24px] select-none first-letter:uppercase`,
					toast:
						'font-[inherit] group toast group-[.toaster]:bg-white group-[.toaster]:border-neutral-200 group-[.toaster]:shadow-lg',
					description: `!text-neutral-500 !text-[12px] !font-bold !leading-[16px] select-none`,
					actionButton:
						'group-[.toast]:bg-neutral-900 group-[.toast]:text-neutral-500',
					cancelButton:
						'group-[.toast]:bg-neutral-100 group-[.toast]:text-neutral-500',
					closeButton: 'opacity-0 group-hover:opacity-100',
					error: `group-[.toaster]:text-red-500 group-[.toaster]:${TextVariants.caption_14px_600}`,
					success: `group-[.toaster]:text-green-500 group-[.toaster]:${TextVariants.caption_14px_600}`,
				},
			}}
			position={position}
			duration={2000}
			{...props}
		/>
	);
};

export { Toaster };
