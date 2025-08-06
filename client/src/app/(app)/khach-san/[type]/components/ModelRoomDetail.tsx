import React, { useState } from 'react'
import { FaAngleRight, FaCar, FaCashRegister,  FaClock, FaFaceKissWinkHeart, FaUmbrella, FaWifi} from 'react-icons/fa6';
import {
  Button,
  Dialog,
   
  DialogBody,
} from "@material-tailwind/react";
import { IoMdClose } from "react-icons/io";
import { RecommendedRoom } from '@/services/app/hotel/SGetHotelDetail';
import ImagesRoomShow from './ImagesRoomShow';
import { BsEye, BsPeople } from 'react-icons/bs';
import { TbRulerMeasure } from 'react-icons/tb';


function ModelRoomDetail({room}:{room:RecommendedRoom}) {
  const ICONS = [FaCar, FaFaceKissWinkHeart, FaCashRegister, FaClock, FaWifi, FaUmbrella];
   const [open,setOpen] = useState(false)

   const groupedMap = new Map();

  room.amenities.forEach(item => {
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

    const resultAmenities = Array.from(groupedMap.values());
   
  return (
    <div className=''>
        <div onClick={()=>(setOpen(true))} className='flex items-center gap-1 text-secondary-500 text-[14px] cursor-pointer hover:text-secondary-600 py-2'>
            Xem chi tiết phòng <FaAngleRight/>
        </div>
        
        <Dialog
        {...({} as any)}
        open={open}
        size={'lg'}
        className=''
        handler={()=>(setOpen(!open))}
      >
        
        <DialogBody {...({} as any)} className='h-[70vh] text-[16px] font-normal relative p-0 rounded-xl overflow-hidden'>
            <div onClick={()=>(setOpen(!open))} className='w-12 h-12 hover:bg-gray-100 absolute right-0 top-0 text-xl rounded-full justify-center items-center flex text-gray-600 cursor-pointer'>
                <IoMdClose/>
            </div>
            <div className=' flex w-full h-full '>
                <div className='w-[60%] h-full bg-primary-50 py-5'>
                  <ImagesRoomShow images={[
                      ...(room.images ?? [])
                      ]}/>
                    
                </div>
                <div className='flex-1  p-5 flex flex-col'>
                      <h3 className='font-semibold pr-8 mb-2 text-lg'>
                        {room.name ?? ''}
                      </h3>
                      <div className='flex-1 overflow-y-scroll scrollbar_custom scrollbar_custom_hidden flex flex-col gap-1'>
                        <div>
                          <div className='flex gap-2 items-center '>
                            <BsPeople/> <span>{room.standard_guests ?? 0} người</span>
                          </div>
                          <ul className=' list-disc list-inside pl-4 text-[14px] text-gray-600'>
                              <li>Sức chứa tối đa của phòng {room.max_capacity ?? 0}</li>
                              <li>Số khách tiêu chuẩn {room.standard_guests ?? 0}</li>
                              <li>Cho phép ở thêm {room.max_extra_children ?? 0} trẻ em</li>
                              <li>Cho phép ở thêm {room.max_extra_adults ?? 0} người lớn</li>
                          </ul>
                        </div>
                         <div className='flex gap-5'>
                          <div className='flex gap-2 items-center '>
                            <TbRulerMeasure/> <span>{room.area ?? 0} m²</span>
                          </div>
                          <div className='flex gap-2 items-center '>
                            <BsEye/> <span>{room.direction.name ?? 0} </span>
                          </div>
                          
                        </div>
                      

                        <div className='flex flex-col '>
                            {resultAmenities.map((item,index)=>{
                                
                                return <div className='flex flex-col gap-1 py-2 border-b  border-gray-400 border-dashed' key={index}>
                                <div className='font-semibold  mb-2'>{item?.parent?.name ??'Phương tiện đi lại'} ({item?.children.length??0})</div>
                                <div className='grid grid-cols-2 gap-2 text-[14px]'>
                                    {item?.children?.map( (s:any,k:number) =>{
                                        const Icon = ICONS[k % ICONS.length];
                                        return <div key={s.id} className='flex items-start gap-2 text-gray-600'>
                                            <Icon className='text-gray-400 mt-1'/>
                                            <span className='flex-1'>{s?.name ??''}</span>
                                        </div>
                                    })}
                                      
                                </div>
                            </div>
                            })}
                          
                        </div>


                      </div>
                      <div className='pt-4'>
                        <Button className='w-full bg-primary-500 hover:bg-primary-600' {...({} as any)}>Chọn phòng</Button>
                      </div>
                </div>
               
            </div>
         
        </DialogBody>
       
      </Dialog>
      

       
        
    </div>
  )
}

export default ModelRoomDetail