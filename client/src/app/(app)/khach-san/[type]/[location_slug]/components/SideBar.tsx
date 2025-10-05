import { Checkbox } from '@material-tailwind/react'
import React from 'react'
import { FaStar } from 'react-icons/fa6'
import { IHotelCategoryDetail } from '@/services/app/hotel/SGetHotelCategoryDetail';
import { propsFilter } from '@/services/app/hotel/SGetHotelFilter';
import SkeSideBar from '@/components/shared/Skeleton/SkeSideBar';
function SideBar({CategoryData,filters,setFilters,loading}:{CategoryData?:IHotelCategoryDetail,loading:boolean,filters:propsFilter,setFilters: React.Dispatch<React.SetStateAction<propsFilter>>}) {
  function handleToggle(field: keyof propsFilter, value: number) {
  setFilters((prev: propsFilter) => {
    const currentArray = (prev[field] as number[]) || [];

    const newArray = currentArray.includes(value)
      ? currentArray.filter(v => v !== value)
      : [...currentArray, value];

    return {
      ...prev,
      [field]: newArray,
    };
  });
}
  return (
    <div className='w-full border-sm shadow-sm bg-white'>
       
        <div className='p-4 border-b'>
            <div className='text-[14px] font-semibold mb-1'>Hạng khách sạn</div>
            <div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} 
                        checked={(filters?.stars||[])?.includes(5)}
                        onChange={() => handleToggle('stars', 5)}
                    color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} checked={(filters?.stars||[])?.includes(4)}
                        onChange={() => handleToggle('stars', 4)} color="purple" className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                        
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" checked={(filters?.stars||[])?.includes(3)}
                        onChange={() => handleToggle('stars', 3)} className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        <FaStar/>
                        <FaStar/>
                       
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" checked={(filters?.stars||[])?.includes(2)}
                        onChange={() => handleToggle('stars', 2)} className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        <FaStar/>
                        
                    </div>
                </div>
                <div className='flex items-center '>
                    <Checkbox {...({} as any)} color="purple" checked={(filters?.stars||[])?.includes(1)}
                        onChange={() => handleToggle('stars', 1)} className='rounded-lg'  />
                    <div className='flex gap-1 text-yellow-500'>
                        <FaStar/>
                        
                    </div>
                </div>
            </div>
        </div>
         {loading && <div>
                <SkeSideBar/>
                <SkeSideBar/>
                <SkeSideBar/>

            </div>}
        {CategoryData?.accommodation && 
         <div className='p-4 border-b'>
            <div className='text-[14px] font-semibold mb-1'>Loại khách sạn</div>
            <div>
                {CategoryData?.accommodation.map(item=>{
                    return <div className='flex items-center ' key={item.id}>
                                <Checkbox {...({} as any)} checked={(filters?.accommodation_id || [])?.includes(item.id)}
                                onChange={() => handleToggle('accommodation_id', item.id)} 
                                id={'accommodation'+item.id} color="purple" className='rounded-lg'  />
                                <label htmlFor={'accommodation'+item.id} className='flex gap-1 '>
                                {item.name}
                                </label>
                            </div>
                })}
            </div>
        </div>  
        }
        {CategoryData?.chains && 
         <div className='p-4 border-b'>
            <div className='text-[14px] font-semibold mb-1'>Thương hiệu</div>
            <div>
                {CategoryData?.chains.map(item=>{
                    return <div className='flex items-center ' key={item.id}>
                                <Checkbox {...({} as any)} id={'chains'+item.id} checked={(filters?.chain_ids || [])?.includes(item.id)}
                                onChange={() => handleToggle('chain_ids', item.id)} color="purple" className='rounded-lg'  />
                                <label htmlFor={'chains'+item.id} className='flex gap-1 '>
                               {item.name}
                                </label>
                            </div>
                })}
            </div>
        </div>  
        }
        {CategoryData?.amenities && 
         <div className='p-4 border-b'>
            <div className='text-[14px] font-semibold mb-1'>Dịch vụ</div>
            <div>
               {CategoryData?.facilities.map(item=>{
                    return <div className='flex items-center ' key={item.id}>
                                <Checkbox {...({} as any)}  checked={(filters?.facilities|| [])?.includes(item.service_id)}
                                onChange={() => handleToggle('facilities', item.service_id)} id={'facilities'+item.id} color="purple" className='rounded-lg'  />
                                <label htmlFor={'facilities'+item.id} className='flex gap-1 '>
                               {item.facility.name}
                                </label>
                            </div>
                })}
            </div>
        </div>  
        }
         {CategoryData?.facilities && 
         <div className='p-4 border-b'>
            <div className='text-[14px] font-semibold mb-1'>Tiện nghi</div>
            <div>
                
                 {CategoryData?.amenities.map(item=>{
                    return <div className='flex items-center ' key={item.id}>
                                <Checkbox {...({} as any)} checked={(filters?.amenities || [])?.includes(item.service_id)}
                            onChange={() => handleToggle('amenities', item.service_id)} id={'amenities'+item.id} color="purple" className='rounded-lg'  />
                                <label htmlFor={'amenities'+item.id} className='flex gap-1 '>
                               {item.amenity.name}
                                </label>
                            </div>
                })}
            </div>
        </div>  
        }
       
    </div>
  )
}

export default SideBar