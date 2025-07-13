'use client'
import SearchHead from '@/app/components/SearchHead'
import { FormatPrice } from '@/utils/common';
import Link from 'next/link'
import React from 'react'
import { CiHeart } from "react-icons/ci";
import { FaLocationDot, FaRegShareFromSquare, FaStar, FaUmbrella } from 'react-icons/fa6';
import Images from './Images';
function Container() {
  return (
    <div className='w-content m-auto flex flex-col gap-8 py-10'>
        <div>
            <SearchHead navActiveKey='khach-san' className="border rounded-lg shadow-lg"/>
        </div>
        <div className='flex gap-1 text-[14px] text-gray-600'>
            <Link href={'/khach-san'}>Khách sạn</Link>
            <div>/</div>
            <Link href={'/khach-san'}>Hồ Chí Minh</Link>
             <div>/</div>
            <Link href={'/khach-san'}>Quận 1</Link>
             <div>/</div>
            <Link href={'/khach-san'}>Khách sạn Mường Thanh Grand Sài Gòn Centre</Link>
        </div>
        <div className='flex flex-col gap-2'>
            <div className='flex justify-between'>
              <h1 className='font-bold text-2xl'>Khách sạn Mường Thanh Grand Sài Gòn Centre</h1>
              <div className='flex gap-5 items-center text-lg'>
                <div className='flex gap-2 items-center'>
                  <span>Lưu</span>
                  <CiHeart className='text-2xl' />
                </div>
                <div className='flex gap-2 items-center'>
                  <span>Chia sẻ</span>
                  <FaRegShareFromSquare className='text-xl'/>
                </div>
              </div>
            </div>
            <div className='flex gap-1 text-yellow-500 text-[14px] '>
              <FaStar/>
              <FaStar/>
              <FaStar/>
              <FaStar/>
              <FaStar/>
            </div>
            <div className='flex justify-between items-center gap-4'>
              <div className='flex flex-col gap-2'>
                <div className='flex gap-2 items-center'>
                  <div className='flex items-center text-primary-500 text[14px] font-semibold bg-primary-50 gap-1 px-1 py-[1px] rounded-lg'>
                    <FaUmbrella/>
                    <span>8.6</span>
                  </div>
                  <div className='text-gray-600'> Rất tốt <span className='text-gray-600 text-[14px]'>(678 đánh giá)</span></div>
                  <div className='text-secondary-500 text-[14px]'>Xem đánh giá</div>
                </div>
                <div className='flex gap-2 items-center text-gray-600'>
                  <div className='flex items-center gap-1'>
                    <FaLocationDot/>
                    <span>Số 1a, Mạc Đĩnh Chi, Quận 1, Hồ Chí Minh, Việt Nam</span>
                  </div>
                 
                  <div className='text-secondary-500 text-[14px]'>Xem bản đồ</div>
                </div>
              </div>
              <div className='flex items-center gap-5'>
                <div className='flex flex-col justify-between'>
                  <div className='flex gap-2 text-right'>
                    <del className='text-gray-600'>{FormatPrice(3125000)}</del>
                    <div className='text-white bg-primary-500 rounded-sm  px-1 py-0 text-[14px] font-semibold'>-27%</div>
                  </div>
                  <div className='text-right font-semibold text-2xl'>{FormatPrice(2890000)}</div>
                </div>
                <div><button className='bg-primary-500 text-white py-3 px-8 rounded-lg hover:bg-primary-600 cursor-pointer'>Chọn phòng</button></div>
              </div>
            </div>
            <div>
              <Images/>
            </div>
        </div>
    </div>
  )
}

export default Container