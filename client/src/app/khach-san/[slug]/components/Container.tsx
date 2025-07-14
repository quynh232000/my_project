'use client'
import SearchHead from '@/app/components/SearchHead'
import { FormatPrice } from '@/utils/common';
import Link from 'next/link'
import React from 'react'
import { CiHeart } from "react-icons/ci";
import { FaAngleRight, FaCar, FaCashRegister, FaClock, FaFaceKissWinkHeart, FaLocationDot, FaRegShareFromSquare, FaStar, FaUmbrella, FaWifi } from 'react-icons/fa6';
import Images from './Images';
import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import ModelReview from './ModelReview';
import ModelService from './ModelService';
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
            <div className=' grid grid-cols-3 gap-3'>
              {/* review */}
                <div className='border p-3 bg-white shadow-sm rounded-lg hover:border-primary-300  border-gray-300 transition-all'>
                  <div className='flex justify-between items-center'>
                    <div className='flex gap-2 items-center'>
                      <span className=' text-primary-500 font-semibold bg-primary-100 rounded-md px-2 py-[2px]'>9.6</span>
                      <span className=' font-semibold'>Tuyệt vời</span>
                    </div>
                    <ModelReview/>
                  </div>
                  <div className='bg-gray-50 p-1 mt-2 rounded-sm'>
                      <Swiper
                        modules={[A11y, Autoplay]}
                        spaceBetween={0}
                        slidesPerView={1}
                        autoplay={{ delay: 3200, disableOnInteraction: false }}
                      >
                        {Array.from({length:5},(_,index)=>{
                          return (
                            <SwiperSlide key={index} >
                                <div className='flex flex-col gap-1 cursor-pointer'>
                                  <div className='text-[15px] font-semibold'>Kỳ nghỉ gia đình vui vẻ, thoải mái!</div>
                                  <div className='line-clamp-2 text-[14px] text-gray-600'>
                                      Mình đặt khách sạn Oyster Bay dựa vào điểm đánh giá cao của mọi người, mình đặt một căn hộ hai phòng ngủ hướng biển cho bốn người ở trong ba ngày hai đêm. Trải nghiệm thật tuyệt vời. Cảm ơn, nếu có dịp mình sẽ đặt lại.
                                  </div>
                                </div>
                            </SwiperSlide>
                          );
                        })}
                      </Swiper>
                     
                  </div>
                </div>
                {/* service */}
                <div className='border p-3 bg-white shadow-sm rounded-lg hover:border-primary-300  border-gray-300 transition-all'>
                  <div className='flex justify-between items-center'>
                    <div className='flex gap-2 items-center'>
                      <span className=' font-semibold'>Tiện nghi</span>
                    </div>
                    <ModelService/>
                    
                  </div>
                  <div className=' mt-2 flex flex-wrap gap-2'>
                      <div className='text-[14px] flex items-center gap-1 text-gray-600'><FaCar/> <span className=''>Bãi đỗ xe</span></div>
                      <div className='text-[14px] flex items-center gap-1 text-gray-600'><FaFaceKissWinkHeart/> <span className=''>Phòng Gym</span></div>
                      <div className='text-[14px] flex items-center gap-1 text-gray-600'><FaCashRegister/> <span className=''>Thu đổi ngoại tệ</span></div>
                      <div className='text-[14px] flex items-center gap-1 text-gray-600'><FaClock/> <span className=''>Báo thức</span></div>
                      <div className='text-[14px] flex items-center gap-1 text-gray-600'><FaWifi/> <span className=''>Internet miễn phí</span></div>
                      <div className='text-[14px] flex items-center gap-1 text-gray-600'><FaCar/> <span className=''>Bãi đỗ xe</span></div>
                      <div className='text-[14px] flex items-center gap-1 text-gray-600'><FaUmbrella/> <span className=''>Báo thức</span></div>

                     
                  </div>
                </div>
                {/* location */}
                <div className='bg-[url("/images/common/bg_map.png")] border p-3 bg-white shadow-sm rounded-lg hover:border-primary-300  border-gray-300 transition-all'>
                  <div className='flex justify-between items-center'>
                    <div className='flex gap-2 items-center'>
                     
                      <span className=' font-semibold'>Vị trí Tuyệt vời: 9.4</span>
                    </div>
                    <div className='flex items-center gap-1 text-secondary-500 text-[14px] cursor-pointer hover:text-secondary-600'>
                      Xem bản đồ <FaAngleRight/>
                    </div>
                  </div>
                  <div className=' mt-2'>
                      <div className='text-[14px] font-semibold'>Vị trí quanh đây có gì:</div>
                      <div>
                        <div className='text-[14px]'>
                          Địa điểm du lịch: Hồ mây Amunsement Park <span className='text-gray-500'>(670m)</span>
                        </div>
                        <div className='text-[14px]'>
                         Nhà hàng: Beach Stop   <span className='text-gray-500'>(441m)</span>
                        </div>
                        <div className='text-[14px]'>
                          Nhà hàng: Coffee and eggs Thao Nguyen   <span className='text-gray-500'>(550m)</span>
                        </div>
                      </div>
                  </div>
                </div>

            </div>
        </div>
    </div>
  )
}

export default Container