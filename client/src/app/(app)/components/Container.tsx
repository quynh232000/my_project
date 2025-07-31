'use client'
import React, {  useState } from 'react'
import NavHead from './NavHead'
import SearchHead from './SearchHead'
import Banner from './Banner'
import Image from 'next/image'
import Flashsale from './Flashsale'
import PopularPlaces from './PopularPlaces'
import BestFlight from './BestFlight'
import BestPriceHotel from './BestPriceHotel'
import ChainHotel from './ChainHotel'
import BannerBottom from './BannerBottom'


function Container() {
    const [navActiveKey,setNavActiveKey] = useState('khach-san')

    

  return (
    <div className=' flex flex-col gap-8'>
        <div className='relative flex flex-col gap-8'>
            <div className='relative w-full h-[460px] -z-[1]'>
                <Image
                src={"/images/banners/banner1.jpg"}
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
        <Banner/>
        <Flashsale/>
        <BestFlight/>
        <BestPriceHotel/>
        <ChainHotel/>
		<PopularPlaces/>
        <BannerBottom/>
	</div>
  )
}

export default Container