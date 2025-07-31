'use client';

import Image from "next/image";
import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import { useEffect, useState } from "react";
import { IChainItem, SGetChainList } from "@/services/app/home/SGetChainList";
import { FormatPrice } from "@/utils/common";

// Data input




export default function ChainHotel() {
  const [chains,setChains] = useState<IChainItem[][]>([])
  useEffect(() => {
  SGetChainList().then(res => {
    if (res) {
      const grouped = res.reduce<IChainItem[][]>((acc, item, index) => {
        const groupIndex = Math.floor(index / 3);
        if (!acc[groupIndex]) acc[groupIndex] = [];
        acc[groupIndex].push(item);
        return acc;
      }, []);
      setChains(grouped);
    }
  });
}, []);
  return (
    <div className=" px-4 bg-white">
      <div className="flex flex-col my-10 w-content m-auto">
       <div className="pb-10 flex justify-center items-center w-full">
           <div className="flex-1">
              <div className="flex items-center gap-2">
                <h2 className=" text-xl font-bold ">
                Chuỗi khách sạn đăng ký trên Quin Booking
                </h2>
                
              </div>
              <div className="text-[14px] text-gray-600">Các thương hiệu khách sạn đối tác hàng đầu</div>
             
           </div>
           
       </div>

        <div className=" w-full flex">
          <Swiper
                modules={[A11y, Autoplay]}
                spaceBetween={12}
                slidesPerView={2}
                autoplay={{ delay: 4000, disableOnInteraction: false }}
                // // scrollbar={{ draggable: true }}
                // breakpoints={{
                //   320: { slidesPerView: 2, spaceBetween: 5 }, // Small screens
                //   480: { slidesPerView: 2, spaceBetween: 5 }, // Mobile devices
                //   768: { slidesPerView: 3, spaceBetween: 10 }, // Tablets
                //   1024: { slidesPerView: 5, spaceBetween: 10 }, // Laptops
                //   1280: { slidesPerView: 5, spaceBetween: 10 }, // Large screens
                // }}
              >
                {chains.map((item,index) => {
                  return (
                    <SwiperSlide key={index} >
                        <div className="grid grid-cols-2 gap-3">
                           {item[0] && 
                            <div className=" relative rounded-lg ">
                            
                                <div className=" relative h-[390px] w-full rounded-lg overflow-hidden">
                                    <Image 
                                    fill
                                    alt=""
                                    className=" object-cover w-full h-full"
                                    src={item[0]?.image ??'/images/common/chain_1.jpg'}
                                    />
                                </div>
                                <div className="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50 rounded-lg" />
                                <div className=" absolute top-0 left-0 right-0 bottom-0 flex flex-col justify-between p-4">
                                    <div className="w-[64px] h-[64px] object-cover relative rounded-lg shadow-lg ">
                                    <Image 
                                        fill
                                        alt=""
                                        className="  w-full h-full  rounded-lg"
                                        src={item[0].logo ??'/images/common/muong-thanhlogo.gif'}
                                    />
                                    </div>
                                    <div className="text-white ">
                                    <div className="font-semibold text-xl mb-2">{item[0].name}</div>
                                    <div> Chỉ từ {FormatPrice(item[0].price ?? 0)}/đêm</div>
                                    </div>
                                </div>
                            </div>
                            }
                            {item[1] && item[2] &&
                          <div className="flex flex-col gap-3">
                            {item[1] &&
                            <div className=" relative rounded-lg flex-1">
                              <div className=" relative h-full w-full rounded-lg overflow-hidden">
                                <Image 
                                  fill
                                  alt=""
                                  className=" object-cover w-full h-full"
                                  src={item[1]?.image ??'/images/common/chain_1.jpg'}
                                />
                              </div>
                              <div className="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50 rounded-lg" />
                              <div className=" absolute top-0 left-0 right-0 bottom-0 flex flex-col justify-between p-4">
                                <div className="w-[64px] h-[64px] object-cover relative rounded-lg shadow-lg ">
                                  <Image 
                                    fill
                                    alt=""
                                    className="  w-full h-full  rounded-lg"
                                    src={item[1].logo ??'/images/common/muong-thanhlogo.gif'}
                                  />
                                </div>
                                <div className="text-white ">
                                  <div className="font-semibold text-xl mb-2">{item[1]?.name}</div>
                                  <div> Chỉ từ {FormatPrice(item[1]?.price ?? 0)}/đêm</div>
                                </div>
                              </div>
                            </div>}
                             {item[2] &&
                            <div className=" relative rounded-lg flex-1">
                                <div className=" relative h-full w-full rounded-lg overflow-hidden">
                                    <Image 
                                    fill
                                    alt=""
                                    className=" object-cover w-full h-full"
                                    src={item[2]?.image ??'/images/common/chain_1.jpg'}
                                    />
                                </div>
                                <div className="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50 rounded-lg" />
                                <div className=" absolute top-0 left-0 right-0 bottom-0 flex flex-col justify-between p-4">
                                    <div className="w-[64px] h-[64px] object-cover relative rounded-lg shadow-lg ">
                                    <Image 
                                        fill
                                        alt=""
                                        className="  w-full h-full  rounded-lg"
                                        src={item[2].logo ??'/images/common/muong-thanhlogo.gif'}
                                    />
                                    </div>
                                    <div className="text-white ">
                                    <div className="font-semibold text-xl mb-2">{item[2]?.name}</div>
                                    <div> Chỉ từ {FormatPrice(item[2]?.price ?? 0)}/đêm</div>
                                    </div>
                                </div>
                            </div>}
                          </div>}
                        </div>
                    </SwiperSlide>
                  );
                })}
              </Swiper>
          
        </div>
       
      </div>
    </div>
  );
}
