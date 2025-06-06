import React from 'react';
import Typography from '@/components/shared/Typography';

const PromotionDuration = () => {
	return (
		<div className={'rounded-lg border border-blue-100 bg-white p-4'}>
			<Typography
				tag={'h2'}
				variant={'content_16px_600'}
				className={'text-neutral-600'}>
				Bạn muốn áp dụng khuyến mãi này trong bao lâu?
			</Typography>
			
		</div>
	);
};

export default PromotionDuration;