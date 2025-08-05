import React, { useState } from 'react'
import { FaAngleRight, FaCar, FaCashRegister, FaClock, FaFaceKissWinkHeart, FaUmbrella, FaWifi} from 'react-icons/fa6';
import {
  Dialog,
   
  DialogBody,
} from "@material-tailwind/react";
import { IoMdClose } from "react-icons/io";
import { Facility } from '@/services/app/hotel/SGetHotelDetail';


function ModelService({facilities}:{facilities:Facility[]}) {
  const ICONS = [FaCar, FaFaceKissWinkHeart, FaCashRegister, FaClock, FaWifi, FaUmbrella];
   const [open,setOpen] = useState(false)

   const groupedMap = new Map();

    facilities.forEach(item => {
    const parentId = item?.parents?.id;
    if (!groupedMap.has(parentId)) {
        groupedMap.set(parentId, {
        parent: item.parents,
        children: []
        });
    }
    groupedMap.get(parentId).children.push({
        id: item.id,
        name: item.name,
        image: item.image,
        pivot: item.pivot
    });
    });

    const result = Array.from(groupedMap.values());
  return (
    <div className=''>
        <div onClick={()=>(setOpen(true))} className='flex items-center gap-1 text-secondary-500 text-[14px] cursor-pointer hover:text-secondary-600'>
             Xem tất cả<FaAngleRight/>
        </div>
        
        <Dialog
        {...({} as any)}
        open={open}
        size={'lg'}
        className=''
        handler={()=>(setOpen(!open))}
      >
        
        <DialogBody {...({} as any)} className='h-[80vh] overflow-y-scroll scrollbar_custom scrollbar_custom_hidden'>
          <div className='text-[16px] font-normal'>
            <div className='flex justify-between items-center w-full text-2xl font-semibold '>
                <div className='pl-4'>Tiện nghi khách sạn {result.length??0}</div>
                <div onClick={()=>(setOpen(!open))} className='w-12 h-12 hover:bg-gray-100 rounded-full justify-center items-center flex text-gray-600 cursor-pointer'>
                    <IoMdClose/>
                </div>
            </div>
            <div className='px-4 mt-5 flex flex-col '>
                {result.map((item,index)=>{
                     
                    return <div className='flex flex-col gap-1 border-b py-5 border-gray-400 border-dashed' key={index}>
                    <div className='font-semibold text-lg mb-2'>{item?.parent?.name ??'Phương tiện đi lại'} ({item?.children.length??0})</div>
                    <div className='grid grid-cols-4 gap-5'>
                        {item?.children?.map( (s:any,k:number) =>{
                            const Icon = ICONS[k % ICONS.length];
                            return <div key={s.id} className='flex items-start gap-2 text-gray-600'>
                                <Icon className='text-gray-400 mt-2'/>
                                <span className='flex-1'>{s?.name ??''}</span>
                            </div>
                        })}
                           
                    </div>
                </div>
                })}
               
            </div>
          </div>
        </DialogBody>
       
      </Dialog>
      

       
        
    </div>
  )
}

export default ModelService