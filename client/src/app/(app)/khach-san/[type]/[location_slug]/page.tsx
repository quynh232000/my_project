import React from 'react'
import Container from './components/Container'

export default async function Page({ params }: { params:Promise< { type: string; location_slug: string }> }) {
  const { type, location_slug } =await params;
  
  return (
    <div className='mt-[148px] bg-gray-50'>
      <Container type={type} slug={location_slug} />
    </div>
  )
}