import React from 'react';
import Typography from '@/components/shared/Typography';
import { Controller, useFormContext } from 'react-hook-form';
import { Label } from '@/components/ui/label';
import { RoomConfiguration } from '@/lib/schemas/setting-room/general-setting';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';

const RoomBreakfastPolicy = () => {
	const {  control } = useFormContext<RoomConfiguration>();
	return (
		<div className={'space-y-4 rounded-lg bg-white p-4'}>
			<Typography tag={'h3'} variant="content_16px_600" className={'flex-1'}>
				Bao gồm ăn sáng
			</Typography>
			<Controller
				control={control}
				name="extras.breakfast"
				render={({ field }) => (
					<RadioGroup
						onValueChange={(value) => field.onChange(value === "true")}
						value={String(field.value)} 
						className="space-y-2"
					>
						<div className="flex items-center space-x-2">
							<RadioGroupItem value="false" id="breakfast-no" className={
								'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
							}/>
							<Label htmlFor="breakfast-no"  containerClassName={"mb-0"} className="cursor-pointer text-neutral-600">
								Không
							</Label>
						</div>
						<div className="flex items-center space-x-2">
							<RadioGroupItem value="true" id="breakfast-yes" className={
								'size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500'
							}/>
							<Label htmlFor="breakfast-yes"  containerClassName={"mb-0"} className="cursor-pointer text-neutral-600">
								Có
							</Label>
						</div>
					</RadioGroup>
				)}
			/>
		</div>
	);
};

export default RoomBreakfastPolicy;
