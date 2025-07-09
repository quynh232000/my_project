'use client';

import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import Typography from '@/components/shared/Typography';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormMessage,
} from '@/components/ui/form';
import { NumberInput } from '@/components/ui/number-input';
import {
	Popover,
	PopoverAnchor,
	PopoverArrow,
	PopoverContent,
} from '@/components/ui/popover';
import { useLoadingStore } from '@/store/loading/store';
import { priceConvert } from '@/utils/string/priceConvert';
import { zodResolver } from '@hookform/resolvers/zod';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { z } from 'zod';

interface AvailabilityCellsPopoverProps {
	open: boolean;
	anchor: HTMLElement | null;
	collisionBoundary: HTMLDivElement | null;
	onClose: () => void;
	onSubmit: (data: number) => void;
	type: 'roomCount' | 'price' | undefined;
	defaultValue?: number;
	validate?: {
		min?: number;
		max?: number;
	};
}

const createFormSchema = (min?: number, max?: number) => {
	return z.object({
		val: z
			.number({ message: 'Vui lòng nhập giá trị hợp lệ' })
			.min(min ?? 0, `Giá trị không được nhỏ hơn ${priceConvert(min ?? 0)}`)
			.max(
				max ?? 999999999,
				`Giá trị không được lớn hơn ${priceConvert(max ?? 999999999)}`
			),
	});
};

type TFormSchema = z.infer<ReturnType<typeof createFormSchema>>;
const AvailabilityCellsPopover = ({
	open,
	anchor,
	collisionBoundary,
	onClose,
	type,
	defaultValue,
	validate,
	onSubmit,
}: AvailabilityCellsPopoverProps) => {
	const loading = useLoadingStore((state) => state.loading);
	const form = useForm<TFormSchema>({
		resolver: zodResolver(createFormSchema(validate?.min, validate?.max)),
		defaultValues: {
			val: defaultValue ?? NaN,
		},
		mode: 'onChange',
	});

	useEffect(() => {
		if (loading) {
			onClose();
		}
	}, [loading]);

	const {
		control,
		handleSubmit,
		formState: { errors, isDirty },
	} = form;

	const palete = {
		roomCount: {
			title: 'Cập nhật phòng trống',
			label: 'Số phòng trống',
			placeholder: '10',
			suffix: 'phòng',
			maxLength: 5,
		},
		price: {
			title: 'Cập nhật giá',
			label: 'Giá',
			placeholder: '2,000,000',
			suffix: 'VNĐ',
			maxLength: 11,
		},
	};

	const _onSubmit = (data: TFormSchema) => {
		onSubmit(data.val);
	};

	return (
		<Popover open={open}>
			{anchor && <PopoverAnchor virtualRef={{ current: anchor }} />}
			<PopoverContent
				sticky="always"
				arrowPadding={8}
				className="w-[354px] p-4 shadow-2xl"
				side="bottom"
				collisionBoundary={collisionBoundary}>
				<Typography>{type ? palete[type].title : ''}</Typography>
				<Form {...form}>
					<FormField
						name="val"
						control={control}
						render={({ field: { value, onChange } }) => (
							<FormItem>
								<div className="mt-2 flex flex-row items-center gap-2">
									<Typography variant="caption_12px_400" className="flex-1">
										{type ? palete[type].label : ''}
									</Typography>

									<div className="relative">
										<FormControl>
											<NumberInput
												placeholder={type ? palete[type].placeholder : ''}
												inputMode="numeric"
												suffix=""
												className={`h-10 w-[150px] rounded-xl py-2 leading-6`}
												endAdornment={type ? palete[type].suffix : ''}
												value={value ?? NaN}
												maxLength={type ? palete[type].maxLength : undefined}
												onValueChange={(e) => {
													onChange(
														e.value.length === 0 ? NaN : Number(e.value)
													);
												}}
											/>
										</FormControl>
									</div>
								</div>
								<FormMessage className="text-right" />
							</FormItem>
						)}
					/>
				</Form>
				<ButtonActionGroup
					actionCancel={onClose}
					actionSubmit={handleSubmit(_onSubmit)}
					titleBtnCancel="Hủy"
					titleBtnConfirm="Cập nhật"
					disabledBtnConfirm={!!errors.val || !isDirty}
					btnClassName="h-10"
				/>
				<PopoverArrow className="fill-neutral-400" />
			</PopoverContent>
		</Popover>
	);
};

export default AvailabilityCellsPopover;
