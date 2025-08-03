'use client';
import SearchHead from '@/app/(app)/components/SearchHead'
import Link from 'next/link';
import React, { useEffect, useState } from 'react'
import SideBar from './SideBar';
import ListHotel from './ListHotel';
import { IHotelCategoryDetail, SGetHotelCategoryDetail } from '@/services/app/hotel/SGetHotelCategoryDetail';
import { propsFilter, SGetHotelFilter } from '@/services/app/hotel/SGetHotelFilter';
import { IHotelFilter } from './../../../../../../services/app/hotel/SGetHotelFilter';

function Container({type,slug}:{type:string,slug:string}) {
    const [CategoryData,setCategoryData] = useState<IHotelCategoryDetail|null>(null)
    const [hotelData,setHotelData] = useState<IHotelFilter|null>(null)
    const [filters, setFilters] = useState<propsFilter>({ type, slug});
    const [loading,setLoading] = useState({
        hotel:true
    })

    useEffect(()=>{
        SGetHotelCategoryDetail({type,slug}).then(res=>{
            if(res) setCategoryData(res)
        })
    },[type,slug])

    useEffect(()=>{
        setLoading({...loading,hotel:true})
        SGetHotelFilter({...filters}).then(res=>{
             setLoading({...loading,hotel:false})
            if(res) setHotelData(res)
        })
    },[type,slug,filters])
    return (
    <div className='w-content m-auto flex flex-col gap-6 py-10'>
        <div>
            <SearchHead navActiveKey='khach-san' className="border rounded-lg shadow-lg"/>
        </div>
        <div className='flex gap-1 text-[14px] text-gray-600'>
            <Link href={'/khach-san'}>Khách sạn</Link>
            <div>/</div>
            <Link href={'/khach-san'}>{CategoryData?.info?.name}</Link>
        </div>
        <h2 className='text-xl font-semibold'>{hotelData?.meta.total_item ?? 0} Khách sạn tại {CategoryData?.info?.name}</h2>
        <div className='flex gap-8'>
            <div className='w-[30%]'>
              {CategoryData &&  <SideBar CategoryData={CategoryData} filters={filters}
                    setFilters={setFilters}/>}
            </div>
            <div className='flex-1 flex flex-col gap-5'>
                <div className='flex items-center gap-2 border shadow-md w-full px-4 py-2 rounded-md bg-white'>
                    <span>Sắp xếp:</span>
                    <div className='flex gap-2 text-[14px] font-semibold'>
                        <div className='text-white bg-primary-500 py-2 px-3 rounded-lg hover:bg-primary-600 cursor-pointer'>Phù hợp nhất</div>
                        <div className='hover:text-white  py-2 px-3 rounded-lg hover:bg-primary-600 cursor-pointer'>Phù hợp nhất</div>
                        <div className='hover:text-white  py-2 px-3 rounded-lg hover:bg-primary-600 cursor-pointer'>Phù hợp nhất</div>
                    </div>
                </div>
               { <ListHotel data={hotelData?.data ?? []} loading={loading.hotel}/>}
            </div>
        </div>
    </div>
  )
}

export default Container