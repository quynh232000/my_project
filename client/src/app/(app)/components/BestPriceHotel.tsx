'use client';

import Image from "next/image";
import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import Link from "next/link";
import {  FaHeart } from "react-icons/fa6";
import { FormatPrice, getRandomInt } from "@/utils/common";
import {  LocateIcon, Star, Umbrella } from "lucide-react";
import { BestPrice } from "@/services/app/home/SGetHotelList";
import { useEffect, useState } from "react";
import SkeProductSale from "@/components/shared/Skeleton/SkeProductSale";




export default function BestPriceHotel({data,loading}:{data?:BestPrice[],loading:boolean}) {
  const [navActive,setNavActive] = useState( data ? data[0] : null)
  useEffect(()=>{
    if(data && data[0]){
      setNavActive(data[0])
    }
  },[data])
  return (
    <div className=" px-4 bg-primary-50">
      <div className="flex flex-col my-10 w-content m-auto">
       <div className="pb-10 flex justify-center items-center w-full">
           <div className="flex-1">
              <div className="flex items-center gap-2">
                <h2 className=" text-xl font-bold ">
                Khách sạn giá sốc chỉ có trên Quin Booking

                </h2>
                
              </div>
              <div className="text-[14px] text-gray-600">Tiết kiệm chi phí với các khách sạn hợp tác chiến lược cùng Quin Booking, cam kết giá tốt nhất và chất lượng dịch vụ tốt nhất dành cho bạn.</div>
              <div className="flex gap-3 items-center mt-4 flex-wrap">

                {data && data?.map((item)=>{
                  return <div onClick={()=>setNavActive(item)} className={"border rounded-full py-2 px-4   border-primary-400 cursor-pointer text-[14px] "+
                     (item.id == navActive?.id ? ' bg-primary-500 text-white':' bg-white hover:bg-primary-100')} key={"best_price1_"+item.name}>{item.name}</div>
                })}
              </div>
           </div>
           
       </div>

        <div className=" w-full">
            {loading && <div className="grid grid-cols-4 gap-5">

                    <SkeProductSale/>
                    <SkeProductSale/>
                    <SkeProductSale/>
                    <SkeProductSale/>
            </div> }
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
             
               {data && data?.find(i=>i.id == navActive?.id)?.hotels.map((item) => {
                  return (
                    <SwiperSlide key={item.id+'1111'} >
                         <Link href={'/khach-san/'+item.slug}>
                            <div  className="bg-white rounded-lg shadow-lg relative">
                                <span className=" absolute top-0 left-0 z-[1] bg-yellow-500 px-4 py-1 text-sm text-white rounded-tl-lg rounded-br-lg">-{item.stars} %</span>
                                <span className=" absolute top-1 right-1 z-[1] text-yellow-500"><FaHeart  className=" text-xl"/></span>
                                <div className="overflow-hidden ">
                                    <div className="w-full h-[180px] rounded-t-lg relative overflow-hidden">
                                        <Image 
                                            src={item.image}
                                            fill
                                            alt={item.name}
                                            className="h-full w-full object-cover rounded-t-lg hover:scale-105 transition-all"
                                        />
                                    </div>
                                </div>
                                <div className="p-3 flex flex-col justify-between">
                                    <div className="flex flex-col gap-2">
                                        <h2 className="font-semibold line-clamp-2 h-[46px]">{item.name}</h2>
                                        <div className="flex gap-1">
                                            {Array.from({ length: item.stars ? +item.stars : 0 }, (_, index) => <span key={index}><Star size={14} className="text-yellow-500"/></span> )}
                                        </div>
                                        <div className="flex gap-2 items-center text-[14px] text-gray-600 line-clamp-1">
                                            <LocateIcon size={16} className="text-gray-600"/>
                                            <span className=" line-clamp-1">{`${item.location.ward_name}, ${item.location.province_name}, ${item.location.country_name} `}</span>
                                        </div>
                                        <div className="flex gap-2 text-gray-600 text-[14px] ">
                                            <div className="flex gap-2 items-center  bg-primary-100 rounded-sm px-1">
                                                <Umbrella size={16} className="text-primary-500"/>
                                                <span className="text-primary-500 font-semibold" >Tuyệt vời</span>
                                            </div>
                                            <div>
                                                <span>{getRandomInt(0,10)}</span>
                                                <span className="text-gray-400"> ( {getRandomInt(10,1000)} đánh giá)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="text-right mt-5">
                                        
                                        <div className="text-primary-500 font-semibold text-xl">
                                        {FormatPrice (item.avg_price)}
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </Link>
                    </SwiperSlide>
                  );
                })  }
              </Swiper>
          
        </div>
         <div className="flex justify-center mt-8">
                <Link href={'/khach-san/'+navActive?.type_location+'/'+navActive?.slug} className="bg-yellow-500 text-white hover:bg-yellow-600 shadow-lg rounded-lg py-2 px-8 cursor-pointer">Xem thêm</Link>
            </div>
      </div>
    </div>
  );
}
