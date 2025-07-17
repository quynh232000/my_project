'use client'
import Image from 'next/image'
import React from 'react'
import { FaBed, FaCheck, FaRegClock, FaStar } from 'react-icons/fa6'
import { FaRegUserCircle, FaUserFriends } from "react-icons/fa";
import Link from 'next/link';
import { Button, Checkbox } from '@material-tailwind/react';
import PaymentMethod from './PaymentMethod';
import { IoEyeOutline, IoFlashOutline } from 'react-icons/io5';
import { GiHotMeal } from "react-icons/gi";
import { CiMoneyCheck1 } from 'react-icons/ci';
import { IoMdCheckmark } from 'react-icons/io';
import { FormatPrice } from '@/utils/common';
import { TbPigMoney } from "react-icons/tb";


function Container() {
  return (
    <div className='bg-gray-50'>
        <div className='flex justify-center items-center gap-2 bg-yellow-500 py-2 text-[14px]'>
          <FaRegClock />
          <span>Thời gian hoàn tất đặt phòng</span>
          <span className='w-[46px] '>13:55</span>
        </div>
        <div className='w-content m-auto flex gap-8 py-8 '>
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
            <div className='flex-1 flex flex-col gap-3  sticky top-0 '>
              <div className='bg-white border shadow-md rounded-lg p-5 flex flex-col gap-3'>
                <div className='font-semibold text-lg'>Thông tin phòng</div>
                <div className=" relative w-full h-[114px] rounded-lg">
                    <Image
                      alt=""
                      fill
                      className=" object-cover w-full h-full rounded-lg"
                      src={"/images/common/hotel_1.jpg"}
                    />
                    <div className=' absolute top-0 left-0 bg-primary-500 text-white rounded-tl-lg px-1 rounded-br-lg py-1 font-semibold'>Giảm giá 25%</div>
                </div>
                <div className='font-semibold'>DELUXE QUEEN BED</div>
                <div className='text-[14px]'>
                  <div className='flex items-center gap-2'>
                    <FaUserFriends />
                    2 người
                  </div>
                  <ul className='pl-8 text-gray-600 list-disc '>
                      <li>Sức chứa tối đa của phòng 4</li>
                      <li>Số khách tiêu chuẩn</li>
                      <li>Cho phép ở thêm 1 người lớn, 2 trẻ em thỏa mãn 4 khách tối đa có thể mất thêm phí.</li>
                  </ul>
                  <div className='flex items-center gap-2'>
                    <IoEyeOutline  />
                    Hướng Vườn
                  </div>
                  <div className='flex items-center gap-2'>
                    <FaBed  />
                    1 Giường King
                  </div>
                  <div className='flex items-center gap-2'>
                    <CiMoneyCheck1   />
                    Hoàn huỷ một phần
                  </div>
                  <div className='flex items-center gap-2 text-green-500'>
                    <GiHotMeal   />
                    Giá đã bao gồm bữa sáng
                  </div>
                  <div className='flex items-center gap-2 text-orange-500'>
                    <IoFlashOutline    />
                   Xác nhận trong 15 phút
                  </div>
                  <div className='border-l-2  border-green-500 bg-green-50 p-2 my-2 px-3'>
                    <div className='font-semibold'>Ưu đãi bao gồm</div>
                    <div className='flex flex-col gap-1 mt-2 text-gray-600'>
                      <div className='flex gap-2'>
                        <IoMdCheckmark className='text-green-500 mt-1'/><div className='flex-1'>Miễn phí minibar gồm nước suối, nước ngọt, bia, được bổ sung hàng ngày</div>
                      </div>
                      <div className='flex gap-2'>
                        <IoMdCheckmark className='text-green-500 mt-1'/><div className='flex-1'>Miễn phí sử dụng hồ bơi vô cực và bể sục Jacuzzi tại tầng 22 của khách sạn</div>
                      </div>
                      <div className='flex gap-2'>
                        <IoMdCheckmark className='text-green-500 mt-1'/><div className='flex-1'>Miễn phí sử dụng hồ bơi trẻ em, hồ bơi Phú Sĩ, Khu vui chơi trẻ em, bãi biển (không tổ chức sự kiện)</div>
                      </div>
                      <div className='flex gap-2'>
                        <IoMdCheckmark className='text-green-500 mt-1'/><div className='flex-1'>Miễn phí xe điện đưa đón khi di chuyển trong khu nghỉ dưỡng</div>
                      </div>
                      <div className='flex gap-2'>
                        <IoMdCheckmark className='text-green-500 mt-1'/><div className='flex-1'>Thưởng thức chương trình nhạc nước hàng ngày theo khung giờ của khách sạn, ngắm cảnh tại khu vườn Nhật</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {/* price */}
              <div className='bg-white border shadow-md rounded-lg p-5 flex flex-col gap-3'>
                <div className='font-semibold text-lg'>Chi tiết giá</div>
                <div>
                  <div className='   text-[14px] w-[380px] bg-white'>
                    <div className='flex justify-end items-center gap-2'>
                      <div className='bg-primary-500 text-white rounded-md py-[1px] px-1 text-[14px] font-semibold'>-23%</div>
                      <del className='text-sm text-gray-600'>{FormatPrice(1240000)}</del>
                    </div>
                    <div className='flex justify-between'>
                      <div>
                        Giá cho 2 đêm x 1 phòng
                      </div>
                      <div>
                        {FormatPrice(1240000)}
                      </div>
                    </div>
                    <div className='bg-primary-50 p-2 rounded-md my-2 flex flex-col gap-1'>
                      <div className='flex justify-between'>
                        <div>
                          Đêm 1 (15/7) x 1 phòng
                        </div>
                        <div>
                          {FormatPrice(1240000)} x 1
                        </div>
                      </div>
                      <div className='flex justify-between'>
                        <div>
                          Đêm 2 (15/7) x 1 phòng
                        </div>
                        <div>
                          {FormatPrice(1240000)} x 1
                        </div>
                      </div>
                        <div className='flex justify-between'>
                        <div>
                          Đêm 3 (15/7) x 1 phòng
                        </div>
                        <div>
                          {FormatPrice(1240000)} x 1
                        </div>
                      </div>
                    </div>

                    <div className='flex justify-between items-center'>
                      <div>
                        Mã giảm giá <span className='border border-gray-400 px-1 py-[1px] rounded-md'>QUINBOOKING</span>
                      </div>
                      <div className='text-green-500'>
                        -{FormatPrice(1240000)}
                      </div>
                    </div>
                    <div className='flex justify-between items-center font-semibold mt-2'>
                      <div>
                        Giá sau giảm giá
                      </div>
                      <div className=''>
                        {FormatPrice(1240000)}
                      </div>
                    </div>
                    <div className='flex justify-between items-center  py-2 border-t border-b my-2'>
                      <div>
                        Thuế và phí dịch vụ khách sạn
                      </div>
                      <div className=''>
                        {FormatPrice(1240000)}
                      </div>
                    </div>

                    <div className='flex justify-between text-lg items-center font-semibold mt-2'>
                      <div>
                        Tổng tiền
                      </div>
                      <div className=''>
                        {FormatPrice(1240000)}
                      </div>
                    </div>
                    <div className='text-sm mt-2'>
                      (Giá đã bao gồm: Thuế và phí dịch vụ khách sạn 416.390 ₫)
                      Giá cho 2 đêm, 2 người lớn
                    </div>

                    <div className='flex justify-between  items-center font-semibold mt-2 text-lg'>
                      <div>
                       Giá thực trả sau Cashback
                      </div>
                      <div className=''>
                        {FormatPrice(1140000)}
                      </div>
                    </div>

                    <div className='flex mt-2 items-center gap-2 bg-primary-50 text-primary-500 p-2 rounded-lg font-semibold'>
                      <TbPigMoney />
                      <div className='flex gap-2'>
                        Chúc mừng! Bạn đã tiết kiệm được
                        <span className='font-bold'>{FormatPrice(560000)}</span>
                      </div>
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