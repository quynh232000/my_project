import Pagination from '@/components/shared/Pagination/Pagination'
import SkeHotelFilter from '@/components/shared/Skeleton/SkeHotelFilter'
import { Daum } from '@/services/app/hotel/SGetHotelFilter'
import { FormatPrice } from '@/utils/common'
import Image from 'next/image'
import Link from 'next/link'
import React from 'react'
import { FaAngleRight, FaHeart, FaLocationDot, FaStar } from 'react-icons/fa6'

function ListHotel({data,loading,total,limit}:{data:Daum[],loading:boolean,total:number,limit:number}) {
  return (
    <div>
        <div className='flex flex-col gap-5'>
            {loading && Array.from({ length: 3 }).map((_, i) => (
                        <SkeHotelFilter key={i} />
                        ))}
              {data.map(item=>
                <div key={item.id} className='border p-3 rounded-lg bg-white flex gap-4'>
                    <div className=' relative w-[230px] h-[180px]'>
                        <Image
                            alt=''
                            fill
                            src={item.image??'/images/common/hotel_1.jpg'}
                            className='rounded-lg object-cover w-full h-full'
                        />
                        <span className=' absolute text-white top-2 right-2 text-lg'><FaHeart/></span>
                    </div>
                    <div className='flex flex-col gap-1 flex-1'>
                        <h2 className='flex flex-wrap items-center gap-2 text-lg font-semibold hover:text-primary-500'>{item.name}
                            <span className='flex text-yellow-500 text-sm gap-[1px]'>
                                 {Array.from({ length: item.stars ? +item.stars : 1 }, (_, index) => <span key={index}> <FaStar/></span> )}
                            </span>
                        </h2>
                        <div className='flex gap-2'>
                            <span className='bg-primary-500 text-white rounded-tl-xl rounded-tr-md rounded-br-lg font-semibold px-2 py-1 text-[14px]'>{item.stars??0}</span>
                            <span className='text-primary-500 font-semibold'>Rất tốt</span>
                            <span className='text-gray-500 text-[14px]s'>({item.stars??0} đánh giá)</span>
                        </div>
                        <div className='flex items-center gap-2 text-[14px] text-gray-600'>
                            <FaLocationDot/>
                            <span>{item.location.ward_name+', '+item.location.province_name+', '+item.location.country_name}</span>
                            {/* <Link href={'#'} className='text-secondary-500 underline text-[14px]'>Xem bản đồ</Link> */}
                        </div>
                        <div className='bg-gray-50 w-full p-2 flex flex-col gap-1'>
                            <div className='flex text-[12px] justify-between items-center'>
                                <span className='text-yellow-500 text-[14px]'>Xác nhận ngay</span>
                                <div className='flex items-center'>
                                    <span className='bg-primary-100 text-primary-500 px-1 py-[2px] rounded-lg'>Áp dụng mã <strong>QUINBOOKING1</strong> giảm 238.000đ</span>
                                    <div className='bg-primary-500 text-white rounded-tl-xl rounded-tr-md rounded-br-lg font-semibold ml-2 py-[2px] px-1'>
                                        -19%
                                    </div>
                                </div>
                            </div>
                            <div className='flex justify-end gap-2 items-center'>
                                {/* <del className='text-gray-600 text-[14px]'>{FormatPrice(5980000)}</del> */}
                                <i className="text-gray-600">Chỉ từ</i>
                                <div className='text-xl font-semibold'>{FormatPrice(item.avg_price)}</div>
                            </div>
                            <div className='flex justify-end'>
                                <Link href={'/khach-san/'+item.slug} className='flex items-center gap-2 bg-primary-500 text-white py-2 px-3 rounded-lg hover:bg-primary-600 text-[14px] font-semibold'>Xem phòng <FaAngleRight /></Link>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </div>
        <div>
                            <Pagination total={total} limit={limit} />
                    </div>
    </div>
  )
}

export default ListHotel