'use client';
import SkeLoading from '@/components/shared/Skeleton/SkeLoading';
import Container from './components/Container';
import { Suspense } from 'react';
function page() {

	
	return <div className='mt-[148px]'>
		{/* banner search */}
		<Suspense fallback={<SkeLoading/>}>
		<Container/>
    </Suspense>
	</div>;
}

export default page;
