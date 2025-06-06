'use client';
import * as React from 'react';
import { useEffect, useState } from 'react';
import { cn } from '@/lib/utils';
import { Check } from 'lucide-react';

export const CheckBoxView = ({
	className,
	containerClassName,
	children,
	value,
	onValueChange,
	defaultValue = false,
	id,
}: ComponentProp & {
	id?: string;
	onValueChange?: (val: boolean) => void;
	value?: boolean;
	defaultValue?: boolean;
}) => {
	const [checked, setChecked] = useState<boolean>(defaultValue);

	useEffect(() => {
		if (value !== undefined) {
			setChecked(value);
		}
	}, [value]);

	return (
		<button
			id={id}
			type="button"
			onClick={() => {
				setChecked(!checked);
				onValueChange?.(!checked);
			}}
			className={cn(
				'text-neutrals-3 hover:text-neutrals-1 group col-span-12 flex items-center gap-2 text-start leading-6 transition-colors duration-300 lg:col-span-1',
				containerClassName
			)}>
			<div
				className={cn(
					'flex size-5 flex-shrink-0 items-center justify-center rounded-[5px] border-2 text-white transition-colors duration-300',
					className,
					checked
						? 'border-secondary-500 bg-secondary-500'
						: 'border-other-divider group-hover:border-other-overlay'
				)}>
				{checked && <Check className="h-4 w-4" />}
			</div>
			{children}
		</button>
	);
};
