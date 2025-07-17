'use client';
import { motion } from 'framer-motion';
import { cn } from '@/lib/utils';
import IconClose from '@/assets/Icons/outline/IconClose';
import IconCheck from '@/assets/Icons/outline/IconCheck';
import Typography from '@/components/shared/Typography';

interface ValidationStatusItemProps {
	status?: boolean;
	message: string;
}

const ValidationStatusItem = ({
	message,
	status = false,
}: ValidationStatusItemProps) => {
	return (
		<div className={'flex items-center gap-2'}>
			<motion.div
			{...({} as any)}
				initial={{ opacity: 0 }}
				animate={{ opacity: 1 }}
				exit={{ opacity: 0 }}
				transition={{ duration: 0.3, delay: 0.3 }}
				className={cn(
					'flex size-6 items-center justify-center rounded-full transition-colors duration-300',
					status ? 'bg-green-500' : 'bg-red-500'
				)}>
				{status ? (
					<IconCheck color={'#ffffff'} />
				) : (
					<IconClose color={'#ffffff'} />
				)}
			</motion.div>
			<Typography
				className={cn(
					'text-red-500 transition-colors duration-300',
					status && 'text-green-500'
				)}>
				{message}
			</Typography>
		</div>
	);
};

export default ValidationStatusItem;
