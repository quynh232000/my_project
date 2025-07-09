import React, { Fragment } from 'react';
import { payoutDetails } from '@/containers/booking-orders/data';
import Typography from '@/components/shared/Typography';
import { Separator } from '@/components/ui/separator';

const PaymentAndDisbursement = () => {
	return (
		<div className={"space-y-4"}>
			{
				payoutDetails.map((payout, index) => (
					<div key={index} className={"p-4 border border-other-divider-02 rounded-lg"}>
						<Typography tag={"h3"} variant="caption_14px_600" className={"text-neutral-700 mb-2"}>{payout.title}</Typography>
						{
							payout.children.map((item, index) => (
								<Fragment key={index}>
									<div className="grid grid-cols-3 gap-4">
										<Typography
											tag="span"
											variant="caption_14px_400"
											className="text-neutral-600 col-span-1"
										>
											{item.title}
										</Typography>
										<Typography
											tag="span"
											variant="caption_14px_400"
											className="text-neutral-600 col-span-2"
										>
											{item.value}
										</Typography>
									</div>
									{
										index !== payout.children.length - 1 &&
										<Separator orientation={"horizontal"} className={"my-2"}/>
									}
								</Fragment>
							))
						}
					</div>
				))
			}
		</div>
	);
};

export default PaymentAndDisbursement;