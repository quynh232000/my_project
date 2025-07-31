'use client'

import React, { useEffect, useState } from 'react'
import Slider from './Slider'
import Image from 'next/image'
import { Button } from '@material-tailwind/react'
import { IPostCategoryItem, SGetPostCategoryList } from '@/services/app/post-category/SGetPostCategoryList'
import { FormatDate } from '@/utils/common'
import Link from 'next/link'
import SkeBlogList from '@/components/shared/Skeleton/SkeBlogList'

function Container() {
  const [data,setData] = useState<IPostCategoryItem[]>([])
  const [isLoading,setIsLoading] = useState(true)
   useEffect(()=>{
    setIsLoading(true)
      SGetPostCategoryList({limit:8,slug:'news',with_items:true}).then(res=>{
        setIsLoading(false)

        if(res) setData(res)
      })
   },[])
  return (
    <div>
        <Slider/>
        
        <div className='w-content m-auto py-12 flex flex-col gap-12'>
          {isLoading ? <><SkeBlogList/><SkeBlogList/> </> :  (data && data.map(item=>{
            return <div key={item.id}>
              <h2 className='font-bold text-2xl'>{item.name}</h2>
              <div className='grid grid-cols-4 gap-5 mt-5'>
                {item.items.map(post=>{
                  return <Link href={'/blog/'+item.slug+'/'+post.slug} key={post.id} className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={post.image ??'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>{post.name}
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>{FormatDate(post.created_at)}</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>{post.author.full_name}</div>
                    </div>
                </Link>
                })}
              </div>
              <div className='flex justify-center mt-8'>
                <Link href={'/blog/'+item.slug}><Button  {...({} as any)} className='border bg-primary-50 border-primary-500 text-primary-500 hover:bg-primary-100 px-12'> Xem thêm</Button></Link>
              </div>
            </div>
          }))}
            
           
            
            {/* social */}
            <div className='grid grid-cols-2 gap-5'>
              <div className='border shadow-lg rounded-2xl p-5'>
                <div className='flex justify-between items-center'>
                  <div className=' relative h-[36px] w-[116px] '>
                        <Image
                        fill
                        alt=''
                        src={'/images/icon/tiktok.webp'}
                        className='  w-full h-full'
                        />
                    </div>
                    <div className='flex items-center gap-3'>
                      <div>
                        <div className='font-semibold text-right text-lg'>103,5k</div>
                        <div className='text-[14px] font-semibold'>Người theo dõi</div>
                      </div>
                      <div className='bg-red-500 text-white py-2 px-2 text-[14px] rounded-xl hover:cursor-pointer hover:bg-red-600'>Theo dõi</div>
                    </div>
                </div>
                <div className=' grid grid-cols-3 gap-3 mt-5'>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                </div>
              </div>
              <div className='border shadow-lg rounded-2xl p-5'>
                <div className='flex justify-between items-center'>
                  <div className=' relative h-[36px] w-[126px] '>
                        <Image
                        fill
                        alt=''
                        src={'/images/icon/youtube.webp'}
                        className='  w-full h-full'
                        />
                    </div>
                    <div className='flex items-center gap-3'>
                      <div>
                        <div className='font-semibold text-right text-lg'>103,5k</div>
                        <div className='text-[14px] font-semibold'>Người theo dõi</div>
                      </div>
                      <div className='bg-red-500 text-white py-2 px-2 text-[14px] rounded-xl hover:cursor-pointer hover:bg-red-600'>Theo dõi</div>
                    </div>
                </div>
                <div className=' grid grid-cols-3 gap-3 mt-5'>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <div className=' relative h-[182px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  )
}

export default Container