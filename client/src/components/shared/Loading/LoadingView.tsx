'use client';
import React from 'react';
import { useLoadingStore } from '@/store/loading/store';

interface ILoadingView {
	show?: boolean;
}
const LoadingView = ({ show }: ILoadingView) => {
	const loading = useLoadingStore((state) => state.loading);
	return (
		(show || loading) && (
			<div
				className={`fixed bottom-0 left-0 right-0 top-0 z-[1000] flex items-center justify-center bg-black/40`}>
				<div className="relative inline-block h-20 w-20">
					<div className="absolute origin-[40px_40px] animate-loading [animation-delay:-0.036s]">
						<div className="absolute left-[63px] top-[63px] -ml-1 -mt-1 h-[7px] w-[7px] rounded-full bg-white" />
					</div>
					<div className="absolute origin-[40px_40px] animate-loading [animation-delay:-0.072s]">
						<div className="absolute left-[56px] top-[68px] -ml-1 -mt-1 h-[7px] w-[7px] rounded-full bg-white" />
					</div>
					<div className="absolute origin-[40px_40px] animate-loading [animation-delay:-0.108s]">
						<div className="absolute left-[48px] top-[71px] -ml-1 -mt-1 h-[7px] w-[7px] rounded-full bg-white" />
					</div>
					<div className="absolute origin-[40px_40px] animate-loading [animation-delay:-0.144s]">
						<div className="absolute left-[40px] top-[72px] -ml-1 -mt-1 h-[7px] w-[7px] rounded-full bg-white" />
					</div>
					<div className="absolute origin-[40px_40px] animate-loading [animation-delay:-0.18s]">
						<div className="absolute left-[32px] top-[71px] -ml-1 -mt-1 h-[7px] w-[7px] rounded-full bg-white" />
					</div>
					<div className="absolute origin-[40px_40px] animate-loading [animation-delay:-0.216s]">
						<div className="absolute left-[24px] top-[68px] -ml-1 -mt-1 h-[7px] w-[7px] rounded-full bg-white" />
					</div>
					<div className="absolute origin-[40px_40px] animate-loading [animation-delay:-0.252s]">
						<div className="absolute left-[17px] top-[63px] -ml-1 -mt-1 h-[7px] w-[7px] rounded-full bg-white" />
					</div>
					<div className="absolute origin-[40px_40px] animate-loading [animation-delay:-0.288s]">
						<div className="absolute left-[12px] top-[56px] -ml-1 -mt-1 h-[7px] w-[7px] rounded-full bg-white" />
					</div>
				</div>
			</div>
		)
	);
};
export default LoadingView;
