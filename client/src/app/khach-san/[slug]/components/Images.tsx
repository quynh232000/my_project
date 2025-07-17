import Image from 'next/image'
import React from 'react'

function Images() {
  return (
    <div className='grid grid-cols-2 gap-1 rounded-lg overflow-hidden my-4'>
        <div className=' relative w-full h-[340px]  overflow-hidden cursor-pointer'>
            <Image
                alt=''
                fill
                className=' object-cover w-full h-full'
                src={'/images/common/hotel_11.jpg'}
            />
        </div>
        <div className=' grid grid-cols-2 gap-1'>
            <div className=' relative w-full h-[168px]  cursor-pointer'>
                <Image
                    alt=''
                    fill
                    className=' object-cover w-full h-full'
                    src={'/images/common/hotel_11.jpg'}
                />
            </div>
             <div className=' relative w-full h-[168px]  cursor-pointer'>
                <Image
                    alt=''
                    fill
                    className=' object-cover w-full h-full'
                    src={'/images/common/hotel_11.jpg'}
                />
            </div>
             <div className=' relative w-full h-[168px]  cursor-pointer'>
                <Image
                    alt=''
                    fill
                    className=' object-cover w-full h-full'
                    src={'/images/common/hotel_11.jpg'}
                />
            </div>
             <div className=' relative'>
                <div className=' relative w-full h-[168px]  cursor-pointer'>
                    <Image
                        alt=''
                        fill
                        className=' object-cover w-full h-full'
                        src={'/images/common/hotel_11.jpg'}
                    />
                </div>
                <div className='filter brightness-90 cursor-pointer  bg-black/50  text-2xl z-[1] absolute top-0 left-0 right-0 bottom-0 flex justify-center items-center text-white '>
                    +8
                </div>
             </div>
        </div>
    </div>
  )
}

export default Images