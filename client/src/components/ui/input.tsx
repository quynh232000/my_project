'use client';

import * as React from 'react';
import { cn } from '@/lib/utils';
import { IconCloseCircle } from '@/assets/Icons/filled';
import { GlobalUI } from '@/themes/type';

interface InputProps extends React.ComponentProps<'input'> {
	startAdornment?: React.ReactNode;
	endAdornment?: React.ReactNode;
	clearable?: boolean;
}

const Input = React.forwardRef<HTMLInputElement, InputProps>(
	(
		{
			clearable,
			startAdornment,
			endAdornment,
			className,
			type,
			value,
			onChange,
			...props
		},
		ref
	) => {
		const [internalValue, setInternalValue] = React.useState('');
		const inputRef = React.useRef<HTMLInputElement>(null);

		React.useImperativeHandle(ref, () => inputRef.current!);

		const isControlled = value !== undefined;
		const displayValue = isControlled ? value : internalValue;

		const handleClear = () => {
			onChange?.({
				target: { value: '' },
			} as React.ChangeEvent<HTMLInputElement>);
			setInternalValue('');
			inputRef.current?.focus();
		};

		const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
			if (!isControlled) {
				setInternalValue(e.target.value);
			}
			onChange?.(e);
		};

		return (
			<div className={'relative max-w-full'}>
				<input
					type={type}
					className={cn(
						'flex h-12 w-full max-w-full rounded-lg border-2 border-other-divider-02 bg-white p-3 text-base text-neutral-600 outline-none',
						'focus-visible:border-secondary-200',
						'disabled:cursor-not-allowed disabled:bg-neutral-50',
						'placeholder-neutral-300 placeholder:text-neutral-300',
						`${!!startAdornment && 'pl-10'}`,
						`${!!endAdornment && 'pr-10'}`,
						`${clearable && displayValue && 'pr-10'}`, // Add padding when clear button is visible
						className
					)}
					ref={inputRef}
					value={displayValue}
					onChange={handleChange}
					{...props}
				/>
				{!!startAdornment && (
					<div className={'absolute top-2/4 ml-2.5 -translate-y-1/2'}>
						{startAdornment}
					</div>
				)}
				{!!endAdornment && (
					<div
						className={
							'absolute right-2.5 top-2/4 -translate-y-1/2'
						}>
						{endAdornment}
					</div>
				)}
				{clearable && displayValue ? (
					<div
						className={
							'absolute right-0 top-2/4 mr-2.5 -translate-y-1/2 cursor-pointer hover:opacity-80'
						}
						onClick={handleClear}>
						<IconCloseCircle
							width={20}
							height={20}
							fill={GlobalUI.colors.neutrals['300']}
							color={GlobalUI.colors.white}
						/>
					</div>
				) : null}
			</div>
		);
	}
);
Input.displayName = 'Input';

export { Input };
