import React from 'react'
import Container from './components/Container'
import { Suspense } from 'react';
function page() {
  return (
    <div  className='mt-[148px]'>
       <Suspense fallback={<div>Đang tải...</div>}>
        <Container/>
      </Suspense>
    </div>
  )
}

export default page