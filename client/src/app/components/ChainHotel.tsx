'use client';

import Image from "next/image";
import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";

// Data input
const data = [
        {
            id:1,
            image:'/images/common/hotel_1.jpg',
            name:'Côn Đảo Resort',
            slug:'con-dao-resort',
            sale:23,
            start:4,
            address:'Huyện Côn Đảo',
            reviews:{
                rating:8.4,
                review_counts:12,
                type:'Rất Tốt'
            },
            price:1500000,
        },
        {
            id:13,
            image:'/images/common/hotel_2.jpg',
            name:'Côn Đảo Resort',
            slug:'con-dao-resort',
            sale:23,
            start:4,
            address:'Huyện Côn Đảo',
            reviews:{
                rating:8.4,
                review_counts:12,
                type:'Rất Tốt'
            },
            price:1500000,
        },
        {
            id:12,
            image:'/images/common/hotel_3.jpg',
            name:'Côn Đảo Resort',
            slug:'con-dao-resort',
            sale:23,
            start:4,
            address:'Huyện Côn Đảo',
            reviews:{
                rating:8.4,
                review_counts:12,
                type:'Rất Tốt'
            },
            price:1500000,
        },
        {
            id:4,
            image:'/images/common/hotel_4.jpg',
            name:'Côn Đảo Resort',
            slug:'con-dao-resort',
            sale:23,
            start:4,
            address:'Huyện Côn Đảo',
            reviews:{
                rating:8.4,
                review_counts:12,
                type:'Rất Tốt'
            },
            price:1500000,
        },
        {
            id:5,
            image:'/images/common/hotel_5.png',
            name:'Côn Đảo Resort',
            slug:'con-dao-resort',
            sale:23,
            start:4,
            address:'Huyện Côn Đảo',
            reviews:{
                rating:8.4,
                review_counts:12,
                type:'Rất Tốt'
            },
            price:1500000,
        },
         {
            id:0,
            image:'/images/common/hotel_4.jpg',
            name:'Côn Đảo Resort',
            slug:'con-dao-resort',
            sale:23,
            start:4,
            address:'Huyện Côn Đảo',
            reviews:{
                rating:8.4,
                review_counts:12,
                type:'Rất Tốt'
            },
            price:1500000,
        },
    ]



export default function ChainHotel() {
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
                {data.map((item) => {
                  return (
                    <SwiperSlide key={item.id+'okok'} >
                        <div className="grid grid-cols-2 gap-3">
                          <div className=" relative rounded-lg ">
                              <div className=" relative h-[390px] w-full rounded-lg overflow-hidden">
                                <Image 
                                  fill
                                  alt=""
                                  className=" object-cover w-full h-full"
                                  src={'/images/common/chain_1.jpg'}
                                />
                              </div>
                              <div className="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50 rounded-lg" />
                              <div className=" absolute top-0 left-0 right-0 bottom-0 flex flex-col justify-between p-4">
                                <div className="w-[64px] h-[64px] object-cover relative rounded-lg shadow-lg ">
                                  <Image 
                                    fill
                                    alt=""
                                    className=" object-cover w-full h-full  rounded-lg"
                                    src={'/images/common/muong-thanhlogo.gif'}
                                  />
                                </div>
                                <div className="text-white ">
                                  <div> Chỉ từ 215k/người</div>
                                </div>
                              </div>
                          </div>
                          <div className="flex flex-col gap-3">
                            <div className=" relative rounded-lg flex-1">
                              <div className=" relative h-full w-full rounded-lg overflow-hidden">
                                <Image 
                                  fill
                                  alt=""
                                  className=" object-cover w-full h-full"
                                  src={'/images/common/chain_1.jpg'}
                                />
                              </div>
                              <div className="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50 rounded-lg" />
                              <div className=" absolute top-0 left-0 right-0 bottom-0 flex flex-col justify-between p-4">
                                <div className="w-[64px] h-[64px] object-cover relative rounded-lg shadow-lg ">
                                  <Image 
                                    fill
                                    alt=""
                                    className=" object-cover w-full h-full  rounded-lg"
                                    src={'/images/common/muong-thanhlogo.gif'}
                                  />
                                </div>
                                <div className="text-white ">
                                  <div> Chỉ từ 215k/người</div>
                                </div>
                              </div>
                          </div>
                          <div className=" relative rounded-lg flex-1">
                              <div className=" relative h-full w-full rounded-lg overflow-hidden">
                                <Image 
                                  fill
                                  alt=""
                                  className=" object-cover w-full h-full"
                                  src={'/images/common/chain_1.jpg'}
                                />
                              </div>
                              <div className="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-50 rounded-lg" />
                              <div className=" absolute top-0 left-0 right-0 bottom-0 flex flex-col justify-between p-4">
                                <div className="w-[64px] h-[64px] object-cover relative rounded-lg shadow-lg ">
                                  <Image 
                                    fill
                                    alt=""
                                    className=" object-cover w-full h-full  rounded-lg"
                                    src={'/images/common/muong-thanhlogo.gif'}
                                  />
                                </div>
                                <div className="text-white ">
                                  <div> Chỉ từ 215k/người</div>
                                </div>
                              </div>
                          </div>
                          </div>
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
