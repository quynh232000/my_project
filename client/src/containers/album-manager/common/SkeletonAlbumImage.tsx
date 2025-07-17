import React from 'react';
import { Skeleton } from '@/components/ui/skeleton';

const SkeletonAlbumImage = () => {
	return (
		<>
			{Array(2)
				.fill(null)
				.map((_, i) => (
					<div key={i} className={'mt-8'}>
						<Skeleton className={'h-6 w-40 rounded-xl'} />
						<div className={'mt-4 grid grid-cols-6'}>
							{Array(6)
								.fill(null)
								.map((_, i) => (
									<div key={i}>
										<Skeleton
											className={
												'h-[159px] w-[240px] rounded-xl'
											}
										/>
										<Skeleton
											className={
												'mt-2 h-6 w-24 rounded-xl'
											}
										/>
									</div>
								))}
						</div>
					</div>
				))}
		</>
	);
};

export default SkeletonAlbumImage;
