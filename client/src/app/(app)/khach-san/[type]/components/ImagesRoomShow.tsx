'use client';
import Image from 'next/image';
import { useState, useRef } from 'react';
import {  FaChevronLeft, FaChevronRight } from 'react-icons/fa6';
import { Swiper, SwiperSlide } from 'swiper/react';
import { A11y, Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-fade';
import { hotelImage } from '@/services/app/hotel/SGetHotelDetail';


interface ImagesProps {
  images: hotelImage[];
  type?:string
}

const DEFAULT_IMAGE = '/images/common/hotel_11.jpg';

export default function ImagesRoomShow({ images}: ImagesProps) {
  const [selectedIndex, setSelectedIndex] = useState(0);
  const swiperRef = useRef<any>(null);

  const safeImages = images?.length ? images : [{ id: 0, image: DEFAULT_IMAGE,label:{name:'',id:''} }];


  const handlePrev = () => swiperRef.current?.slidePrev();
  const handleNext = () => swiperRef.current?.slideNext();

  return (
      <div className={"  flex flex-col  w-full h-full gap-2  relative"}>
          {/* Prev / Next Buttons */}
          {safeImages.length > 1 && (
            <>
              <button
                onClick={handlePrev}
                className="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full z-10"
              >
                <FaChevronLeft className="w-5 h-5" />
              </button>
              <button
                onClick={handleNext}
                className="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full z-10"
              >
                <FaChevronRight className="w-5 h-5" />
              </button>
            </>
          )}

          {/* Main Swiper */}
          <div className=' w-full flex-1 px-5'>
            <Swiper
              modules={[A11y, EffectFade,Autoplay]}
              effect="fade"
              autoplay={{ delay: 3000, disableOnInteraction: false }}
              fadeEffect={{ crossFade: true }}
              initialSlide={selectedIndex}
              onSwiper={(swiper) => (swiperRef.current = swiper)}
              onSlideChange={(swiper) => setSelectedIndex(swiper.activeIndex)}
              slidesPerView={1}
              className=" flex items-center justify-center h-full"
            >
              {safeImages.map((item, idx) => (
                <SwiperSlide key={item.id || idx} className="flex justify-center items-center relative h-full">
                  <div className=" flex items-center justify-center p-5 rounded-xl h-full">
                    <Image
                      alt="Gallery image"
                      src={item.image || DEFAULT_IMAGE}
                      loading="lazy"
                     fill
                      className="object-cover w-full h-full rounded-2xl shadow-xl overflow-hidden"
                    />
                  </div>
                  <div className=' absolute bottom-2 font-semibold text-white flex justify-between left-0 right-0 px-5 '>
                    <div className=''>
                      {item.label.name??'Unknown'}
                    </div>
                    <div>{idx+1} / {safeImages.length??0}</div>
                  </div>
                </SwiperSlide>
              ))}
            </Swiper>
          </div>

          {/* Thumbnail Swiper */}
          <div className=" px-5">
            <Swiper
              modules={[A11y]}
              spaceBetween={12}
              slidesPerView="auto"
              className="px-2"
            >
              {safeImages.map((item, idx) => (
                <SwiperSlide
                  key={item.id}
                  style={{ width: '80px' }}
                  className="!w-[80px] !h-[80px] p-1"
                >
                  <div
                    onClick={() => {
                      setSelectedIndex(idx);
                      swiperRef.current?.slideTo(idx);
                    }}
                    className={`relative w-full h-full rounded-xl overflow-hidden cursor-pointer border-2 transition-all duration-300 ${
                      idx === selectedIndex
                        ? 'border-primary-500 scale-105'
                        : 'border-transparent hover:border-gray-400'
                    }`}
                  >
                    <Image
                      alt={`thumb-${idx}`}
                      src={item.image || DEFAULT_IMAGE}
                      fill
                      loading="lazy"
                      className="object-cover"
                    />
                  </div>
                </SwiperSlide>
              ))}
            </Swiper>
          </div>

      </div>
    
  );
}
