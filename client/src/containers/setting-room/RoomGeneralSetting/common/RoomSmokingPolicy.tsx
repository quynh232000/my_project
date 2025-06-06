import React from 'react';
import Typography from '@/components/shared/Typography';
import { useFormContext } from 'react-hook-form';
import { Label } from '@/components/ui/label';
import { RoomConfiguration } from '@/lib/schemas/setting-room/general-setting';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { FormField, FormMessage } from '@/components/ui/form';

export default function RoomSmokingPolicy() {

	const { control  } = useFormContext<RoomConfiguration>()

	return (
		<div className={'space-y-4 rounded-lg bg-white p-4'}>
			<Typography tag={'h3'} variant="content_16px_600" className={'text-neutral-600'}>
				Được phép hút thuốc
			</Typography>

			<FormField name="extras.smoking" control={control}
				render={({ field }) => (
				<>
					<RadioGroup className="space-y-2"
					onValueChange={(value) => field.onChange(value === 'true')}
					value={String(field.value)}
					>
					<div className="flex items-center space-x-2">
						<RadioGroupItem id="smoking-no" value="false" className="size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500" />
						<Label htmlFor="smoking-no" containerClassName="mb-0" className="cursor-pointer text-neutral-600">
							Không
						</Label>
					</div>
					<div className="flex items-center space-x-2">
						<RadioGroupItem id="smoking-yes" value="true" className="size-5 border-2 border-other-divider bg-white text-secondary-500 data-[state=checked]:border-secondary-500" />
						<Label htmlFor="smoking-yes" containerClassName="mb-0" className="cursor-pointer text-neutral-600">
							Có
						</Label>
					</div>
					</RadioGroup>
					<FormMessage />
				</>
				)}
			/>
		</div>
	)
}

