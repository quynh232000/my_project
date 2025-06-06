import * as React from 'react';
import { cn } from '@/lib/utils';
import { NumericFormat } from 'react-number-format';
import { NumericFormatProps } from 'react-number-format/types/types';
import Typography from '@/components/shared/Typography';

interface NumberInputProps extends NumericFormatProps {
	endAdornment?: string;
	endAdornmentClassname?: string;
}

const NumberInput = React.forwardRef<NumericFormatProps, NumberInputProps>(
	(
		{ endAdornment, endAdornmentClassname, className, suffix = 'đ', ...props },
		ref
	) => {
		return (
			<>
				<NumericFormat
					getInputRef={ref}
					thousandSeparator=","
					decimalSeparator="."
					suffix={suffix}
					allowNegative={false}
					decimalScale={0}
					maxLength={20}
					className={cn(
						'peer flex h-12 w-full rounded-lg border-2 border-other-divider-02 bg-white p-3 text-base text-neutral-600 md:text-base',
						'focus-visible:border-secondary-200 focus-visible:outline-none',
						'disabled:cursor-not-allowed disabled:opacity-50',
						'placeholder-neutral-300 placeholder:text-neutral-300',
						className
					)}
					{...props}
				/>
				{endAdornment && (
					<Typography
						tag={'span'}
						variant={'caption_12px_500'}
						className={cn(
							'absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 peer-disabled:opacity-50',
							endAdornmentClassname
						)}>
						{endAdornment}
					</Typography>
				)}
			</>
		);
	}
);
NumberInput.displayName = 'CurrencyInput';

export { NumberInput };
