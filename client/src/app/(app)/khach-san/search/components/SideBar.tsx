import { Checkbox } from '@material-tailwind/react'
import React from 'react'
import { FaStar } from 'react-icons/fa6'

function SideBar() {
  return (
    <div className='w-full border-sm shadow-sm bg-white'>
        <div className='p-4 border-b'>
            <div className='text-[14px] font-semibold mb-1'>Hạng khách sạn</div>
            <div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                        
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                       
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        <FaStar/>
                        
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        
                    </div>
                </div>
            </div>
        </div>
        <div className='p-4 border-b'>
            <div className='text-[14px] font-semibold mb-1'>Dịch vụ đi kèm</div>
            <div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                        Ăn sáng miễn phí
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                       Hủy linh hoạt
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                       Khuyễn mãi giảm giá
                    </div>
                </div>
            </div>
            
        </div>
        <div className='p-4 border-b'>
            <div className='text-[14px] font-semibold mb-1'>Loại khách sạn</div>
            <div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                       Khách sạn <span className='text-gray-500'>(690)</span>
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                       Khách sạn căn hộ <span className='text-gray-500'>(690)</span>
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                      Khu nghỉ dưỡng <span className='text-gray-500'>(690)</span>
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                      Nhà nghỉ <span className='text-gray-500'>(690)</span>
                    </div>
                </div>
            </div>
            
        </div>
        <div className='p-4 border-b'>
            <div className='text-[14px] font-semibold mb-1'>Tiện nghi</div>
            <div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                      Miễn phí bữa sáng <span className='text-gray-500'>(690)</span>
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                      Đưa/ đón khách sân bay <span className='text-gray-500'>(690)</span>
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                     Đưa/ đón khách bến phà <span className='text-gray-500'>(690)</span>
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 '>
                     Cho thuê xe máy <span className='text-gray-500'>(690)</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
  )
}

export default SideBar