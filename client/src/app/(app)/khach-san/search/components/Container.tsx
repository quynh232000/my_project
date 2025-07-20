'use client';
import SearchHead from '@/app/components1/SearchHead'
import Link from 'next/link';
import React from 'react'
import SideBar from './SideBar';
import ListHotel from './ListHotel';

function Container() {
  return (
    <div className='w-content m-auto flex flex-col gap-6 py-10'>
        <div>
            <SearchHead navActiveKey='khach-san' className="border rounded-lg shadow-lg"/>
        </div>
        <div className='flex gap-1 text-[14px] text-gray-600'>
            <Link href={'/khach-san'}>Khách sạn</Link>
            <div>/</div>
            <Link href={'/khach-san'}>Hồ Chí Minh</Link>
        </div>
        <h2 className='text-xl font-semibold'>109 Khách sạn tại Hồ Chí Minh</h2>
        <div className='flex gap-8'>
            <div className='w-[30%]'>
                <SideBar/>
            </div>
            <div className='flex-1 flex flex-col gap-5'>
                <div className='flex items-center gap-2 border shadow-md w-full px-4 py-2 rounded-md bg-white'>
                    <span>Sắp xếp:</span>
                    <div className='flex gap-2 text-[14px] font-semibold'>
                        <div className='text-white bg-primary-500 py-2 px-3 rounded-lg hover:bg-primary-600 cursor-pointer'>Phù hợp nhất</div>
                        <div className='hover:text-white  py-2 px-3 rounded-lg hover:bg-primary-600 cursor-pointer'>Phù hợp nhất</div>
                        <div className='hover:text-white  py-2 px-3 rounded-lg hover:bg-primary-600 cursor-pointer'>Phù hợp nhất</div>
                    </div>
                </div>
                <ListHotel/>
            </div>
        </div>
    </div>
  )
}

export default Container