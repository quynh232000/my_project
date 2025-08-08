'use client';
import Container from './components/Container';
import { Suspense } from 'react';
function page() {

	
	return <div className='mt-[148px]'>
		{/* banner search */}
		<Suspense fallback={<div>Đang tải...</div>}>
		<Container/>
    </Suspense>
	</div>;
}

export default page;
