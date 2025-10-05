'use client';
import Flashsale from "@/app/(app)/components/Flashsale";
import NavHead from "@/app/(app)/components/NavHead"
import SearchHead from "@/app/(app)/components/SearchHead"
import Image from "next/image"
import { useEffect, useState } from "react"
import Voucher from "./Voucher";
import PopularPlaces from "@/app/(app)/components/PopularPlaces";
import BestPriceHotel from "@/app/(app)/components/BestPriceHotel";
import { IHotelList, SGetHotelList } from "@/services/app/home/SGetHotelList";


function Container() {
    const [navActiveKey,setNavActiveKey] = useState('khach-san')

     const [hotels,setHotels] = useState<IHotelList|null>(null)
        const [loading,setLoading] = useState({
            hotel:true
        })
    
        useEffect(()=>{
            setLoading({...loading,hotel:true})
            SGetHotelList().then(res=>{
                 setLoading({...loading,hotel:false})
                if(res)setHotels(res)
            })
        },[])
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
         <Flashsale data={hotels?.trending} loading={loading.hotel}/>
        <PopularPlaces/>

       {<BestPriceHotel  data={hotels?.best_price} loading={loading.hotel}/>}
    </div>
  )
}

export default Container