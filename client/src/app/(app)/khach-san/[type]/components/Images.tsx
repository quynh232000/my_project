'use client';
import { Dialog, DialogBody, IconButton } from '@material-tailwind/react';
import Image from 'next/image';
import { useState, useRef } from 'react';
import { FaXmark, FaChevronLeft, FaChevronRight } from 'react-icons/fa6';
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

export default function Images({ images ,type}: ImagesProps) {
  const [open, setOpen] = useState(false);
  const [selectedIndex, setSelectedIndex] = useState(0);
  const swiperRef = useRef<any>(null);

  const safeImages = images?.length ? images : [{ id: 0, image: DEFAULT_IMAGE,label:{name:'',id:''} }];
  const showImages = safeImages.slice(0, 5);
  const remaining = safeImages.length - 5;

  const handleClick = (index: number) => {
    setSelectedIndex(index);
    setOpen(true);
    setTimeout(() => {
      if (swiperRef.current) {
        swiperRef.current.slideTo(index);
      }
    }, 100);
  };

  const handlePrev = () => swiperRef.current?.slidePrev();
  const handleNext = () => swiperRef.current?.slideNext();

  return (
    <>
      {/* Thumbnail grid */}
      <div className={" gap-1 rounded-2xl overflow-hidden my-4 "+ (type && type == 'room' ? 'flex flex-col':'grid grid-cols-2')}>
        <div
          className={"relative w-full  cursor-pointer group overflow-hidden border border-primary-100 " + (type ? 'h-[150px]':'h-[340px]')}
          onClick={() => handleClick(0)}
        >
          <Image
            alt="Preview"
            fill
            loading="lazy"
            className="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300"
            src={safeImages[0].image || DEFAULT_IMAGE}
          />
        </div>

        <div className="grid grid-cols-2 gap-1">
          {showImages.slice(1).map((item, idx) => (
            <div
              key={item.id}
              className={"relative w-full  cursor-pointer group overflow-hidden border border-primary-100 "+(type ? 'h-[50px]':' h-[168px]')}
              onClick={() => handleClick(idx + 1)}
            >
              <Image
                alt={`Sub image ${idx + 1}`}
                fill
                loading="lazy"
                className="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300"
                src={item.image || DEFAULT_IMAGE}
              />
              {idx === 3 && remaining > 0 && (
                <div className="absolute inset-0 bg-black/50 text-white text-lg font-semibold flex items-center justify-center z-10 rounded-2xl">
                  +{remaining}
                </div>
              )}
            </div>
          ))}
        </div>
      </div>

      {/* Modal Gallery */}
      <Dialog
      {...({} as any)}
        open={open}
        handler={() => setOpen(false)}
        size="xl"
        className="bg-black/80 backdrop-blur-md shadow-2xl rounded-2xl"
      >
        <DialogBody  {...({} as any)} className="relative p-0 bg-black/80 rounded-2xl ">
          {/* Close Button */}
          <IconButton  {...({} as any)}
            variant="text"
            color="white"
            onClick={() => setOpen(false)}
            className="!absolute top-4 right-4 z-10"
          >
            <FaXmark className="h-6 w-6" />
          </IconButton>

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
          <div className='p-5'>
            <Swiper
            modules={[A11y, EffectFade,Autoplay]}
            effect="fade"
            autoplay={{ delay: 3000, disableOnInteraction: false }}
            fadeEffect={{ crossFade: true }}
            initialSlide={selectedIndex}
            onSwiper={(swiper) => (swiperRef.current = swiper)}
            onSlideChange={(swiper) => setSelectedIndex(swiper.activeIndex)}
            slidesPerView={1}
            className="bg-black/80 h-[80vh] flex items-center justify-center"
          >
            {safeImages.map((item, idx) => (
              <SwiperSlide key={item.id || idx} className="flex justify-center items-center relative pb-10">
                <div className="w-auto h-full max-w-[90vw] max-h-[80vh] flex items-center justify-center p-5 rounded-xl">
                  <Image
                    alt="Gallery image"
                    src={item.image || DEFAULT_IMAGE}
                    loading="lazy"
                    width={1000}
                    height={800}
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
          <div className="px-4 pb-6 rounded-2xl pt-0 bg-black">
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
                  className="!w-[80px] !h-[80px] py-1"
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
        </DialogBody>
      </Dialog>
    </>
  );
}
