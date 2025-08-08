import React, { Suspense } from 'react'
import Container from './components/Container'

function page() {
  return (
    <div className='mt-[148px] bg-gray-50'>
      <Suspense fallback={<div>Đang tải...</div>}>
      <Container/>
              {/* <Container/> */}
            </Suspense>
    </div>
  )
}

export default page