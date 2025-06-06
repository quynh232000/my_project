import React from 'react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';

const ButtonActionGroup = ({
	className,
	btnClassName,
	actionCancel,
	actionSubmit,
	titleBtnCancel = 'Bỏ qua',
	titleBtnConfirm = 'Lưu lại',
	disabledBtnConfirm = false,
}: {
	className?: string;
	btnClassName?: string;
	actionCancel?: () => void;
	actionSubmit?: () => void;
	titleBtnCancel?: string;
	titleBtnConfirm?: string;
	disabledBtnConfirm?: boolean;
}) => {
	return (
		<div className={cn('mt-6 flex justify-end gap-2', className)}>
			<Button onClick={actionCancel} variant={'outline'} type={'button'} className={btnClassName}>
				{titleBtnCancel}
			</Button>
			<Button
				variant={'secondary'}
				onClick={actionSubmit}
				disabled={disabledBtnConfirm}
				type={actionSubmit ? 'button' : 'submit'}
				className={btnClassName}>
				{titleBtnConfirm}
			</Button>
		</div>
	);
};

export default ButtonActionGroup;
