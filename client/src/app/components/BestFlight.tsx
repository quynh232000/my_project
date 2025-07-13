'use client';

import Image from "next/image";
import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import Link from "next/link";
import {  Menu, MenuHandler, MenuList } from '@material-tailwind/react';
import { FaAngleDown } from "react-icons/fa6";
import { useState } from "react";
import { MdFlight, MdOutlineArrowRightAlt } from "react-icons/md";
import { FormatPrice } from "@/utils/common";

// Data input
const rawPlaces = [
  { name: 'Hồ Chí Minh', src: '/images/common/hotel_1.jpg' },
  { name: 'Vũng Tàu', src: '/images/common/hotel_2.jpg' },
  { name: 'Đà Lạt', src: '/images/common/hotel_3.jpg' },
  { name: 'Phan Thiết', src: '/images/common/hotel_4.jpg' },
  { name: 'Đà Nẵng', src: '/images/common/hotel_4.jpg' },
  { name: 'Quy Nhơn', src: '/images/common/hotel_4.jpg' },
  { name: 'Phú Quốc', src: '/images/common/hotel_3.jpg' },
  { name: 'Hội An', src: '/images/common/hotel_3.jpg' },
  { name: 'Hà Nội', src: '/images/common/hotel_3.jpg' },
  { name: 'Hạ Long', src: '/images/common/hotel_3.jpg' },
  { name: 'Nha Trang', src: '/images/common/hotel_3.jpg' },
  { name: 'Sa Pa', src: '/images/common/hotel_3.jpg' },
];

const dataFlight = [
  {
    id:1,
    name:'Hồ Chí Minh',
  },
  {
    id:2,
    name:'Đà Nẵng',
  },
  {
    id:12,
    name:'Đà Lạt',
  },
  {
    id:13,
    name:'Phú Quốc',
  },
  {
    id:14,
    name:'Nha Trang',
  },
]


export default function BestFlight() {
  const [ selectFlight,setSelectFlight] = useState(dataFlight[0])
  return (
    <div className="w-content  mx-auto">
      <div className="flex flex-col my-10">
       <div className="pb-10 flex justify-center items-center w-full">
           <div className="flex-1">
              <div className="flex items-center gap-2">
                <h2 className=" text-xl font-bold ">
                Chuyến bay giá tốt từ 

                </h2>
                <div>
                  <Menu  placement="bottom-start" >
                    <MenuHandler>
                      <button
                        className="flex items-center justify-center gap-2 rounded-full text-primary-500 font-semibold text-2xl transition-all">
                       <span>{selectFlight.name}</span>
                       <FaAngleDown className="text-md"/>
                      </button>
                    </MenuHandler>
                    <MenuList  {...({} as any)} className='w-[240px] max-h-[220px] z-[1] p-0 outline-none border-transparent  flex flex-col hover:border-none hover:outline-none hover:ring-0 focus:outline-none focus:ring-0 focus:border-none'>
                     
                      <div className='flex-1 overflow-y-scroll scrollbar_custom text-md'>
                        {dataFlight.map((item)=>{
                          return   <div onClick={()=> setSelectFlight(item)} key={item.id+"best-flight"} className="p-2 px-4 cursor-pointer hover:bg-primary-50">{item.name}</div>
                        })}
                      
                      </div>
                    </MenuList>
                  </Menu>
                </div>
              </div>
              <div className="text-[14px] text-gray-600">Những chuyến bay giá tốt nhất trong tháng khởi hành từ {selectFlight.name}</div>
           </div>
           <div>
              <button className="border border-primary-500 text-primary-500 bg-primary-50 py-2 px-4 rounded-lg hover:bg-primary-100 cursor-pointer ">Khám phá ngay</button>
           </div>
       </div>

        <div className=" w-full flex">
          <Swiper
                modules={[A11y, Autoplay]}
                spaceBetween={8}
                slidesPerView={4}
                autoplay={{ delay: 3200, disableOnInteraction: false }}
                // // scrollbar={{ draggable: true }}
                // breakpoints={{
                //   320: { slidesPerView: 2, spaceBetween: 5 }, // Small screens
                //   480: { slidesPerView: 2, spaceBetween: 5 }, // Mobile devices
                //   768: { slidesPerView: 3, spaceBetween: 10 }, // Tablets
                //   1024: { slidesPerView: 5, spaceBetween: 10 }, // Laptops
                //   1280: { slidesPerView: 5, spaceBetween: 10 }, // Large screens
                // }}
              >
                {rawPlaces.map((item) => {
                  return (
                    <SwiperSlide key={item.name} >
                        <Link href={'/khach-san/vung-tau'} className="">
                            <div className="border rounded-lg p-4">
                              <div className="flex items-center gap-1">
                                <div className="w-[24px] h-[24px] relative">
                                  <Image
                                    alt=""
                                    fill
                                    src={'/images/flight/vietjet.webp'}
                                    className=" object-cover w-full h-full"
                                  />
                                </div>
                                <span className="font-semibold text-[14px]">Vietjet Air</span>
                              </div>
                              <div className="flex justify-between items-center font-semibold mt-2">
                                <div>Tân Sơn nhất</div>
                                <div><MdOutlineArrowRightAlt /></div>
                                <div>Cam Ranh</div>
                              </div>
                              <div className="flex items-center gap-2 text-gray-600">
                                <MdFlight />
                                <span className="text-[14px]">Khởi hành: 19/07/2025</span>
                              </div>
                              <div className="text-right mt-4">
                                  <div className="text-[14px] text-gray-600">
                                    <del>{FormatPrice(540000)}</del>
                                  </div>
                                  <div className="font-semibold text-xl">{FormatPrice(490000)}</div>
                                  <div className="text-[14px] text-gray-600">
                                    Giá sau thuế: {FormatPrice(890000)}
                                  </div>
                              </div>
                            </div>
                        </Link>
                        
                    </SwiperSlide>
                  );
                })}
              </Swiper>
          
        </div>
      </div>
    </div>
  );
}
