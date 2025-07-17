import { cn } from '@/lib/utils';

export const DashboardCard = ({
	className,
	children,
}: Omit<ComponentProp, 'containerClassName'>) => {
	return (
		<div className={cn('mb-6 rounded-2xl bg-white p-4 lg:p-6', className)}>
			{children}
		</div>
	);
};
