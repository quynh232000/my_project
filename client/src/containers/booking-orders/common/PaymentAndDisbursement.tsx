import React, { Fragment } from 'react';
import { payoutDetails } from '@/containers/booking-orders/data';
import Typography from '@/components/shared/Typography';
import { Separator } from '@/components/ui/separator';

const PaymentAndDisbursement = () => {
	return (
		<div className={'space-y-4'}>
			{payoutDetails.map((payout, index) => (
				<div
					key={index}
					className={'rounded-lg border border-other-divider-02 p-4'}>
					<Typography
						tag={'h3'}
						variant="caption_14px_600"
						className={'mb-2 text-neutral-700'}>
						{payout.title}
					</Typography>
					{payout.children.map((item, index) => (
						<Fragment key={index}>
							<div className="grid grid-cols-3 gap-4">
								<Typography
									tag="span"
									variant="caption_14px_400"
									className="col-span-1 text-neutral-600">
									{item.title}
								</Typography>
								<Typography
									tag="span"
									variant="caption_14px_400"
									className="col-span-2 text-neutral-600">
									{item.value}
								</Typography>
							</div>
							{index !== payout.children.length - 1 && (
								<Separator
									orientation={'horizontal'}
									className={'my-2'}
								/>
							)}
						</Fragment>
					))}
				</div>
			))}
		</div>
	);
};

export default PaymentAndDisbursement;
