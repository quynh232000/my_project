'use client';
import { cn } from '@/lib/utils';
import { DeepRequired, FieldErrorsImpl, GlobalError } from 'react-hook-form';
import {
	CancelPolicyFormValues,
	CancelPolicyRowItem,
	ECancelFeeType,
} from '@/lib/schemas/policy/cancelPolicy';
import { GlobalUI } from '@/themes/type';
import Typography from '@/components/shared/Typography';

const colors = [
	GlobalUI.colors.secondary['500'],
	GlobalUI.colors.yellow['500'],
	GlobalUI.colors.accent['3'],
];

interface CancellationTimelineProps {
	errors?: Partial<FieldErrorsImpl<DeepRequired<CancelPolicyFormValues>>> & {
		root?: Record<string, GlobalError> & GlobalError;
	};
	policyRow: CancelPolicyRowItem[];
	cancelable?: boolean;
	className?: string;
}

export const CancellationTimeline = ({
	policyRow,
	errors,
	cancelable,
	className,
}: CancellationTimelineProps) => {
	const [absentRow, ...rows] = policyRow;

	const validRows = errors
		? (rows?.filter?.((row, index) => {
				return (
					!errors?.rows?.[index + 1] &&
					!isNaN(row.day) &&
					(row.fee_type === ECancelFeeType.FREE || !isNaN(row.fee))
				);
			}) ?? [])
		: (rows ?? []);

	const maxDay = Math.max(...validRows.map((row) => row.day));

	const getRowPalette = (
		row: CancelPolicyRowItem,
		index: number,
		absent: boolean
	) => {
		return {
			background:
				row.fee_type === ECancelFeeType.FREE
					? GlobalUI.colors.accent['2']
					: absent
						? GlobalUI.colors.neutrals['200']
						: index - 1 < 0
							? GlobalUI.colors.orange['500']
							: colors[index - 1],
			width: (absent ? 30 : ((row.day * 100) / maxDay) * 0.7) + '%',
		};
	};

	return (
		<div
			className={cn(
				'scrollbar flex min-h-[109px] flex-col overflow-x-auto rounded-xl border border-blue-100 bg-neutral-00 p-6 pl-12',
				!cancelable && 'pr-12',
				className
			)}>
			{cancelable ? (
				<>
					{validRows?.length > 0 ? (
						<div className={'mt-[33px] flex flex-row'}>
							{[...validRows, absentRow].map((row, i, arr) => {
								const palette = getRowPalette(
									{ ...row, day: row.day - (arr[i + 1]?.day ?? 0) },
									i,
									i === validRows.length
								);
								return (
									<div
										key={i}
										className={`relative h-2`}
										style={{
											backgroundColor: palette.background,
											width: palette.width,
											minWidth: '70px',
										}}>
										<div
											style={{
												background:
													i === validRows.length
														? GlobalUI.colors.accent['3']
														: palette.background,
											}}
											className={`absolute left-0 w-[1px] ${i === validRows.length ? 'bottom-1/2 h-10 translate-y-1/2' : 'bottom-0 h-6'}`}>
											<Typography
												tag="p"
												variant={'caption_12px_600'}
												className={`absolute bottom-full mb-0.5 -translate-x-1/2 whitespace-nowrap text-neutral-600 ${i === validRows.length ? 'text-accent-03' : 'text-neutral-600'}`}>
												{row.day === 0 ? 'Check in' : `${row.day} ngày`}
											</Typography>
										</div>
										<Typography
											tag={'span'}
											variant={'caption_12px_500'}
											style={{
												color:
													i === validRows.length
														? GlobalUI.colors.accent['3']
														: palette.background,
											}}
											className={
												'absolute left-1/2 top-1.5 mt-2 -translate-x-1/2 whitespace-nowrap'
											}>
											{row.fee_type === ECancelFeeType.FREE
												? 'Miễn phí'
												: row.fee + '%'}
										</Typography>
										{i === validRows.length && (
											<Typography
												tag={'span'}
												variant={'caption_12px_600'}
												className={
													'absolute bottom-full left-1/2 mb-[18px] -translate-x-1/2 text-center text-neutral-600'
												}>
												No-show
											</Typography>
										)}
									</div>
								);
							})}
						</div>
					) : (
						<Typography
							tag="p"
							variant={'caption_12px_600'}
							className={'m-auto text-neutral-300'}>
							No Preview
						</Typography>
					)}
				</>
			) : (
				<>
					<div className={'mt-[33px] flex flex-row'}>
						<div
							style={{ backgroundColor: GlobalUI.colors.accent['3'] }}
							className={`relative h-2 w-full`}>
							<div
								className={`absolute bottom-0 left-0 h-6 w-[1px]`}
								style={{ background: GlobalUI.colors.accent['3'] }}>
								<Typography
									tag="p"
									variant={'caption_12px_600'}
									className={`absolute bottom-full mb-0.5 -translate-x-1/2 whitespace-nowrap text-neutral-600`}>
									Ngày đặt
								</Typography>
							</div>
							<Typography
								tag={'span'}
								style={{ color: GlobalUI.colors.accent['3'] }}
								variant={'caption_12px_500'}
								className={
									'absolute left-1/2 top-1.5 mt-2 -translate-x-1/2 whitespace-nowrap'
								}>
								Không hoàn không huỷ
							</Typography>
							<div
								style={{ background: GlobalUI.colors.accent['3'] }}
								className={`absolute bottom-1/2 right-0 h-10 w-[1px] translate-y-1/2`}>
								<Typography
									tag="p"
									variant={'caption_12px_600'}
									className={`absolute bottom-full mb-0.5 -translate-x-1/2 whitespace-nowrap text-accent-03`}>
									Check-in
								</Typography>
							</div>
						</div>
					</div>
				</>
			)}
		</div>
	);
};
