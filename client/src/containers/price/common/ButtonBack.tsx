'use client';
import React from 'react';
import { IconChevron } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import { useRouter } from 'next/navigation';

const ButtonBack = ({ url = '' }: { url?: string }) => {
	const router = useRouter();
	return (
		<div
			onClick={() => (url ? router.push(url) : router.back())}
			className={'flex size-8 cursor-pointer items-center justify-center'}>
			<IconChevron
				direction={'left'}
				className={'size-5'}
				color={GlobalUI.colors.neutrals['700']}
			/>
		</div>
	);
};

export default ButtonBack;
