import React from 'react'

function SkeSideBar() {
  return (
    <div className='p-4 border-b animate-pulse w-full'>
        <div className='h-4 w-[40%] bg-gray-300 rounded mb-3 '></div>
        <div className='space-y-2 w-full pl-3'>
            {Array.from({ length: 5 }).map((_, index) => (
            <div className='flex items-center gap-2' key={index}>
                <div className='w-4 h-4 bg-gray-300 rounded'></div>
                <div className='h-4 w-[60%] bg-gray-300 rounded'></div>
            </div>
            ))}
        </div>
    </div>
  )
}

export default SkeSideBar