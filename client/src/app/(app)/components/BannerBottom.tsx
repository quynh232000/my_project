import { CheckCircle } from 'lucide-react'
import Image from 'next/image'
import React from 'react'

function BannerBottom() {
  return (
    <div className='w-content m-auto my-10'>
        <div className=' relative w-full h-full'>
            <div className=' relative w-full h-[460px]'>
                <Image
                alt=''
                fill
                 className='w-full h-full object-cover rounded-3xl'
                 src={'/images/common/bg-bottom.png'}
                />
            </div>
            <div className=' absolute top-0 left-0 bottom-0 right-0 text-white'>
                <div className='p-24 w-[65%]'>
                    <h2 className='text-2xl font-semibold'>Trải nghiệm sự tiện lợi cùng ứng dụng QuinBooking và tiếp cận những ưu đãi độc quyền</h2>
                    <div className="my-5 text-xl">
                        Đặt vé máy bay, khách sạn hạng sang
                    </div>
                    <div className='flex gap-5'>
                        <div className='border-r pr-5 flex flex-col gap-2'>
                            <div className='flex items-center gap-2 text-[14px]'>
                                <CheckCircle size={18}/>
                                <span>Giá tốt hơn so với đặt phòng trực tiếp tại khách sạn</span>
                            </div>
                            <div className='flex items-center gap-2 text-[14px]'>
                                <CheckCircle size={18}/>
                                <span>Nhân viên chăm sóc, tư vấn nhiều kinh nghiệm</span>
                            </div>
                            <div className='flex items-center gap-2 text-[14px]'>
                                <CheckCircle size={18}/>
                                <span>Hơn 5000 khách sạn tại Việt Nam với đánh giá thực</span>
                            </div>
                            <div className='flex items-center gap-2 text-[14px]'>
                                <CheckCircle size={18}/>
                                <span>Nhiều chương trình khuyến mãi và tích lũy điểm</span>
                            </div>
                            <div className='flex items-center gap-2 text-[14px]'>
                                <CheckCircle size={18}/>
                                <span>Thanh toán dễ dàng, đa dạng</span>
                            </div>
                        </div>
                        <div className='w-[130px] h-[130px] relative border-2 border-white rounded-lg p-1'>
                            <Image
                                alt=''
                                className='rounded-lg object-cover w-full h-full'
                                fill
                                src={"/images/common/qrcode.svg"}
                            />
                        </div>
                    </div>
                
                </div>
            </div>

        </div>
    </div>
  )
}

export default BannerBottom