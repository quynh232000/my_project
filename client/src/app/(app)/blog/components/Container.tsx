'use client'

import React from 'react'
import Slider from './Slider'
import Image from 'next/image'
import { Button } from '@material-tailwind/react'

function Container() {
  return (
    <div>
        <Slider/>
        <div className='w-content m-auto py-12 flex flex-col gap-12'>
            <div>
              <h2 className='font-bold text-2xl'>Cẩm nang du lịch</h2>
              <div className='grid grid-cols-4 gap-5 mt-5'>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
              </div>
              <div className='flex justify-center mt-8'>
                <Button {...({} as any)} className='border bg-primary-50 border-primary-500 text-primary-500 hover:bg-primary-100 px-12'> Xem thêm</Button>
              </div>
            </div>
            <div>
              <h2 className='font-bold text-2xl'>Cẩm nang du lịch</h2>
              <div className='grid grid-cols-4 gap-5 mt-5'>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
              </div>
              <div className='flex justify-center mt-8'>
                <Button {...({} as any)} className='border bg-primary-50 border-primary-500 text-primary-500 hover:bg-primary-100 px-12'> Xem thêm</Button>
              </div>
            </div>
            <div>
              <h2 className='font-bold text-2xl'>Cẩm nang du lịch</h2>
              <div className='grid grid-cols-4 gap-5 mt-5'>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
                {/* item */}
                <div className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>Thời gian bay từ Đà Nẵng đến Busan mất bao lâu?
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>Thứ 2,03/03/2025</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>Ngân Nguyễn</div>
                    </div>
                </div>
              </div>
              <div className='flex justify-center mt-8'>
                <Button {...({} as any)} className='border bg-primary-50 border-primary-500 text-primary-500 hover:bg-primary-100 px-12'> Xem thêm</Button>
              </div>
            </div>
            
            {/* social */}
            <div className='grid grid-cols-2 gap-5'>
              <div className='border shadow-lg rounded-2xl p-5'>
                <div className='flex justify-between items-center'>
                  <div className=' relative h-[36px] w-[116px] '>
                        <Image
                        fill
                        alt=''
                        src={'/images/icon/tiktok.webp'}
                        className='  w-full h-full'
                        />
                    </div>
                    <div className='flex items-center gap-3'>
                      <div>
                        <div className='font-semibold text-right text-lg'>103,5k</div>
                        <div className='text-[14px] font-semibold'>Người theo dõi</div>
                      </div>
                      <div className='bg-red-500 text-white py-2 px-2 text-[14px] rounded-xl hover:cursor-pointer hover:bg-red-600'>Theo dõi</div>
                    </div>
                </div>
                <div className=' grid grid-cols-3 gap-3 mt-5'>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                </div>
              </div>
              <div className='border shadow-lg rounded-2xl p-5'>
                <div className='flex justify-between items-center'>
                  <div className=' relative h-[36px] w-[126px] '>
                        <Image
                        fill
                        alt=''
                        src={'/images/icon/youtube.webp'}
                        className='  w-full h-full'
                        />
                    </div>
                    <div className='flex items-center gap-3'>
                      <div>
                        <div className='font-semibold text-right text-lg'>103,5k</div>
                        <div className='text-[14px] font-semibold'>Người theo dõi</div>
                      </div>
                      <div className='bg-red-500 text-white py-2 px-2 text-[14px] rounded-xl hover:cursor-pointer hover:bg-red-600'>Theo dõi</div>
                    </div>
                </div>
                <div className=' grid grid-cols-3 gap-3 mt-5'>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  )
}

export default Container