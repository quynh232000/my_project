'use client'
import Image from 'next/image'
import React, { useEffect, useState } from 'react'
import { FaBed, FaCheck, FaRegClock, FaStar } from 'react-icons/fa6'
import { FaRegUserCircle, FaUserFriends } from "react-icons/fa";
import Link from 'next/link';
import { Button, Checkbox } from '@material-tailwind/react';
import PaymentMethod from './PaymentMethod';
import { IoEyeOutline, IoFlashOutline } from 'react-icons/io5';
import { GiHotMeal } from "react-icons/gi";
import { CiMoneyCheck1 } from 'react-icons/ci';
import { IoMdCheckmark } from 'react-icons/io';
import { FormatPrice, formatVietnameseDate, startCountdown } from '@/utils/common';
import { TbPigMoney } from "react-icons/tb";
import { toast } from 'sonner';
import { IBookingInfo, SGetBookingInfo } from '@/services/app/home/SGetBookingInfo';
import SkeBooking from './../../../../../components/shared/Skeleton/SkeBooking';
import { format } from 'date-fns/esm';


function Container({token}:{token:string}) {
  const [timeLeft, setTimeLeft] = useState({
    time:'',
    status:'pending'
  });
  const [data,setData] = useState<IBookingInfo|null>(null)
  const [loading,setLoading] = useState(true)
  useEffect(()=>{
    setLoading(true)
    if(token){
      SGetBookingInfo(token).then(res=>{
        setLoading(false)
        if(res){
          setData(res)
            startCountdown(res.time_left, (time) => {
             setTimeLeft({
               time,
              status:'success'
             })
          }, () => {
              setTimeLeft({
               time:'',
              status:'done'
             })
          });
        }else{
          toast.error('Dữ liệu không hợp lệ. Vui lòng thử lại!')
        }
      })
    }
  },[token])
  return (
    <>
    {loading ? <SkeBooking/>:
    <div className='bg-gray-50'>
      {timeLeft.status != 'pending' &&
        <div className={'flex justify-center items-center gap-2  py-2 text-[14px] '+(timeLeft.status == 'done' ? ' bg-red-500/80 text-white' :'bg-yellow-500') }>
          <FaRegClock />
          {timeLeft.status == 'done' ? <span>Đã hết thời gian đặt phòng</span>: <span>Thời gian hoàn tất đặt phòng</span>}
          
          <span className='w-[46px] '>{timeLeft.time}</span>
        </div>
        }
        <div className='w-content m-auto flex gap-8 py-8 '>
            <div className='w-[60%]  flex flex-col gap-3'>
            
                <div className='bg-white border shadow-md rounded-lg p-5 flex flex-col gap-3'>
                  <Link href={'/khach-san/'+data?.hotel.slug+`?date_start=${data?.depart_date}&date_end=${data?.return_date}&quantity=${data?.quantity}&adt=${data?.adt}&chd=${data?.chd}`} className='flex gap-3 border-b pb-3'>
                    <div className=' relative w-[80px] h-[80px] rounded-lg'>
                      <Image
                        fill
                        alt=''
                        className='w-full h-full object-cover rounded-lg'
                        src={data?.hotel?.image ??'/images/common/hotel_1.jpg'}
                      />
                    </div>
                    <div className='flex-1 flex flex-col gap-1'>
                      <div className='font-semibold'>
                       {data?.hotel?.name ?? ' Vinpearl Resort Nha Trang'}
                      </div>
                      <div className='flex gap-3'>
                        <div className='flex items-center gap-1  text-sm text-yellow-500'>
                          <FaStar/>
                          {Array.from({ length: data?.hotel.stars ? +data?.hotel.stars : 1 }, (_, index) => <span key={index}><FaStar size={14} className="text-yellow-500"/></span> )}
                        </div>
                        <span className='text-sm border border-primary-500 text-primary-500 px-1 rounded-md'>{data?.hotel.accommodation.name ?? ''}</span>
                      </div>
                       <span className="text-[14px] mt-1 line-clamp-1">{`${data?.hotel?.location?.ward_name}, ${data?.hotel?.location?.province_name}, ${data?.hotel?.location?.country_name}` }</span>
                    </div>
                  </Link>
                  <div className=' grid grid-cols-3 gap-5'>
                    <div>
                      <div className='text-[14px] font-semibold'>Nhận phòng</div>
                      <span className='text-[14px]'>{data?.hotel.time_checkin ?? '14:00'}, {formatVietnameseDate(data?.depart_date ?? '')}</span>
                    </div>
                    <div>
                      <div className='text-[14px] font-semibold'>Trả phòng</div>
                      <span className='text-[14px]'>{data?.hotel.time_checkout ?? '12:00'}, {formatVietnameseDate(data?.return_date ?? '')}</span>
                    </div>
                    <div>
                      <div className='text-[14px] font-semibold'>Số đêm</div>
                      <span className='text-[14px]'>{data?.duration ?? 1}</span>
                    </div>
                  </div>
                  <div>
                    <div className='text-[14px] font-semibold'>Số phòng</div>
                    <span className='text-[14px]'>
                      <span className='text-primary-500'>{data?.quantity ?? 1} x </span>
                      <span className=' uppercase'>{data?.room.name ?? ''}</span>
                    </span>
                  </div>
                  <div>
                    <div className='text-[14px] font-semibold'>Đủ chỗ ngủ cho</div>
                    <span className='text-[14px]'>
                      <span>{data?.room.standard_guests ?? 2} người lớn</span>
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
                      src={ data?.room?.images[0]?.image ??"/images/common/hotel_1.jpg"}
                    />
                    {/* <div className=' absolute top-0 left-0 bg-primary-500 text-white rounded-tl-lg px-1 rounded-br-lg py-1 font-semibold'>Giảm giá 25%</div> */}
                </div>
                <div className='font-semibold uppercase '>{data?.room.name ??'DELUXE QUEEN BED'}</div>
                <div className='text-[14px]'>
                  <div className='flex items-center gap-2'>
                    <FaUserFriends />
                    {data?.room.standard_guests ??2} người
                  </div>
                  <ul className='pl-8 text-gray-600 list-disc '>
                      <li>Sức chứa tối đa của phòng  {data?.room.max_capacity ??2}</li>
                      <li>Số khách tiêu chuẩn  {data?.room.standard_guests ??2}</li>
                      <li>Cho phép ở thêm  {data?.room.max_extra_adults ??2} người lớn,  {data?.room.max_extra_children ??2} trẻ em thỏa mãn  {data?.room.max_capacity ??2} khách tối đa có thể mất thêm phí.</li>
                  </ul>
                  <div className='flex items-center gap-2'>
                    <IoEyeOutline  />
                     {data?.room.direction.name ??2}
                  </div>
                  <div className='flex items-center gap-2'>
                    <FaBed  />
                     {data?.room.bed_quantity ??2}  {data?.room.bed_type.name ??2}
                  </div>
                  {data?.hotel.policy_cancellations && 
                  <div className='flex items-center gap-2'>
                    <CiMoneyCheck1   />
                    Hoàn huỷ một phần
                  </div>}
                  <div className='flex items-center gap-2 text-green-500'>
                    <GiHotMeal   />
                    Giá {data?.room.breakfast ?  'đã' :'chưa'} bao gồm bữa sáng
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
                      {/* <div className='bg-primary-500 text-white rounded-md py-[1px] px-1 text-[14px] font-semibold'>-23%</div> */}
                      <del className='text-sm text-gray-600'>{FormatPrice(data?.total_price??0)}</del>
                    </div>
                    <div className='flex justify-between'>
                      <div>
                        Giá cho {data?.duration} đêm x {data?.quantity} phòng
                      </div>
                      <div>
                        {FormatPrice((data?.total_price??0) - (data?.total_discount??0) )}
                      </div>
                    </div>
                    <div className='bg-primary-50 p-2 rounded-md my-2 flex flex-col gap-1'>
                      {data?.daily_prices.map((item,index)=>{
                        return <div key={index} className='flex justify-between'>
                        <div>
                          Đêm {index+1} ({format(new Date(item.date), 'dd/MM')}) x {data.quantity} phòng
                        </div>
                        <div>
                          {FormatPrice(item.price)} x {data.quantity}
                        </div>
                      </div>
                      })}
                      
                     
                    </div>

                    <div className='flex justify-between items-center'>
                      <div>
                        Mã giảm giá <span className='border border-gray-400 px-1 py-[1px] rounded-md'>QUINBOOKING</span>
                      </div>
                      <div className='text-green-500'>
                        -{FormatPrice(data?.total_discount??0)}
                      </div>
                    </div>
                    <div className='flex justify-between items-center font-semibold mt-2'>
                      <div>
                        Giá sau giảm giá
                      </div>
                      <div className=''>
                        {FormatPrice((data?.total_price ?? 0) - (data?.total_discount??0))}
                      </div>
                    </div>
                    <div className='flex justify-between items-center  py-2 border-t border-b my-2'>
                      <div>
                        Thuế và phí dịch vụ khách sạn
                      </div>
                      <div className=''>
                        {FormatPrice(0)}
                      </div>
                    </div>

                    <div className='flex justify-between text-lg items-center font-semibold mt-2'>
                      <div>
                        Tổng tiền
                      </div>
                      <div className=''>
                        {FormatPrice(data?.final_money ?? 0)}
                      </div>
                    </div>
                    <div className='text-sm mt-2'>
                      (Giá đã bao gồm: Thuế và phí dịch vụ khách sạn 0 ₫)
                      Giá cho {data?.duration} đêm, {data?.adt} người lớn {data?.chd && data.chd > 0 ? `,${data.chd} trẻ em`:''}
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
                        <span className='font-bold'>{FormatPrice(data?.total_discount ?? 0)}</span>
                      </div>
                    </div>
                </div>
                </div>
              </div>
            </div>
        </div>
    </div>}
    </>
  )
}

export default Container