'use client'
import Image from 'next/image'
import React from 'react'
import { FaCheck, FaRegClock, FaStar } from 'react-icons/fa6'
import { FaRegUserCircle } from "react-icons/fa";
import Link from 'next/link';
import { Button, Checkbox } from '@material-tailwind/react';
import PaymentMethod from './PaymentMethod';
function Container() {
  return (
    <div className='bg-gray-50'>
        <div className='flex justify-center items-center gap-2 bg-yellow-500 py-2 text-[14px]'>
          <FaRegClock />
          <span>Thời gian hoàn tất đặt phòng</span>
          <span className='w-[46px] '>13:55</span>
        </div>
        <div className='w-content m-auto flex gap-8 py-8'>
            <div className='w-[60%]  flex flex-col gap-3'>
            
                <div className='bg-white border shadow-md rounded-lg p-5 flex flex-col gap-3'>
                  <div className='flex gap-3 border-b pb-3'>
                    <div className=' relative w-[80px] h-[80px] rounded-lg'>
                      <Image
                        fill
                        alt=''
                        className='w-full h-full object-cover rounded-lg'
                        src={'/images/common/hotel_1.jpg'}
                      />
                    </div>
                    <div className='flex-1 flex flex-col gap-1'>
                      <div className='font-semibold'>
                        Vinpearl Resort Nha Trang
                      </div>
                      <div className='flex gap-3'>
                        <div className='flex items-center gap-1  text-sm text-yellow-500'>
                          <FaStar/>
                          <FaStar/>
                          <FaStar/>
                          <FaStar/>
                          <FaStar/>
                        </div>
                        <span className='text-sm border border-primary-500 text-primary-500 px-1 rounded-md'>Khách sạn</span>
                      </div>
                      <div className='text-[14px] mt-1'>Đảo Hòn Tre, Thành Phố Nha Trang, Khánh Hòa, Việt Nam</div>
                    </div>
                  </div>
                  <div className=' grid grid-cols-3 gap-5'>
                    <div>
                      <div className='text-[14px] font-semibold'>Nhận phòng</div>
                      <span className='text-[14px]'>14:00, T4, 16 tháng 7</span>
                    </div>
                    <div>
                      <div className='text-[14px] font-semibold'>Trả phòng</div>
                      <span className='text-[14px]'>14:00, T4, 16 tháng 7</span>
                    </div>
                    <div>
                      <div className='text-[14px] font-semibold'>Số đêm</div>
                      <span className='text-[14px]'>01</span>
                    </div>
                  </div>
                  <div>
                    <div className='text-[14px] font-semibold'>Số phòng</div>
                    <span className='text-[14px]'>
                      <span className='text-primary-500'>1 x </span>
                      <span>DELUXE QUEEN BED</span>
                    </span>
                  </div>
                  <div>
                    <div className='text-[14px] font-semibold'>Đủ chỗ ngủ cho</div>
                    <span className='text-[14px]'>
                      <span>2 người lớn</span>
                    </span>
                  </div>
                  
                </div>
                <div className='bg-white border shadow-md rounded-lg p-5 flex flex-col gap-3'>
                  <div className='font-semibold text-lg'>Thông tin liên hệ</div>
                  <div>
                    <Link href={'#'} className='flex items-center gap-3 bg-primary-100 p-2 rounded-lg text-[14px]'>
                      <FaRegUserCircle className='text-xl text-primary-500' />
                      <div className='flex-1 flex flex-wrap'>
                        <span className='text-primary-500'>Đăng nhập <span className='text-black'>để lưu lịch sử thông tin đặt phòng của bạn <span className='text-yellow-500'>nhận hoàn tiền 33.902 ₫ vào QuinBooking Cash</span></span></span>
                      </div>
                    </Link>
                  </div>
                  <div className='flex flex-col gap-5'>
                    <div>
                      <label htmlFor="" className='text-[14px]'>Họ và tên</label>
                      <div className='mt-1'>
                        <input type="text" className='border w-full p-2 rounded-lg border-gray-400 shadow-sm focus:outline-none' placeholder='Aa..' />
                      </div>
                    </div>
                    <div className=' grid grid-cols-2 gap-5'>
                        <div>
                          <label htmlFor="" className='text-[14px]'>Email</label>
                          <div className='mt-1'>
                            <input type="text" className='border w-full p-2 rounded-lg border-gray-400 shadow-sm focus:outline-none' placeholder='Aa..' />
                          </div>
                        </div>
                        <div>
                          <label htmlFor="" className='text-[14px]'>Số điện thoại</label>
                          <div className='mt-1'>
                            <input type="text" className='border w-full p-2 rounded-lg border-gray-400 shadow-sm focus:outline-none' placeholder='Aa..' />
                          </div>
                        </div>
                    </div>
                  </div>
                  <div>
                    <div className='flex items-center gap-1'>
                      <Checkbox {...({} as any)} color='purple' className='border-green-400 bg-gray-50'/>
                      <label htmlFor="">Tôi đặt phòng giúp cho người khác.</label>
                    </div>
                    <div>
                      <div className='font-semibold my-2'>Thông tin khách nhận phòng</div>

                      <div className=' grid grid-cols-2 gap-5'>
                        <div>
                          <label htmlFor="" className='text-[14px]'>Họ tên</label>
                          <div className='mt-1'>
                            <input type="text" className='border w-full p-2 rounded-lg border-gray-400 shadow-sm focus:outline-none' placeholder='Aa..' />
                          </div>
                        </div>
                        <div>
                          <label htmlFor="" className='text-[14px]'>Số điện thoại</label>
                          <div className='mt-1'>
                            <input type="text" className='border w-full p-2 rounded-lg border-gray-400 shadow-sm focus:outline-none' placeholder='Aa..' />
                          </div>
                        </div>
                    </div>
                    </div>
                  </div>
                </div>
                {/* yeu cau dac biet */}
                <div className='bg-white border shadow-md rounded-lg p-5 flex flex-col gap-3'>
                  <div className='font-semibold text-lg'>Yêu cầu đặc biệt</div>
                  <div className=' bg-yellow-50 text-orange-500 p-2 rounded-lg text-[14px]'>
                    Lưu ý: Các yêu cầu của bạn chỉ được đáp ứng tuỳ tình trạng phòng của khách sạn.
                  </div>
                  <div className=' grid grid-cols-2 gap-4'>
                    <div className='flex items-center gap-1'>
                      <Checkbox {...({} as any)} color='purple' className='border-gray-400' />
                      <label htmlFor="" className='text-[14px] font-semibold'>Phòng không hút thuốc</label>
                    </div>
                    <div className='flex items-center gap-1'>
                      <Checkbox {...({} as any)} color='purple' className='border-gray-400' />
                      <label htmlFor="" className='text-[14px] font-semibold'>Tầng lầu</label>
                    </div>
                    <div className='flex items-center gap-1'>
                      <Checkbox {...({} as any)} color='purple' className='border-gray-400' />
                      <label htmlFor="" className='text-[14px] font-semibold'>Khác</label>
                    </div>
                  </div>
                  <div className='pl-8'>
                    <textarea name="" className='border border-gray-400 w-full rounded-lg p-2 outline-none' rows={3} placeholder='Aa..' id=""></textarea>
                  </div>
                </div>
                {/* hoa don */}
                <div className='bg-white border shadow-md rounded-lg p-5 flex flex-col gap-3'>
                  <div className='font-semibold text-lg'>Xuất hoá đơn</div>
                  <div className=' bg-green-50 text-green-500 p-2 rounded-lg text-[14px] flex flex-col gap-2'>
                   <div className='flex gap-2 items-center'><FaCheck /> <span className='flex-1'>Bạn muốn xuất hoá đơn, để QuinBooking hỗ trợ! Tiết kiệm thời gian, xuất hoá đơn nhanh chóng, đừng lãng phí thời gian cho kỳ nghỉ của bạn, hãy tận hưởng.</span></div>
                   <div className='flex gap-2 items-center'><FaCheck /> <span className='flex-1'>QuinBooking đảm bảo xuất hóa đơn.</span></div>
                  </div>
                  <div className='text-[14px]'>Khi cần xuất hoá đơn GTGT, Quý khách vui lòng gửi yêu cầu đến QuinBooking kể từ thời điểm nhận mail đến trước
                     14h00 ngày trả phòng. Sau thời gian trên, QuinBooking không thể hỗ trợ điều chỉnh hoặc thay thế hoá đơn.</div>
                  <div className='flex flex-col gap-5'>
                    <div>
                      <label htmlFor="" className='text-[14px]'>Tên công ty</label>
                      <div className='mt-1'>
                        <input type="text" className='border w-full p-2 rounded-lg border-gray-400 shadow-sm focus:outline-none' placeholder='Aa..' />
                      </div>
                    </div>
                    <div className=' grid grid-cols-2 gap-5'>
                        <div>
                          <label htmlFor="" className='text-[14px]'>Mã số thuế</label>
                          <div className='mt-1'>
                            <input type="text" className='border w-full p-2 rounded-lg border-gray-400 shadow-sm focus:outline-none' placeholder='Aa..' />
                          </div>
                        </div>
                        <div>
                          <label htmlFor="" className='text-[14px]'>Địa chỉ</label>
                          <div className='mt-1'>
                            <input type="text" className='border w-full p-2 rounded-lg border-gray-400 shadow-sm focus:outline-none' placeholder='Aa..' />
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                {/* payment */}
                 <div className='bg-white border shadow-md rounded-lg p-5 flex flex-col gap-3'>
                  <div className='font-semibold text-lg'>Phương thức thanh toán</div>
                  <div className='  text-green-500  rounded-lg text-[14px] '>
                      Sau khi hoàn tất thanh toán, mã xác nhận phòng sẽ được gửi ngay qua SMS và Email của bạn.
                  </div>
                  <div>
                    <PaymentMethod/>
                  </div>
                  <div className='flex justify-end mt-3'>
                    <Button {...({} as any)} className='bg-primary-500 px-8 font-semibold normal-case text-md'>Thanh toán</Button>
                  </div>
                  <div className='text-right text-[14px] text-gray-600'>
                    <div>Bằng cách nhấn vào nút này, bạn công nhận mình đã đọc và đồng ý với</div>
                    <div>
                      <span className='text-secondary-500'>Điều kiện và Điều khoản </span>của chúng tôi
                    </div>
                  </div>
                </div>
            </div>
            <div className='flex-1 flex flex-col gap-3'>
              <div className='bg-white border shadow-md rounded-lg p-5 flex flex-col gap-3'>
                <div className='font-semibold text-lg'>Thông tin phòng</div>
                <div className=" relative w-full h-[114px] rounded-lg">
                    <Image
                      alt=""
                      fill
                      className=" object-cover w-full h-full rounded-lg"
                      src={"/images/common/hotel_1.jpg"}
                    />
                </div>
                <div className='font-semibold'>DELUXE QUEEN BED</div>
              </div>
            </div>
        </div>
    </div>
  )
}

export default Container