import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import Image from "next/image";
import TimeFlashSale from "@/components/shared/Time/TimeFlashSale";
import {  LocateIcon, Star, Umbrella } from "lucide-react";
import { FormatPrice } from "@/utils/common";
import Link from "next/link";
import { FaHeart } from "react-icons/fa6";
import { CallAPI } from "@/configs/axios/axios";
import { useEffect, useState } from "react";


const GetHotel = async () => {
    try {
        const { data } = await CallAPI().post(`https://backend.190booking.com/api/v1/hotel/hotel/filter`,{
          type:'country',
          slug:'viet-nam'
        });
        if (!data) {
            return null;
        }
        return Promise.resolve(data.data ?? []);
    } catch (error) {
        return Promise.reject(error);
    }
};
function Flashsale() {
    const  i_flash = "/images/common/bg_flashsale.png";
    const  i_flash_top = "/images/common/flash_top.png";
    
    const [hotels,setHotels] = useState<any[]>([])
    useEffect(()=>{
            GetHotel().then(res=>{
                if(res){
                    setHotels(res)
                }
            })
    },[])
  return (
     <div className="relative">
          <div className=" w-full h-[620px] relative">
            <Image
              src={i_flash}
              fill
              className="h-[620px] w-full object-cover"
              alt="Giảm giá cực sốc"
              title="Giảm giá cực sốc"
            />
          </div>
          <div className="absolute bottom-0 left-0 right-0 top-0 m-auto flex w-100 flex-col gap-[20px] px-2 py-[20px] xl:w-content xl:px-0">
            <div className="flex flex-col items-center justify-between gap-4  lg:flex-row">
              <div className="relative animate-fadeInLeft h-[94px] w-[386px]">
                <Image
                  src={i_flash_top}
                  fill
                  alt="Giảm giá cực sốc"
                  title="Giảm giá cực sốc"
                  className="animate-pulse drop-shadow-[0_0_10px_rgba(255,255,0,0.8)] h-full w-full"
                />
              <div className="absolute left-[-10px] top-1/2 h-4 w-4 animate-ping rounded-full bg-yellow-400"></div>
            </div>

            {/* Thêm bộ đếm giờ nếu muốn */}
            <TimeFlashSale />
          </div>
            <div>
              <Swiper
                modules={[A11y, Autoplay]}
                spaceBetween={8}
                slidesPerView={4}
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
                {hotels.map((item) => {
                  return (
                    <SwiperSlide key={item?.id+"okok"}>
                        <Link href={'/khach-san/'+item.slug}>
                            <div  className="bg-white rounded-lg shadow-lg relative">
                                <span className=" absolute top-0 left-0 z-[1] bg-yellow-500 px-4 py-1 text-sm text-white rounded-tl-lg rounded-br-lg">-{item.sale}</span>
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
                                        <div className="flex gap-1 h-3">
                                            {Array.from({ length: item.stars ? item.stars : 1 }, (_, index) => <span key={index}><Star size={14} className="text-yellow-500"/></span> )}
                                        </div>
                                        <div className="flex gap-2 items-center text-[14px] text-gray-600">
                                            <LocateIcon size={16} className="text-gray-600"/>
                                            <span className=" line-clamp-1">{item?.location?.address ?? ''}</span>
                                        </div>
                                        <div className="flex gap-2 text-gray-600 text-[14px] ">
                                            <div className="flex gap-2 items-center  bg-primary-100 rounded-sm px-1">
                                                <Umbrella size={16} className="text-primary-500"/>
                                                <span className="text-primary-500 font-semibold" >{item.stars}</span>
                                            </div>
                                            <div>
                                                <span>Tuyệt vời</span>
                                                <span className="text-gray-400"> ( 50 đánh giá)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="text-right mt-5">
                                        <div>
                                            <del className="text-gray-500 text-[14px]">{FormatPrice (item.avg_price + 10000)}</del>
                                        </div>
                                        <div className="text-primary-500 font-semibold text-xl">
                                        {FormatPrice (item.avg_price)}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Link>
                        
                    </SwiperSlide>
                  );
                })}
              </Swiper>
            </div>
            <div className="flex justify-center mt-2">
                <div className="bg-yellow-500 text-white hover:bg-yellow-600 shadow-lg rounded-lg py-2 px-8 cursor-pointer">Xem thêm</div>
            </div>
          </div>
    </div>
  )
}

export default Flashsale