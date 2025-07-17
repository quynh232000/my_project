import React from 'react';
import { timeSelectData } from '@/containers/booking-orders/data';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Label } from '@/components/ui/label';

const PresetTimeSelector = () => {
	return (
		<RadioGroup className={'grid grid-cols-3 gap-4'}>
			{timeSelectData.map((timeSelect, index) => (
				<div key={index}>
					<Typography
						tag="p"
						variant={'caption_14px_600'}
						className={'text-nowrap text-neutral-600'}>
						{timeSelect.title}
					</Typography>
					{timeSelect.children.map((item, index) => (
						<div
							className={'flex items-center gap-2 py-1'}
							key={index}>
							<RadioGroupItem
								id={`time-${item.value}`}
								value={item.value}
							/>
							<Label
								htmlFor={`time-${item.value}`}
								containerClassName={'m-0'}
								className={`cursor-pointer ${TextVariants.caption_14px_400}`}>
								{item.title}
							</Label>
						</div>
					))}
				</div>
			))}
		</RadioGroup>
	);
};

export default PresetTimeSelector;
