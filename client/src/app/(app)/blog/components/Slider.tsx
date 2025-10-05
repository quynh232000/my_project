import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import Image from "next/image";
import { useEffect, useState } from "react";
import { getPostList, IPostItem } from './../../../../services/app/blog/getBlogFeature';
import { formatDate } from "@/utils/common";
function Slider() {
    const [data,setData] = useState<IPostItem[]>([])
     useEffect(()=>{
            getPostList({limit:10,slug:'news',type:'featured'}).then(res=>{
                if(res){
                    setData(res?.list)
                }
            })
     },[])
    console.log(data)
  return (
    <div>
        <Swiper
            modules={[A11y, Autoplay]}
            spaceBetween={0}
            slidesPerView={1}
            autoplay={{ delay: 3000, disableOnInteraction: false }}
            scrollbar={{ draggable: true }}
            // breakpoints={{
            //   320: { slidesPerView: 2, spaceBetween: 5 }, // Small screens
            //   480: { slidesPerView: 2, spaceBetween: 5 }, // Mobile devices
            //   768: { slidesPerView: 3, spaceBetween: 10 }, // Tablets
            //   1024: { slidesPerView: 5, spaceBetween: 10 }, // Laptops
            //   1280: { slidesPerView: 5, spaceBetween: 10 }, // Large screens
            // }}
            >
                {data && data.map(item=>{
                    return  <SwiperSlide key={item.id}>
                <div className=" relative w-full">
                        <div className=" relative w-full h-[470px]">
                            <Image
                            fill
                            alt=""
                            src={item.image??'/images/common/hotel_1.jpg'}
                            className=" w-full h-full object-cover"
                            />
                        </div>  
                        <div className="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-70 rounded-lg backdrop-blur-lg" />
                        <div className=" absolute top-0 left-0 right-0 bottom-0  text-white flex justify-center items-center">
                                <div className="w-content m-auto flex flex-col justify-center items-center ">
                                    <h2 className="font-bold text-5xl px-12 text-center ">
                                        {item.name}
                                    </h2>
                                    <div className="flex items-center gap-5 mt-5">
                                        <div>
                                        {formatDate(item.created_at)} 
                                        </div>
                                        <div className=" flex items-center gap-2">
                                            <div className=" relative w-[36px] h-[36px]">
                                                <Image
                                                alt={item.name}
                                                className=" rounded-full object-cover"
                                                fill
                                                src={item.author.avatar ??'/images/common/hotel_1.jpg'}
                                                />
                                            </div>
                                            <span>{item.author.full_name}</span>

                                        </div>
                                    </div>
                                </div>
                        </div>
                </div>
            </SwiperSlide>
                })}
           
                       
        
        </Swiper>
    </div>
  )
}

export default Slider