'use client'
import SearchHead from '@/app/(app)/components/SearchHead'
import { FormatPrice } from '@/utils/common';
import Link from 'next/link'
import React from 'react'
import { CiCalendar, CiForkAndKnife, CiHeart } from "react-icons/ci";
import { FaAngleRight, FaBuilding, FaCalendar, FaCar, FaCashRegister, FaCheck, FaCircleDot, FaClock, FaEye, FaFaceKissWinkHeart, FaJenkins, FaLocationDot, FaMoneyBill, FaPlane, FaRegShareFromSquare, FaRestroom, FaStar, FaUmbrella, FaWifi } from 'react-icons/fa6';
import Images from './Images';
import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import ModelReview from './ModelReview';
import ModelService from './ModelService';
import { Button, Checkbox } from '@material-tailwind/react';
import Image from 'next/image';
import { GoInfo } from "react-icons/go";
import { MdOutlinePeople } from 'react-icons/md';
import { IoBed, IoCheckmarkOutline, IoFlashOutline } from "react-icons/io5";
import { BsInfoCircle } from "react-icons/bs";
import ReviewContent from './ReviewContent';


function Container() {
  return (
    <div className='bg-white pb-12'>
      <div className='w-content m-auto  flex flex-col gap-8 py-10 '>
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
      {/* rooms */}
      <div className='bg-gray-50 py-5'>
          <div className='w-content m-auto flex flex-col gap-5'>
            <div className='border bg-white rounded-lg p-5'>
              <div className='font-semibold text-lg'>Những phòng còn trống tại Muong Thanh Grand Da Nang Hotel</div>
              <div className='bg-primary-50 text-primary-500  border-primary-500 border-dashed border font-semibold p-3 px-4 rounded-lg my-2 text-[14px]'>Mã giảm đến 500K chỉ dành cho App. Mở App đặt ngay!</div>
              <div className='p-2'>
                <div className='font-semibold text-md px-3'>
                  Tìm kiếm nhanh hơn bằng cách chọn những tiện nghi bạn cần
                </div>
                <div className='flex flex-wrap gap-8'>
                  <div className='flex items-center'>
                    <Checkbox color='purple' className='bg-white border border-gray-400' {...({} as any)}/>
                    <label htmlFor="" className='text-[14px] '>Miễn phí hủy phòng</label>
                  </div>
                  <div className='flex items-center'>
                    <Checkbox color='purple' className='bg-white border border-gray-400' {...({} as any)}/>
                    <label htmlFor="" className='text-[14px] '>Miễn phí hủy phòng</label>
                  </div>
                  <div className='flex items-center'>
                    <Checkbox color='purple' className='bg-white border border-gray-400' {...({} as any)}/>
                    <label htmlFor="" className='text-[14px] '>Miễn phí hủy phòng</label>
                  </div>
                  <div className='flex items-center'>
                    <Checkbox color='purple' className='bg-white border border-gray-400' {...({} as any)}/>
                    <label htmlFor="" className='text-[14px] '>Miễn phí hủy phòng</label>
                  </div>
                  <div className='flex items-center'>
                    <Checkbox color='purple' className='bg-white border border-gray-400' {...({} as any)}/>
                    <label htmlFor="" className='text-[14px] '>Miễn phí hủy phòng</label>
                  </div>
                </div>
              </div>
            </div>
            <div className='flex flex-col gap-5'>
              {/* room 1 */}
              <div className=' border bg-white rounded-lg border-primary-500 '>
                <div className='flex items-center gap-2 rounded-t-lg bg-primary-500 text-white font-semibold py-2 px-3'>
                  <FaStar/> <span>Được đề xuất</span>
                </div>
                <div className='p-5 gap-5 flex'>
                  <div className='w-[20%]'>
                      <div className='w-full flex flex-col gap-[2px] rounded-lg overflow-hidden'>
                        <div className='w-full relative h-[150px]'>
                          <Image src={'/images/common/hotel_1.jpg'} fill alt='' className='w-full h-full object-cover' />
                        </div>
                        <div className=' grid grid-cols-3 gap-[2px]'>
                          <div className='w-full relative h-[50px]'>
                            <Image src={'/images/common/hotel_1.jpg'} fill alt='' className='w-full h-full object-cover' />
                          </div>
                          <div className='w-full relative h-[50px]'>
                            <Image src={'/images/common/hotel_1.jpg'} fill alt='' className='w-full h-full object-cover' />
                          </div>
                          <div className='w-full relative h-[50px]'>
                            <Image src={'/images/common/hotel_1.jpg'} fill alt='' className='w-full h-full object-cover' />
                          </div>
                        </div>
                      </div>
                      <div className='flex items-center gap-2 text-[14px] text-secondary-500 py-2'>
                        Xem chi tiết phòng <FaAngleRight/>
                      </div>
                      <div className='flex flex-wrap gap-1'>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Điều hòa nhiệt độ</div>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Điện thoại</div>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Không hút thuốc</div>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Tivi màn hình phẳng</div>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Dép đi trong nhà</div>
                        <div className='w-full mt-2'>
                          <div className='flex items-center gap-2 text-[14px] text-secondary-500 bg-secondary-50 w-fit px-2 py-1 rounded-full'>
                            15 tiện ích
                          </div>
                        </div>
                      </div>
                  </div>
                  <div className='flex-1 flex flex-col gap-3'>
                    <div className='flex justify-between items-center'>
                      <div className='flex flex-col gap-2'>
                        <h3 className='font-semibold text-xl'>Phòng Deluxe 1 Giường Lớn Hướng Phố</h3>
                        <div className='flex items-center gap-5 text-[14px] text-gray-600'>
                          <div className='flex items-center gap-1'>
                            <MdOutlinePeople className='text-lg' />
                            <span>2 người</span>
                            <span className='text-secondary-500'>(Xem chi tiết)</span>
                          </div>
                          <div className='flex items-center gap-1'>
                            <CiCalendar className='text-lg'/>
                            <span>30 m²/322 ft²</span>
                          </div>
                          <div className='flex items-center gap-1'>
                            <FaEye className='text-lg'/>
                            <span>Hướng Thành Phố</span>
                          </div>
                        </div>
                      </div>
                      <div>
                        <span className='text-primary-500 text-md'>Vừa được đặt 2 giờ trước</span>
                      </div>
                    </div>
                    <div>
                      {/* item */}
                      <div className='border-t flex'>
                          <div className='w-[50%] border-r pr-3 py-3 flex flex-col gap-3'>
                            <div className='font-semibold'>
                              Lựa chọn 1
                            </div>
                            <div className='text-[14px] flex flex-col gap-2'>
                              <div className='flex items-center gap-2 '>
                                <FaMoneyBill className='text-gray-600'/>
                                <span>Hoàn hủy 1 phần</span>
                                <GoInfo className='text-secondary-500' />
                              </div>
                              <div className='flex items-center gap-2 text-green-500'>
                                <CiForkAndKnife />
                                <span>Giá đã bao gồm bữa sáng</span>
                              </div>
                              <div className='flex items-center gap-2'>
                                <GoInfo />
                                <span>Xem phụ thu người lớn trẻ em</span>
                              </div>
                              <div className='flex items-center gap-2 text-yellow-500'>
                                <IoFlashOutline />
                                <span>Xác nhận trong 30 phút</span>
                              </div>
                              <div className='flex items-center gap-2  text-red-500'>
                                <IoCheckmarkOutline />
                                <span>An tâm đặt phòng, Mytour hỗ trợ xuất hoá đơn nhanh chóng, tiết kiệm thời gian cho bạn.</span>
                              </div>
                            </div>
                            <div className='text-[14px] p-3 border-l-2 border-green-300 bg-green-50'>
                              <div className='font-semibold'>Ưu đãi bao gồm</div>
                              <div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Sử dụng miễn phí hồ bơi, phòng tập thể dục</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Sử dụng miễn phí internet không dây</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Miễn phí trà, cà phê và 02 chai nước suối trong phòng mỗi ngày</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Ăn sáng</span>
                                </div>
                              </div>
                            </div>
                            <div className='flex items-center gap-2 text-secondary-500 text-[14px]'>
                              Xem chi tiết <FaAngleRight />
                            </div>
                          </div>
                          <div className='w-[20%] border-r p-5'>
                            <div className='flex flex-col gap-2 justify-center text-center items-center'>
                              <IoBed className='text-3xl text-gray-500' />
                              <div className='text-[14px]'>1 giường đơn</div>
                            </div>
                          </div>
                          <div className='w-[30%] flex flex-col items-end py-3 text-right'>
                              <div className='flex flex-col items-end'>
                                <div className='bg-primary-500 text-[14px] text-white font-semibold w-fit  py-[1px] rounded-tl-xl rounded-bl-xl px-2'>-23%</div>
                                <div>
                                  <del className='text-gray-600'>{FormatPrice(2270000)}</del>
                                </div>
                                <div className='font-semibold text-xl'>{FormatPrice(1970000)}</div>
                                <div className='text-gray-600'>/ đêm</div>
                              </div>
                              <Link href={'/khach-san/dat-phong?id=4068468469984'} className='py-4'>
                                <Button {...({} as any)}  className=' normal-case text-md bg-primary-500 font-semibold px-8'>Đặt phòng</Button>
                              </Link>
                              <div className=" cursor-pointer relative group">
                                <div className='text-[14px] text-secondary-500 flex items-center gap-2'>Giá cuối cùng {FormatPrice(1240000)} <BsInfoCircle /></div>
                                <div className='text-[14px]'>cho 2 đêm</div>
                                <div className=' hidden z-[999] group-hover:block transition-all border-gray-300 absolute top-[100%] right-0 text-[14px] w-[380px] bg-white border shadow-lg rounded-lg p-2'>
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

                                    <div className='flex justify-between text-[16px] items-center font-semibold mt-2'>
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
                                </div>
                              </div>
                             
                          </div>
                      </div>
                      {/* item */}
                      <div className='border-t flex'>
                          <div className='w-[50%] border-r pr-3 py-3 flex flex-col gap-3'>
                            <div className='font-semibold'>
                              Lựa chọn 1
                            </div>
                            <div className='text-[14px] flex flex-col gap-2'>
                              <div className='flex items-center gap-2 '>
                                <FaMoneyBill className='text-gray-600'/>
                                <span>Hoàn hủy 1 phần</span>
                                <GoInfo className='text-secondary-500' />
                              </div>
                              <div className='flex items-center gap-2 text-green-500'>
                                <CiForkAndKnife />
                                <span>Giá đã bao gồm bữa sáng</span>
                              </div>
                              <div className='flex items-center gap-2'>
                                <GoInfo />
                                <span>Xem phụ thu người lớn trẻ em</span>
                              </div>
                              <div className='flex items-center gap-2 text-yellow-500'>
                                <IoFlashOutline />
                                <span>Xác nhận trong 30 phút</span>
                              </div>
                              <div className='flex items-center gap-2  text-red-500'>
                                <IoCheckmarkOutline />
                                <span>An tâm đặt phòng, Mytour hỗ trợ xuất hoá đơn nhanh chóng, tiết kiệm thời gian cho bạn.</span>
                              </div>
                            </div>
                            <div className='text-[14px] p-3 border-l-2 border-green-300 bg-green-50'>
                              <div className='font-semibold'>Ưu đãi bao gồm</div>
                              <div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Sử dụng miễn phí hồ bơi, phòng tập thể dục</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Sử dụng miễn phí internet không dây</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Miễn phí trà, cà phê và 02 chai nước suối trong phòng mỗi ngày</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Ăn sáng</span>
                                </div>
                              </div>
                            </div>
                            <div className='flex items-center gap-2 text-secondary-500 text-[14px]'>
                              Xem chi tiết <FaAngleRight />
                            </div>
                          </div>
                          <div className='w-[20%] border-r p-5'>
                            <div className='flex flex-col gap-2 justify-center text-center items-center'>
                              <IoBed className='text-3xl text-gray-500' />
                              <div className='text-[14px]'>1 giường đơn</div>
                            </div>
                          </div>
                          <div className='w-[30%] flex flex-col items-end py-3 text-right'>
                              <div className='flex flex-col items-end'>
                                <div className='bg-primary-500 text-[14px] text-white font-semibold w-fit  py-[1px] rounded-tl-xl rounded-bl-xl px-2'>-23%</div>
                                <div>
                                  <del className='text-gray-600'>{FormatPrice(2270000)}</del>
                                </div>
                                <div className='font-semibold text-xl'>{FormatPrice(1970000)}</div>
                                <div className='text-gray-600'>/ đêm</div>
                              </div>
                              <Link href={'/khach-san/dat-phong?id=4068468469984'} className='py-4'>
                                <Button {...({} as any)} className=' normal-case text-md bg-primary-500 font-semibold px-8'>Đặt phòng</Button>
                              </Link>
                              <div className=" cursor-pointer relative group">
                                <div className='text-[14px] text-secondary-500 flex items-center gap-2'>Giá cuối cùng {FormatPrice(1240000)} <BsInfoCircle /></div>
                                <div className='text-[14px]'>cho 2 đêm</div>
                                <div className=' hidden z-[999] group-hover:block transition-all border-gray-300 absolute top-[100%] right-0 text-[14px] w-[380px] bg-white border shadow-lg rounded-lg p-2'>
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

                                    <div className='flex justify-between text-[16px] items-center font-semibold mt-2'>
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
                                </div>
                              </div>
                             
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {/* room 1 */}
              <div className=' border bg-white rounded-lg '>
                
                <div className='p-5 gap-5 flex'>
                  <div className='w-[20%]'>
                      <div className='w-full flex flex-col gap-[2px] rounded-lg overflow-hidden'>
                        <div className='w-full relative h-[150px]'>
                          <Image src={'/images/common/hotel_1.jpg'} fill alt='' className='w-full h-full object-cover' />
                        </div>
                        <div className=' grid grid-cols-3 gap-[2px]'>
                          <div className='w-full relative h-[50px]'>
                            <Image src={'/images/common/hotel_1.jpg'} fill alt='' className='w-full h-full object-cover' />
                          </div>
                          <div className='w-full relative h-[50px]'>
                            <Image src={'/images/common/hotel_1.jpg'} fill alt='' className='w-full h-full object-cover' />
                          </div>
                          <div className='w-full relative h-[50px]'>
                            <Image src={'/images/common/hotel_1.jpg'} fill alt='' className='w-full h-full object-cover' />
                          </div>
                        </div>
                      </div>
                      <div className='flex items-center gap-2 text-[14px] text-secondary-500 py-2'>
                        Xem chi tiết phòng <FaAngleRight/>
                      </div>
                      <div className='flex flex-wrap gap-1'>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Điều hòa nhiệt độ</div>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Điện thoại</div>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Không hút thuốc</div>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Tivi màn hình phẳng</div>
                        <div className='text-sm bg-primary-50 rounded-full px-2 py-1'>Dép đi trong nhà</div>
                        <div className='w-full mt-2'>
                          <div className='flex items-center gap-2 text-[14px] text-secondary-500 bg-secondary-50 w-fit px-2 py-1 rounded-full'>
                            15 tiện ích
                          </div>
                        </div>
                      </div>
                  </div>
                  <div className='flex-1 flex flex-col gap-3'>
                    <div className='flex justify-between items-center'>
                      <div className='flex flex-col gap-2'>
                        <h3 className='font-semibold text-xl'>Phòng Deluxe 1 Giường Lớn Hướng Phố</h3>
                        <div className='flex items-center gap-5 text-[14px] text-gray-600'>
                          <div className='flex items-center gap-1'>
                            <MdOutlinePeople className='text-lg' />
                            <span>2 người</span>
                            <span className='text-secondary-500'>(Xem chi tiết)</span>
                          </div>
                          <div className='flex items-center gap-1'>
                            <CiCalendar className='text-lg'/>
                            <span>30 m²/322 ft²</span>
                          </div>
                          <div className='flex items-center gap-1'>
                            <FaEye className='text-lg'/>
                            <span>Hướng Thành Phố</span>
                          </div>
                        </div>
                      </div>
                      <div>
                        <span className='text-primary-500 text-md'>Vừa được đặt 2 giờ trước</span>
                      </div>
                    </div>
                    <div>
                      {/* item */}
                      <div className='border-t flex'>
                          <div className='w-[50%] border-r pr-3 py-3 flex flex-col gap-3'>
                            <div className='font-semibold'>
                              Lựa chọn 1
                            </div>
                            <div className='text-[14px] flex flex-col gap-2'>
                              <div className='flex items-center gap-2 '>
                                <FaMoneyBill className='text-gray-600'/>
                                <span>Hoàn hủy 1 phần</span>
                                <GoInfo className='text-secondary-500' />
                              </div>
                              <div className='flex items-center gap-2 text-green-500'>
                                <CiForkAndKnife />
                                <span>Giá đã bao gồm bữa sáng</span>
                              </div>
                              <div className='flex items-center gap-2'>
                                <GoInfo />
                                <span>Xem phụ thu người lớn trẻ em</span>
                              </div>
                              <div className='flex items-center gap-2 text-yellow-500'>
                                <IoFlashOutline />
                                <span>Xác nhận trong 30 phút</span>
                              </div>
                              <div className='flex items-center gap-2  text-red-500'>
                                <IoCheckmarkOutline />
                                <span>An tâm đặt phòng, Mytour hỗ trợ xuất hoá đơn nhanh chóng, tiết kiệm thời gian cho bạn.</span>
                              </div>
                            </div>
                            <div className='text-[14px] p-3 border-l-2 border-green-300 bg-green-50'>
                              <div className='font-semibold'>Ưu đãi bao gồm</div>
                              <div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Sử dụng miễn phí hồ bơi, phòng tập thể dục</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Sử dụng miễn phí internet không dây</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Miễn phí trà, cà phê và 02 chai nước suối trong phòng mỗi ngày</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Ăn sáng</span>
                                </div>
                              </div>
                            </div>
                            <div className='flex items-center gap-2 text-secondary-500 text-[14px]'>
                              Xem chi tiết <FaAngleRight />
                            </div>
                          </div>
                          <div className='w-[20%] border-r p-5'>
                            <div className='flex flex-col gap-2 justify-center text-center items-center'>
                              <IoBed className='text-3xl text-gray-500' />
                              <div className='text-[14px]'>1 giường đơn</div>
                            </div>
                          </div>
                          <div className='w-[30%] flex flex-col items-end py-3 text-right'>
                              <div className='flex flex-col items-end'>
                                <div className='bg-primary-500 text-[14px] text-white font-semibold w-fit  py-[1px] rounded-tl-xl rounded-bl-xl px-2'>-23%</div>
                                <div>
                                  <del className='text-gray-600'>{FormatPrice(2270000)}</del>
                                </div>
                                <div className='font-semibold text-xl'>{FormatPrice(1970000)}</div>
                                <div className='text-gray-600'>/ đêm</div>
                              </div>
                              <Link href={'/khach-san/dat-phong?id=4068468469984'} className='py-4'>
                                <Button {...({} as any)} className=' normal-case text-md bg-primary-500 font-semibold px-8'>Đặt phòng</Button>
                              </Link>
                              <div className=" cursor-pointer relative group">
                                <div className='text-[14px] text-secondary-500 flex items-center gap-2'>Giá cuối cùng {FormatPrice(1240000)} <BsInfoCircle /></div>
                                <div className='text-[14px]'>cho 2 đêm</div>
                                <div className=' hidden z-[999] group-hover:block transition-all border-gray-300 absolute top-[100%] right-0 text-[14px] w-[380px] bg-white border shadow-lg rounded-lg p-2'>
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

                                    <div className='flex justify-between text-[16px] items-center font-semibold mt-2'>
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
                                </div>
                              </div>
                             
                          </div>
                      </div>
                      {/* item */}
                      <div className='border-t flex'>
                          <div className='w-[50%] border-r pr-3 py-3 flex flex-col gap-3'>
                            <div className='font-semibold'>
                              Lựa chọn 1
                            </div>
                            <div className='text-[14px] flex flex-col gap-2'>
                              <div className='flex items-center gap-2 '>
                                <FaMoneyBill className='text-gray-600'/>
                                <span>Hoàn hủy 1 phần</span>
                                <GoInfo className='text-secondary-500' />
                              </div>
                              <div className='flex items-center gap-2 text-green-500'>
                                <CiForkAndKnife />
                                <span>Giá đã bao gồm bữa sáng</span>
                              </div>
                              <div className='flex items-center gap-2'>
                                <GoInfo />
                                <span>Xem phụ thu người lớn trẻ em</span>
                              </div>
                              <div className='flex items-center gap-2 text-yellow-500'>
                                <IoFlashOutline />
                                <span>Xác nhận trong 30 phút</span>
                              </div>
                              <div className='flex items-center gap-2  text-red-500'>
                                <IoCheckmarkOutline />
                                <span>An tâm đặt phòng, Mytour hỗ trợ xuất hoá đơn nhanh chóng, tiết kiệm thời gian cho bạn.</span>
                              </div>
                            </div>
                            <div className='text-[14px] p-3 border-l-2 border-green-300 bg-green-50'>
                              <div className='font-semibold'>Ưu đãi bao gồm</div>
                              <div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Sử dụng miễn phí hồ bơi, phòng tập thể dục</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Sử dụng miễn phí internet không dây</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Miễn phí trà, cà phê và 02 chai nước suối trong phòng mỗi ngày</span>
                                </div>
                                <div className='flex items-center gap-2'>
                                  <FaCheck className='text-green-300' />
                                  <span>Ăn sáng</span>
                                </div>
                              </div>
                            </div>
                            <div className='flex items-center gap-2 text-secondary-500 text-[14px]'>
                              Xem chi tiết <FaAngleRight />
                            </div>
                          </div>
                          <div className='w-[20%] border-r p-5'>
                            <div className='flex flex-col gap-2 justify-center text-center items-center'>
                              <IoBed className='text-3xl text-gray-500' />
                              <div className='text-[14px]'>1 giường đơn</div>
                            </div>
                          </div>
                          <div className='w-[30%] flex flex-col items-end py-3 text-right'>
                              <div className='flex flex-col items-end'>
                                <div className='bg-primary-500 text-[14px] text-white font-semibold w-fit  py-[1px] rounded-tl-xl rounded-bl-xl px-2'>-23%</div>
                                <div>
                                  <del className='text-gray-600'>{FormatPrice(2270000)}</del>
                                </div>
                                <div className='font-semibold text-xl'>{FormatPrice(1970000)}</div>
                                <div className='text-gray-600'>/ đêm</div>
                              </div>
                              <Link href={'/khach-san/dat-phong?id=4068468469984'} className='py-4'>
                                <Button {...({} as any)} className=' normal-case text-md bg-primary-500 font-semibold px-8'>Đặt phòng</Button>
                              </Link>
                              <div className=" cursor-pointer relative group">
                                <div className='text-[14px] text-secondary-500 flex items-center gap-2'>Giá cuối cùng {FormatPrice(1240000)} <BsInfoCircle /></div>
                                <div className='text-[14px]'>cho 2 đêm</div>
                                <div className=' hidden z-[999] group-hover:block transition-all border-gray-300 absolute top-[100%] right-0 text-[14px] w-[380px] bg-white border shadow-lg rounded-lg p-2'>
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

                                    <div className='flex justify-between text-[16px] items-center font-semibold mt-2'>
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
                                </div>
                              </div>
                             
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              



            </div>
          </div>
      </div>
      {/* review */}
      <div className=' w-content m-auto py-5'>
        <div className='font-semibold text-xl'>Đánh giá</div>
        <div className='text-green-400'>100% đánh giá từ đối tác và khách hàng đặt phòng trên Quin Booking</div>
       <div className='py-4'>
         <ReviewContent type="detail"/>
       </div>
       <div className='border-t-2 py-5 my-5 flex flex-col gap-3'>
          <div className='font-semibold text-xl'>Địa điểm nổi bật gần đây</div>
          <div className=' grid grid-cols-3 gap-5'>
              <div>
                <div className='flex items-center gap-2 text-md font-semibold'><FaRestroom className='text-primary-500 text-xl'/> Nhà hàng</div>
                <div className='mt-4 px-7 flex flex-col gap-5'>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                </div>
              </div>
              <div>
                <div className='flex items-center gap-2 text-md font-semibold'><FaRestroom className='text-primary-500 text-xl'/> Điểm du lịch</div>
                <div className='mt-4 px-7 flex flex-col gap-5'>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dai Giac Buddhist Temple</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Phu Nhuan District Childrens House</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Nhà thờ Đa Minh Ba Chuông</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                </div>
              </div>
              <div>
                <div className='flex items-center gap-2 text-md font-semibold'><FaCircleDot className='text-pink-500 text-xl'/> Giao thông</div>
                <div className='mt-4 px-7 flex flex-col gap-5'>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                  <div className='flex items-center justify-between text-[14px]'>
                    <div>Dynasty House Nguyễn Văn Trỗi</div>
                    <div>107m</div>
                  </div>
                </div>
              </div>
          </div>
       </div>
       {/* policy */}
        <div className='border-t-2 py-5 my-5 flex flex-col gap-3 '>
          <div className='font-semibold text-xl'>Chính sách khách sạn</div>
          <div className='flex'>
            <div className=' border-r px-5'>
              <div>Nhận phòng</div>
              <div className=' font-semibold'>Từ 14:00</div>
            </div>
            <div className='px-5'>
              <div>Trả phòng</div>
              <div className=' font-semibold'>Trước 12:00</div>
            </div>
          </div>
          <div>
            <div className='text-[14px] font-semibold'>Chính sách chung</div>
            <div className='text-[14px] mt-2'>
              <div>Không cho phép hút thuốc</div>
              <div>Không cho phép thú cưng</div>
              <div>Cho phép tổ chức tiệc / sự kiện</div>
            </div>
          </div>
          <div>
            <div className='text-[14px] font-semibold'>Chính sách chung</div>
            <div className='text-[14px] mt-2'>
              <div>Không cho phép hút thuốc</div>
              <div>Không cho phép thú cưng</div>
              <div>Cho phép tổ chức tiệc / sự kiện</div>
            </div>
          </div>
        </div>
        {/* service */}
        <div className='border-t-2 py-5 my-5 flex flex-col gap-3 '>
          <div className='font-semibold text-xl'>Thông tin hữu ích</div>
          <div className='grid grid-cols-3 gap-12'>
                <div className='flex flex-col gap-4'>
                  <div className='flex justify-between items-center text-[14px]'>
                    <div className='flex items-center gap-2  text-[14px]'>
                      <FaBuilding className='text-gray-600'/><span>Khoảng cách tới trung tâm</span>
                    </div>
                    <div>--:--km</div>
                  </div>
                  <div className='flex justify-between items-center text-[14px]'>
                    <div className='flex items-center gap-2  text-[14px]'>
                      <FaCalendar className='text-gray-600'/><span>Năm khách sạn xây dựng</span>
                    </div>
                    <div>--:--km</div>
                  </div>
                  <div className='flex justify-between items-center text-[14px]'>
                    <div className='flex items-center gap-2  text-[14px]'>
                      <FaJenkins className='text-gray-600'/><span>Số nhà hàng</span>
                    </div>
                    <div>--:--km</div>
                  </div>
                </div>
                <div className='flex flex-col gap-4'>
                  <div className='flex justify-between items-center text-[14px]'>
                    <div className='flex items-center gap-2  text-[14px]'>
                      <FaBuilding className='text-gray-600'/><span>Khoảng cách tới sân bay</span>
                    </div>
                    <div>--:--km</div>
                  </div>
                  <div className='flex justify-between items-center text-[14px]'>
                    <div className='flex items-center gap-2  text-[14px]'>
                      <FaCalendar className='text-gray-600'/><span>Số quán bar</span>
                    </div>
                    <div>--:--km</div>
                  </div>
                  <div className='flex justify-between items-center text-[14px]'>
                    <div className='flex items-center gap-2  text-[14px]'>
                      <FaJenkins className='text-gray-600'/><span>Số tầng khách sạn</span>
                    </div>
                    <div>--:--km</div>
                  </div>
                </div>
                <div className='flex flex-col gap-4'>
                  <div className='flex justify-between items-center text-[14px]'>
                    <div className='flex items-center gap-2  text-[14px]'>
                      <FaBuilding className='text-gray-600'/><span>Khoảng cách tới trung tâm thị trấn</span>
                    </div>
                    <div>--:--km</div>
                  </div>
                  <div className='flex justify-between items-center text-[14px]'>
                    <div className='flex items-center gap-2  text-[14px]'>
                      <FaCalendar className='text-gray-600'/><span>Số phòng khách sạn</span>
                    </div>
                    <div>--:--km</div>
                  </div>
                  <div className='flex justify-between items-center text-[14px]'>
                    <div className='flex items-center gap-2  text-[14px]'>
                      <FaJenkins className='text-gray-600'/><span>Số nhà hàng</span>
                    </div>
                    <div>--:--km</div>
                  </div>
                </div>
          </div>
        </div>
        {/* description */}
        <div className='border-t-2 py-5 my-5 flex flex-col gap-3 '>
          <div className='font-semibold text-xl'>Bản tin khách sạn</div>
          <h3 className='font-semibold'>Khách Sạn Vinpearl Resort Nha Trang</h3>
          <div className='text-[14px]'>
Địa chỉ: Đảo Hòn Tre, Thành Phố Nha Trang, Khánh Hòa, Việt Nam

Mô tả về khách sạn
Khách Sạn Vinpearl Resort và Spa nằm tại đảo Hòn Tre, nằm giữa vịnh Nha Trang với cảnh quan tuyệt đẹp của biển xanh, bãi cát trắng mịn và ánh nắng ấm áp. Với danh tiếng quốc tế và tiêu chuẩn 5 sao, resort này kết hợp hiện đại phương Tây với vẻ đẹp tự nhiên và quyến rũ của một hòn đảo xanh nước biển và rừng dừa xanh ngát.

Khách Sạn Vinpearl Resort và Spa có tổng cộng 485 phòng đẹp, được thiết kế tinh tế để mang đến cho du khách sự thoải mái, riêng tư, và dịch vụ hoàn hảo. Resort cũng có một bãi biển tự nhiên dài 700m đẹp nhất Nha Trang và hệ thống bể bơi ngoài trời hiện đại rộng nhất Đông Nam Á với diện tích hơn 5.700 m2, được bao quanh bởi vườn dừa và cây xanh.

Bạn có thể tận hưởng các dịch vụ chăm sóc sức khỏe và sắc đẹp tại Viet Spa của resort, tham gia vào các chương trình vui chơi, du lịch, và thể thao tại công viên giải trí, công viên nước và thủy cung Vinpearl. Ngoài ra, resort còn có phố mua sắm Vinpearl để bạn có thể mua sắm đồ lưu niệm.
          </div>
        </div>
        {/* faqs */}
        <div className='border-t-2 py-5 my-5 flex flex-col gap-3 '>
          <div className='font-semibold text-xl'>Câu hỏi thường gặp về Vinpearl Resort Nha Trang</div>
          <div className='flex flex-col gap-5'>
            <div>
              <div className=' font-semibold mb-1'>Tôi có thể tới Vinpearl Resort Nha Trang bằng cách nào?</div>
              <p className='text-[14px]'>Khách sạn nằm trên Đảo hòn tre , để di chuyển ra đảo Quý khách có thể sử dụng 01 trong 02 phương tiện sau: + Tàu cao tốc (Cano): di chuyển khoảng 7-10p, khoảng 30p/chuyến + Cáp treo: di chuyển khoảng 20p, khoảng 20p/chuyến Khách sạn cũng gần biển, khoảng cách ra tới biển tùy thuộc vào vị trí của căn biệt thự.</p>
            </div>
            <div>
              <div className=' font-semibold mb-1'>Tôi có thể tới Vinpearl Resort Nha Trang bằng cách nào?</div>
              <p className='text-[14px]'>Khách sạn nằm trên Đảo hòn tre , để di chuyển ra đảo Quý khách có thể sử dụng 01 trong 02 phương tiện sau: + Tàu cao tốc (Cano): di chuyển khoảng 7-10p, khoảng 30p/chuyến + Cáp treo: di chuyển khoảng 20p, khoảng 20p/chuyến Khách sạn cũng gần biển, khoảng cách ra tới biển tùy thuộc vào vị trí của căn biệt thự.</p>
            </div>
            <div>
              <div className=' font-semibold mb-1'>Tôi có thể tới Vinpearl Resort Nha Trang bằng cách nào?</div>
              <p className='text-[14px]'>Khách sạn nằm trên Đảo hòn tre , để di chuyển ra đảo Quý khách có thể sử dụng 01 trong 02 phương tiện sau: + Tàu cao tốc (Cano): di chuyển khoảng 7-10p, khoảng 30p/chuyến + Cáp treo: di chuyển khoảng 20p, khoảng 20p/chuyến Khách sạn cũng gần biển, khoảng cách ra tới biển tùy thuộc vào vị trí của căn biệt thự.</p>
            </div>
            <div>
              <div className=' font-semibold mb-1'>Tôi có thể tới Vinpearl Resort Nha Trang bằng cách nào?</div>
              <p className='text-[14px]'>Khách sạn nằm trên Đảo hòn tre , để di chuyển ra đảo Quý khách có thể sử dụng 01 trong 02 phương tiện sau: + Tàu cao tốc (Cano): di chuyển khoảng 7-10p, khoảng 30p/chuyến + Cáp treo: di chuyển khoảng 20p, khoảng 20p/chuyến Khách sạn cũng gần biển, khoảng cách ra tới biển tùy thuộc vào vị trí của căn biệt thự.</p>
            </div>
          </div>
          <div>
            <div className='font-semibold'>Vinpearl Resort Nha Trang có các tiện ích nào nổi bật?</div>
            <ul className='mt-4 flex flex-col gap-5'>
              <li className='flex  gap-5'>
                <span>Phương tiện đi lại:</span>
                <div className='flex flex-wrap gap-5 flex-1'>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                </div>
              </li>
              <li className='flex  gap-5'>
                <span>Phương tiện đi lại:</span>
                <div className='flex flex-wrap gap-5 flex-1'>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                  <div className='items-center gap-2 flex text-gray-600 text-[14px]'><FaPlane/> Đưa/đón khách sân bay</div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        {/* relative */}
        <div className='border-t-2 py-5 my-5 flex flex-col gap-3 '>
          <div className='font-semibold text-xl'>Khách sạn liên quan</div>
          <div className='grid grid-cols-5 gap-5 mt-5'>
              {/* item */}
              <Link href={'/khach-san/'+123}>
                <div className=' relative rounded-lg w-full h-[134px]'>
                  <Image
                    alt=''
                    fill
                    src={'/images/common/hotel_1.jpg'}
                    className='w-full h-full object-cover rounded-lg'
                  />
                </div>
                <div className='flex flex-col gap-2'>
                  <div className='font-semibold  line-clamp-2 mt-2 text-[14px] h-[46px]'>Khách sạn Mường Thanh Luxury Sài Gòn</div>
                  <div className='flex text-sm text-yellow-500 gap-1'>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                  </div>
                  <div className='text-[14px]'>Bà Rịa - Vũng Tàu</div>
                </div>
              </Link>
              {/* item */}
              <Link href={'/khach-san/'+123}>
                <div className=' relative rounded-lg w-full h-[134px]'>
                  <Image
                    alt=''
                    fill
                    src={'/images/common/hotel_1.jpg'}
                    className='w-full h-full object-cover rounded-lg'
                  />
                </div>
                <div className='flex flex-col gap-2'>
                  <div className='font-semibold  line-clamp-2 mt-2 text-[14px] h-[46px]'>Khách sạn Mường Thanh Luxury Sài Gòn</div>
                  <div className='flex text-sm text-yellow-500 gap-1'>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                  </div>
                  <div className='text-[14px]'>Bà Rịa - Vũng Tàu</div>
                </div>
              </Link>
              {/* item */}
              <Link href={'/khach-san/'+123}>
                <div className=' relative rounded-lg w-full h-[134px]'>
                  <Image
                    alt=''
                    fill
                    src={'/images/common/hotel_1.jpg'}
                    className='w-full h-full object-cover rounded-lg'
                  />
                </div>
                <div className='flex flex-col gap-2'>
                  <div className='font-semibold  line-clamp-2 mt-2 text-[14px] h-[46px]'>Khách sạn Mường Thanh Luxury Sài Gòn</div>
                  <div className='flex text-sm text-yellow-500 gap-1'>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                  </div>
                  <div className='text-[14px]'>Bà Rịa - Vũng Tàu</div>
                </div>
              </Link>
              {/* item */}
              <Link href={'/khach-san/'+123}>
                <div className=' relative rounded-lg w-full h-[134px]'>
                  <Image
                    alt=''
                    fill
                    src={'/images/common/hotel_1.jpg'}
                    className='w-full h-full object-cover rounded-lg'
                  />
                </div>
                <div className='flex flex-col gap-2'>
                  <div className='font-semibold  line-clamp-2 mt-2 text-[14px] h-[46px]'>Khách sạn Mường Thanh Luxury Sài Gòn</div>
                  <div className='flex text-sm text-yellow-500 gap-1'>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                  </div>
                  <div className='text-[14px]'>Bà Rịa - Vũng Tàu</div>
                </div>
              </Link>
              {/* item */}
              <Link href={'/khach-san/'+123}>
                <div className=' relative rounded-lg w-full h-[134px]'>
                  <Image
                    alt=''
                    fill
                    src={'/images/common/hotel_1.jpg'}
                    className='w-full h-full object-cover rounded-lg'
                  />
                </div>
                <div className='flex flex-col gap-2'>
                  <div className='font-semibold  line-clamp-2 mt-2 text-[14px] h-[46px]'>Khách sạn Mường Thanh Luxury Sài Gòn</div>
                  <div className='flex text-sm text-yellow-500 gap-1'>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                    <FaStar/>
                  </div>
                  <div className='text-[14px]'>Bà Rịa - Vũng Tàu</div>
                </div>
              </Link>
          </div>
        </div>
      </div>
    </div>
  )
}

export default Container