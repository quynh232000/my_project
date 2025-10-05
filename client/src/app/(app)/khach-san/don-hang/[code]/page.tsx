import React, { Suspense } from 'react'
import Container from './components/Container'
import SkeLoading from '@/components/shared/Skeleton/SkeLoading';

async function Page({ params }: { params:Promise< { code: string; }> }) {
  const { code } =await params;
    return (
      <div className=" bg-gray-50">
        <Suspense fallback={<SkeLoading/>}>
            
          <Container code={code}/>
              </Suspense>
      </div>
  )
}

export default Page