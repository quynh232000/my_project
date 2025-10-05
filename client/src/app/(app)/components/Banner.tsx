import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import Image from "next/image";
import { useEffect, useState } from "react";
import { IBannerItem, SGetBannerList } from "@/services/app/home/SGetBannerList";
import Link from "next/link";
import SkeBanner from "@/components/shared/Skeleton/SkeBanner";
function Banner() {
   
    const [data,setData] = useState<IBannerItem[]>([])
    const [loading,setLoading] = useState(true)
    useEffect(()=>{
        setLoading(true)
      SGetBannerList().then(res=>{
        setLoading(false)
        if(res)setData(res)
      })
    },[])
  return (
    <div className='w-content m-auto '>
        <div className="w-full ">
            {loading && <div className="grid grid-cols-3 gap-5 mb-8">
                <SkeBanner/>
                <SkeBanner/>
                <SkeBanner/>
                </div>}
            <Swiper
              modules={[A11y, Autoplay]}
              spaceBetween={8}
              slidesPerView={3}
              autoplay={{ delay: 3500, disableOnInteraction: false }}
            //   scrollbar={{ draggable: true }}
              pagination={{ clickable: true }}
            >
              {data.map((item) => {
                  return (
                    <SwiperSlide key={item.id}>
                      <Link href={'/uu-dai/'+item.slug}>
                        <div className="h-[165px] w-full relative rounded-lg">
                        <Image
                          src={item.image}
                          fill
                          className="h-full w-full object-cover rounded-lg"
                          alt={'banner'+item.title}
                          title={'banner'+item.title}
                        />
                      </div>
                      </Link>
                    </SwiperSlide>
                  );
                })}
            </Swiper>
        </div>
    </div>
  )
}

export default Banner