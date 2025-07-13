import { Swiper, SwiperSlide } from "swiper/react";
import { A11y, Autoplay } from "swiper/modules";
import Image from "next/image";
function Banner() {
    const data = [
       
          {
            id:10,
            url:'/uu-dai',
            image:'/images/banners/banner_7.jpg'
        },
        {
            id:1,
            url:'/uu-dai',
            image:'/images/banners/banner_1.webp'
        },
            {
            id:0,
            url:'/uu-dai',
            image:'/images/banners/banner_5.avif'
        },
        {
            id:2,
            url:'/uu-dai',
            image:'/images/banners/banner_2.webp'
        },
      
        {
            id:3,
            url:'/uu-dai',
            image:'/images/banners/banner_3.webp'
        },
        {
            id:4,
            url:'/uu-dai',
            image:'/images/banners/banner_4.webp'
        },

    ]
  return (
    <div className='w-content m-auto '>
        <div className="w-full ">
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
                      <div className="h-[165px] w-full relative rounded-lg">
                        <Image
                          src={item.image}
                          fill
                          className="h-full w-full object-cover rounded-lg"
                          alt={'banner'+item.id}
                          title={'banner'+item.id}
                        />
                      </div>
                    </SwiperSlide>
                  );
                })}
            </Swiper>
        </div>
    </div>
  )
}

export default Banner