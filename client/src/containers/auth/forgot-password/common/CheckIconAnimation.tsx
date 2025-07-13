'use client';
import { motion } from 'framer-motion';

const CheckIconAnimation = () => {
	return (
		<div className={'relative mb-6'}>
			{/* blue triangle */}
			<motion.svg
				className={'absolute'}
				initial={{ opacity: 0, left: '-0%', top: '-0%' }}
				animate={{ opacity: 1, left: '-75%', top: '-25%' }}
				transition={{ duration: 0.3, delay: 0.6 }}
				xmlns="http://www.w3.org/2000/svg"
				width="37"
				height="40"
				viewBox="0 0 37 40"
				fill="none">
				<motion.path
					d="M5.95473 10.1396L27.5611 20.8959L22.1608 28.2601L5.95473 10.1396Z"
					fill="#2F78EE"
				/>
			</motion.svg>

			{/* green line */}
			<motion.svg
				xmlns="http://www.w3.org/2000/svg"
				width="22"
				height="20"
				viewBox="0 0 22 20"
				className={'absolute'}
				initial={{ opacity: 0, left: '0%', bottom: '25%' }}
				animate={{ opacity: 1, left: '-50%', bottom: '25%' }}
				transition={{ duration: 0.3, delay: 0.4 }}
				fill="none">
				<motion.path
					d="M1.37893 13.1553C1.37893 13.1553 12.127 7.80198 14.5652 10.6078C15.9048 12.1493 16.9163 14.0164 15.7167 15.5333C14.7919 16.7026 13.4567 16.8516 11.8924 16.5769C8.57955 15.9951 8.6298 11.3947 9.95962 8.54549C11.7957 4.61167 21.5422 6.9336 21.5422 6.9336"
					stroke="#0BA259"
					strokeWidth="2.01707"
					initial={{ pathLength: 0 }}
					animate={{ pathLength: 1 }}
					transition={{ duration: 0.8 }}
				/>
			</motion.svg>

			{/* blue line */}
			<motion.svg
				className={'absolute'}
				initial={{ opacity: 0, left: '0%', bottom: '0%' }}
				animate={{ opacity: 1, left: '-25%', bottom: '-15%' }}
				transition={{ duration: 0.3, delay: 0.6 }}
				xmlns="http://www.w3.org/2000/svg"
				width="20"
				height="16"
				viewBox="0 0 20 16"
				fill="none">
				<motion.path
					d="M3.04687 14.4907L3.88395 7.27084L9.7194 10.9703L10.3846 4.9136L15.7074 8.5803L17.3651 2.03254"
					stroke="#2F78EE"
					strokeWidth="1.68089"
					initial={{ pathLength: 0 }}
					animate={{ pathLength: 1 }}
					transition={{ duration: 1.2 }}
				/>
			</motion.svg>

			{/* blue line */}
			<motion.svg
				className={'absolute'}
				initial={{ opacity: 0, right: '0%', bottom: '0%' }}
				animate={{ opacity: 1, right: '-30%', bottom: '-15%' }}
				transition={{ duration: 0.3, delay: 0.6 }}
				xmlns="http://www.w3.org/2000/svg"
				width="17"
				height="13"
				viewBox="0 0 17 13"
				fill="none">
				<path
					d="M6.11649 7.00188C8.88748 7.28078 11.5808 3.06546 11.2698 6.15609C10.9587 9.24672 8.46019 11.5261 5.6892 11.2472C2.91821 10.9683 0.924048 8.23674 1.23512 5.14611C1.54619 2.05548 3.3455 6.72298 6.11649 7.00188Z"
					fill="#2F78EE"
				/>
			</motion.svg>

			{/* orange star */}
			<motion.svg
				className={'absolute'}
				initial={{ opacity: 0, right: '45%', top: '0%' }}
				animate={{ opacity: 1, right: '45%', top: '-50%' }}
				transition={{ duration: 0.4, delay: 0.4 }}
				xmlns="http://www.w3.org/2000/svg"
				width="11"
				height="11"
				viewBox="0 0 11 11"
				fill="none">
				<path
					d="M5.23017 0.5L6.36232 3.9844H10.026L7.06203 6.13788L8.19418 9.62228L5.23017 7.4688L2.26616 9.62228L3.39831 6.13788L0.434306 3.9844H4.09802L5.23017 0.5Z"
					fill="#FE964A"
				/>
			</motion.svg>

			{/* blue line */}
			<motion.svg
				className={'absolute'}
				initial={{ opacity: 0, right: '0%', top: '0%' }}
				animate={{ opacity: 1, right: '-25%', top: '-25%' }}
				transition={{ duration: 0.3, delay: 0.5 }}
				xmlns="http://www.w3.org/2000/svg"
				width="14"
				height="12"
				viewBox="0 0 14 12"
				fill="none">
				<path
					d="M1.30012 11.4249C1.30012 11.4249 0.481877 6.56419 2.83015 5.59536C4.80293 4.78146 6.51325 8.38083 8.13425 7.07589C9.7762 5.75409 5.67736 3.66006 7.01223 2.07911C8.41713 0.415215 12.9283 2.07911 12.9283 2.07911"
					stroke="#2F78EE"
					strokeWidth="2.01707"
				/>
			</motion.svg>

			{/* green star */}
			<motion.svg
				className={'absolute'}
				initial={{ opacity: 0, right: '0%', top: '25%' }}
				animate={{ opacity: 1, right: '-65%', top: '5%' }}
				transition={{ duration: 0.4, delay: 0.5 }}
				xmlns="http://www.w3.org/2000/svg"
				width="18"
				height="18"
				viewBox="0 0 18 18"
				fill="none">
				<path
					d="M9.10953 0.49292L10.9965 6.30026H17.1026L12.1626 9.88939L14.0495 15.6967L9.10953 12.1076L4.16952 15.6967L6.05644 9.88939L1.11642 6.30026H7.22262L9.10953 0.49292Z"
					fill="#0BA259"
				/>
			</motion.svg>

			{/* violet circle */}
			<motion.svg
				className={'absolute'}
				initial={{ opacity: 0, right: '0%', bottom: '25%' }}
				animate={{ opacity: 1, right: '-55%', bottom: '35%' }}
				transition={{ duration: 0.3, delay: 0.4 }}
				xmlns="http://www.w3.org/2000/svg"
				width="13"
				height="13"
				viewBox="0 0 13 13"
				fill="none">
				<circle cx="6.2171" cy="6.7923" r="5.88312" fill="#FFEDEC" />
			</motion.svg>

			{/* violet circle */}
			<motion.svg
				className={'absolute'}
				initial={{ opacity: 0, right: '0%', bottom: '25%' }}
				animate={{ opacity: 1, right: '-45%', bottom: '25%' }}
				transition={{ duration: 0.3, delay: 0.5 }}
				xmlns="http://www.w3.org/2000/svg"
				width="6"
				height="6"
				viewBox="0 0 6 6"
				fill="none">
				<circle cx="3.34556" cy="2.8126" r="2.52134" fill="#FFEDEC" />
			</motion.svg>

			{/* orange half-moon */}
			<motion.svg
				className={'absolute'}
				initial={{ opacity: 0, left: '25%', top: '-0%' }}
				animate={{ opacity: 1, left: '-5%', top: '-40%' }}
				transition={{ duration: 0.3, delay: 0.6 }}
				xmlns="http://www.w3.org/2000/svg"
				width="11"
				height="16"
				viewBox="0 0 11 16"
				fill="none">
				<path
					d="M7.0681 8.14922C7.0681 12.3267 13.7639 15.7132 9.1045 15.7132C4.44513 15.7132 0.667969 12.3267 0.667969 8.14922C0.667969 3.97173 4.44513 0.585205 9.1045 0.585205C13.7639 0.585205 7.0681 3.97173 7.0681 8.14922Z"
					fill="#FE964A"
				/>
			</motion.svg>

			{/* check */}
			<motion.div
			{...({} as any)}
				initial={{ scale: 0 }}
				animate={{ scale: 1 }}
				transition={{ duration: 0.3 }}
				className={'rounded-full bg-[#27A376] p-5'}>
				<motion.div
				{...({} as any)}
					initial={{ scale: 0 }}
					animate={{ scale: 1 }}
					transition={{ duration: 0.3, delay: 0.3 }}
					className={
						'flex size-[50px] items-center justify-center rounded-full bg-white'
					}>
					<motion.svg
						initial={{ scale: 0 }}
						animate={{ scale: 1 }}
						transition={{ duration: 0.3, delay: 0.6 }}
						xmlns="http://www.w3.org/2000/svg"
						width="31"
						height="31"
						viewBox="0 0 31 31"
						fill="none">
						<motion.path
							initial={{ clipPath: 'inset(0 100% 0 0)' }}
							animate={{ clipPath: 'inset(0 0 0 0)' }}
							transition={{ duration: 0.3, delay: 0.4 }}
							fillRule="evenodd"
							clipRule="evenodd"
							d="M26.6837 8.18911C27.1718 8.67727 27.1718 9.46873 26.6837 9.95688L14.1837 22.4569C13.6955 22.945 12.9041 22.945 12.4159 22.4569L6.16592 16.2069C5.67777 15.7187 5.67777 14.9273 6.16592 14.4391C6.65408 13.951 7.44553 13.951 7.93369 14.4391L13.2998 19.8052L24.9159 8.18911C25.4041 7.70096 26.1955 7.70096 26.6837 8.18911Z"
							fill="#111827"
						/>
					</motion.svg>
				</motion.div>
			</motion.div>
		</div>
	);
};

export default CheckIconAnimation;
