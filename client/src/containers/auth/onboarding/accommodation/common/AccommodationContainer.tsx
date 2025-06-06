import { cn } from '@/lib/utils';
import Typography from '@/components/shared/Typography';

interface Props extends ComponentProp {
	title: string;
}

export const AccommodationContainer = ({
	children,
	className,
	containerClassName,
	title,
}: Props) => {
	return (
		<div className={cn('rounded-2xl bg-blue-100 p-6', containerClassName)}>
			<div className={cn('rounded-lg_plus bg-white p-6', className)}>
				<Typography variant={'headline_24px_600'} className={'mb-4'}>
					{title}
				</Typography>
				{children}
			</div>
		</div>
	);
};
