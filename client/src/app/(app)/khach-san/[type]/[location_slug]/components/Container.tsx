'use client';
import SearchHead from '@/app/(app)/components/SearchHead'
import Link from 'next/link';
import React, { useEffect, useState } from 'react'
import SideBar from './SideBar';
import ListHotel from './ListHotel';
import { IHotelCategoryDetail, SGetHotelCategoryDetail } from '@/services/app/hotel/SGetHotelCategoryDetail';
import { propsFilter, SGetHotelFilter } from '@/services/app/hotel/SGetHotelFilter';
import { IHotelFilter } from './../../../../../../services/app/hotel/SGetHotelFilter';
import { useSearchParams } from 'next/navigation';

const sortOptions = [
  { label: 'Phù hợp nhất', value: 'popular',direction:'asc' },
  { label: 'Giá thấp nhất', value: 'price' ,direction:'asc'},
  { label: 'Giá cao nhất', value: 'price' ,direction:'desc'},
];

function Container({type,slug}:{type:string,slug:string}) {
    const [CategoryData,setCategoryData] = useState<IHotelCategoryDetail|null>(null)
    const [hotelData,setHotelData] = useState<IHotelFilter|null>(null)
    const [filters, setFilters] = useState<propsFilter>({ type, slug,sort:'popular',direction:'asc'});
    const [loading,setLoading] = useState({
        hotel:true,
        sidebar:true
    })
    const searchParams = useSearchParams();    
    const page = Number(searchParams.get('page')) || 1
    const limit = 6

    useEffect(()=>{
        SGetHotelCategoryDetail({type,slug}).then(res=>{
            setLoading({...loading,sidebar:false})
            if(res) setCategoryData(res)
        })
    },[type,slug])

    useEffect(()=>{
        setLoading({...loading,hotel:true})
        SGetHotelFilter({...filters,page,limit}).then(res=>{
             setLoading({sidebar:false,hotel:false})
            if(res) setHotelData(res)
        })
    },[type,slug,filters,page])
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
                <SideBar CategoryData={CategoryData ? CategoryData:undefined} loading={loading.sidebar} filters={filters}
                    setFilters={setFilters}/>
            </div>
            <div className='flex-1 flex flex-col gap-5'>
                <div className='flex items-center gap-2 border shadow-md w-full px-4 py-2 rounded-md bg-white'>
                    <span>Sắp xếp:</span>
                    <div className='flex gap-2 text-[14px] font-semibold'>
                        {sortOptions.map(option => (
                            <div
                            key={option.value+option.direction}
                            onClick={() => setFilters({...filters,sort:option.value,direction:option.direction})}
                            className={`py-2 px-3 rounded-lg cursor-pointer
                                ${
                                (filters.sort === option.value && filters.direction === option.direction)
                                    ? 'text-white bg-primary-500 hover:bg-primary-600'
                                    : 'hover:text-white hover:bg-primary-600'
                                }`}
                            >
                            {option.label}
                            </div>
                        ))}
                    </div>
                </div>
               { <ListHotel data={hotelData?.data ?? []} loading={loading.hotel} total={hotelData?.meta.total_item??0} limit={limit}/>}
            </div>
        </div>
    </div>
  )
}

export default Container