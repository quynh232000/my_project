'use client';

import Image from "next/image";
import { useMemo } from "react";

type RawPlace = {
  name: string;
  src: string;
};

type Place = RawPlace & {
  x: number;
  y: number;
  size: number;
};

// Config constants
const maxWidth = 1000;
const maxHeight = 500;
const minSize = 120;
const maxSize = 200;
const padding = 16;
const maxTries = 500;


// Data input
const rawPlaces: RawPlace[] = [
  { name: 'Hồ Chí Minh', src: '/images/common/hotel_1.jpg' },
  { name: 'Vũng Tàu', src: '/images/common/hotel_2.jpg' },
  { name: 'Đà Lạt', src: '/images/common/hotel_3.jpg' },
  { name: 'Phan Thiết', src: '/images/common/hotel_4.jpg' },
  { name: 'Đà Nẵng', src: '/images/common/hotel_4.jpg' },
  { name: 'Quy Nhơn', src: '/images/common/hotel_4.jpg' },
  { name: 'Phú Quốc', src: '/images/common/hotel_3.jpg' },
  { name: 'Hội An', src: '/images/common/hotel_3.jpg' },
  { name: 'Hà Nội', src: '/images/common/hotel_3.jpg' },
  { name: 'Hạ Long', src: '/images/common/hotel_3.jpg' },
  { name: 'Nha Trang', src: '/images/common/hotel_3.jpg' },
  { name: 'Sa Pa', src: '/images/common/hotel_3.jpg' },
];

// Utility functions
function randomInt(min: number, max: number): number {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function distance(a: { x: number; y: number }, b: { x: number; y: number }): number {
  return Math.sqrt((a.x - b.x) ** 2 + (a.y - b.y) ** 2);
}

// Main function to place bubbles
function generatePlaces(raw: RawPlace[]): Place[] {
  const placed: Place[] = [];

  for (let i = 0; i < raw.length; i++) {
    const { name, src } = raw[i];
    const size = maxSize - Math.floor((i / raw.length) * (maxSize - minSize));
    let found = false;
    let x = 0;
    let y = 0;

    for (let attempt = 0; attempt < maxTries; attempt++) {
      x = randomInt(-maxWidth / 2 + size / 2, maxWidth / 2 - size / 2) ;
      y = randomInt(-maxHeight / 2 + size / 2, maxHeight / 2 - size / 2) -150;

      const overlapping = placed.some((p) => {
        const d = distance({ x, y }, p);
        return d < (size + p.size) / 2 + padding;
      });

      if (!overlapping) {
        found = true;
        break;
      }
    }

    if (!found) {
      console.warn(`⚠️ Bubble ${i} fallback used`);
    }

    placed.push({ name, src, x, y, size });
  }

  return placed;
}
export default function PopularPlaces() {
   const places = useMemo(() => generatePlaces(rawPlaces), []);
  return (
    // <div className='w-content m-auto'>
    //     <div className=" w-full mt-8  flex flex-col">
    //         <h2 className="text-center text-lg font-semibold mb-4">
    //             Địa điểm hot nhất do Mytour đề xuất
    //         </h2>
    //        <div className="relative w-full h-[500px] mx-auto">
    //         {places.map((place, index) => (
    //             <div
    //             key={index}
    //             className="absolute rounded-full overflow-hidden shadow-md group cursor-pointer"
                
    //            style={{
    //                     width: place.size,
    //                     height: place.size,
    //                     left: '50%',
    //                     top: '50%',
    //                     transform: `translate(${place.x}px, ${place.y}px)`,
    //                 }}
    //             >
    //             <Image
    //                 src={place.src}
    //                 alt={place.name}
    //                 fill
    //                 className="object-cover transition-transform duration-300 group-hover:scale-110"
    //             />
    //             <div className="absolute bottom-0 w-full bg-gradient-to-t from-black/60 to-transparent text-white text-center text-sm p-1">
    //                 {place.name}
    //             </div>
    //             </div>
    //         ))}
    //         </div>
            
    //     </div>
    // </div>
    <div className="w-full max-w-7xl mx-auto px-4">
      <div className="flex flex-col mt-10">
       <div className="pb-10">
            <h2 className=" text-xl font-bold ">
            Điểm đến yêu thích
            </h2>
            <div className="text-[14px] text-gray-600">Địa điểm hot nhất do Mytour đề xuất</div>
       </div>

        <div className=" w-full h-[600px]">
           {places.map((place, index) => (
          <div
            key={index}
            className=" rounded-full overflow-hidden shadow-md group cursor-pointer transition-transform"
            style={{
              width: place.size,
              height: place.size,
              left: '50%',
              top: '50%',
              transform: `translate(${place.x}px, ${place.y}px)`,
            }}
          >
            <Image
              src={place.src}
              alt={place.name}
              fill
              className="object-cover transition-transform duration-300 group-hover:scale-110"
            />
            <div className="absolute bottom-0 w-full bg-gradient-to-t from-black/60 to-transparent text-white text-center text-sm p-1">
              {place.name}
            </div>
          </div>
        ))}
        </div>
      </div>
    </div>
  );
}
