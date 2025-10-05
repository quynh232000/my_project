'use client';

import Image from "next/image";
import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import Link from "next/link";
import { IData, SGetHotelCategoryList } from '@/services/app/home/SGetHotelCategoryList'
import React, { useEffect, useState } from 'react'



export default function PopularPlaces() {
  const [hotelCategories,setHotelCategories]  = useState<IData|null>(null)
    useEffect(()=>{
        SGetHotelCategoryList().then(res=>{
            if(res) setHotelCategories(res)
        })
    },[])
  return (
    <div className="w-content mx-auto">
      <div className="flex flex-col my-10">
       <div className="pb-10">
            <h2 className=" text-xl font-bold ">
            Điểm đến yêu thích
            </h2>
            <div className="text-[14px] text-gray-600">Địa điểm hot nhất do Quin Booking đề xuất</div>
       </div>

        <div className=" w-full">
          <Swiper
                modules={[A11y, Autoplay]}
                spaceBetween={8}
                slidesPerView={7}
                autoplay={{ delay: 3000, disableOnInteraction: false }}
                // scrollbar={{ draggable: true }}
                // breakpoints={{
                //   320: { slidesPerView: 2, spaceBetween: 5 }, // Small screens
                //   480: { slidesPerView: 2, spaceBetween: 5 }, // Mobile devices
                //   768: { slidesPerView: 3, spaceBetween: 10 }, // Tablets
                //   1024: { slidesPerView: 5, spaceBetween: 10 }, // Laptops
                //   1280: { slidesPerView: 5, spaceBetween: 10 }, // Large screens
                // }}
              >
                {hotelCategories?.interest.map((item) => {
                  return (
                    <SwiperSlide key={item.name} >
                        <Link href={'/khach-san/'+item.type_location+'/'+item.slug} className="flex flex-col items-center justify-center">
                            <div
                              key={item.name}
                              className=" rounded-full relative overflow-hidden shadow-md group cursor-pointer transition-transform flex flex-col items-center"
                              style={{
                                width:128,
                                height: 128,
                              }}
                            >
                            <Image
                              src={item.image}
                              alt={item.name}
                              fill
                              className="object-cover transition-transform duration-300 group-hover:scale-110"
                            />
                          </div>
                          <div className="text-center mt-5">
                            <h3 className="font-semibold"> {item.name}</h3>
                            <div className="text-[14px] text-gray-600">{item.product_counts} khách sạn</div>
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
