'use client';
import { motion } from 'framer-motion';

type Props = {
	children: React.ReactNode;
	className?: string;
	config?: {
		start?: number;
		end?: number;
		delay?: number;
	};
};

const FadeAnimationView = ({ children, className, config }: Props) => {
	return (
		<motion.div
			className={className}
			initial={{ opacity: 0, y: config?.start }}
			animate={{ opacity: 1, y: config?.end }}
			transition={{ duration: 0.3, delay: config?.delay, ease: 'easeOut' }}>
			{children}
		</motion.div>
	);
};

export default FadeAnimationView;
