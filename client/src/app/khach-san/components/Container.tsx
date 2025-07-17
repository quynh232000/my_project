'use client';
import Flashsale from "@/app/components/Flashsale";
import NavHead from "@/app/components/NavHead"
import SearchHead from "@/app/components/SearchHead"
import Image from "next/image"
import { useState } from "react"
import Voucher from "./Voucher";
import PopularPlaces from "@/app/components/PopularPlaces";
import BestPriceHotel from "@/app/components/BestPriceHotel";


function Container() {
    const [navActiveKey,setNavActiveKey] = useState('khach-san')
  return (
    <div className="flex flex-col gap-12">
         <div className='relative flex flex-col gap-8'>
            <div className='relative w-full h-[460px] -z-[1]'>
                <Image
                src={"/images/banners/hotel_banner1.png"}
                alt='banner'
                fill
                className="object-cover filter brightness-90"
                />
            </div>
            <div className="absolute  top-0 left-0 right-0 bottom-0 d-flex justify-center pt-[60px]">
                <div className='w-content m-auto bg-white rounded-lg'>
                    <NavHead  setNavActiveKey={setNavActiveKey}/>
                    <SearchHead navActiveKey={navActiveKey}/>
                </div>
            </div>
        </div>
        <Voucher/>
        <Flashsale/>
        <PopularPlaces/>
        <BestPriceHotel/>
    </div>
  )
}

export default Container