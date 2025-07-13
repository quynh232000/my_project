import { cn } from '@/lib/utils';
import { forwardRef } from 'react';
import { TextVariants } from '@/components/shared/Typography/TextVariants';

interface Props extends React.HTMLAttributes<HTMLHeadingElement> {
	text?: string;
	children?: React.ReactNode;
	className?: string;
	variant?: keyof typeof TextVariants;
	tag?: 'h1' | 'h2' | 'h3' | 'h4' | 'h5' | 'h6' | 'p' | 'span';
	style?: React.CSSProperties;
	title?: string;
}

const Typography = forwardRef<HTMLHeadingElement, Props>(
	(
		{
			className,
			text,
			children,
			tag = 'p',
			variant = 'caption_14px_500',
			title,
			style,
			...props
		},
		ref
	) => {
		const Tag = tag;
		return (
			<Tag
				ref={ref}
				style={style}
				title={title}
				className={cn(TextVariants[variant], className)}
				{...props}>
				{text ?? children}
			</Tag>
		);
	}
);

Typography.displayName = 'Typography';

export default Typography;
