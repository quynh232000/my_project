import React from 'react';
import { ErrorMessage } from '@hookform/error-message';
import Typography from '@/components/shared/Typography';
import { FieldErrors } from 'react-hook-form';
import { cn } from '@/lib/utils';

const FieldErrorMessage = ({
	className = '',
	errors,
	name,
}: {
	className?: string;
	errors: FieldErrors;
	name: string;
}) => {
	return (
		<ErrorMessage
			errors={errors}
			name={name}
			render={({ message }) => (
				<Typography
					tag="span"
					variant="caption_12px_500"
					className={cn('mt-2 text-red-500', className)}>
					{message}
				</Typography>
			)}
		/>
	);
};

export default FieldErrorMessage;
