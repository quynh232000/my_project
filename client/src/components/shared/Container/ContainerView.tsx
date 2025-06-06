import { cn } from '@/lib/utils';

const ContainerView = ({
	children,
	className,
	containerClassName,
}: ComponentProp) => {
	return (
		<div className={cn('px-4 md:px-6', containerClassName)}>
			<div className={cn('container mx-auto', className)}>{children}</div>
		</div>
	);
};

export default ContainerView;
