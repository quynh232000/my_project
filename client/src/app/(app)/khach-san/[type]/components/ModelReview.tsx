import React, { useState } from 'react'
import { FaAngleRight} from 'react-icons/fa6';
import {
  Dialog,
    Menu,
  MenuHandler,
  MenuList,
  MenuItem,
  DialogBody,
} from "@material-tailwind/react";
import { IoMdClose } from "react-icons/io";

import ReviewContent from './ReviewContent';


function ModelReview() {
   const [open,setOpen] = useState(false)
  return (
    <div className=''>
        <div onClick={()=>setOpen(true)} className='flex items-center gap-1 text-secondary-500 text-[14px] cursor-pointer hover:text-secondary-600'>
            Xem tất cả 21 đánh giá <FaAngleRight/>
        </div>
        
        <Dialog
        {...({} as any)}
        open={open}
        size={'xl'}
        className=''
        handler={()=>(setOpen(!open))}
      >
        
        <DialogBody {...({} as any)} className='h-[80vh] overflow-y-scroll scrollbar_custom scrollbar_custom_hidden'>
          <div className='text-[16px] font-normal'>
            <div className='flex justify-between items-center w-full text-2xl font-semibold '>
                <div className='pl-4'>Đánh giá</div>
                <div onClick={()=>(setOpen(!open))} className='w-12 h-12 hover:bg-gray-100 rounded-full justify-center items-center flex text-gray-600 cursor-pointer'>
                    <IoMdClose/>
                </div>
            </div>
            <div className='px-4'>
                <div className='flex justify-between items-center'>
                    <div className=' text-green-400'>Oyster Bay Hotel Vũng Tàu</div>
                    <div>
                        <Menu >
                            <MenuHandler >
                                <div className='border border-gray-300 p-2 px-3 rounded-lg'>
                                    Sắp xếp: <span className='font-semibold'>Hữu ích nhất</span>
                                </div>
                            </MenuHandler>
                            <MenuList {...({} as any)} className='z-[99999] '>
                                <MenuItem {...({} as any)} className='text-md font-semibold hover:bg-primary-50'>Mới nhất</MenuItem>
                                <MenuItem {...({} as any)} className='text-md font-semibold hover:bg-primary-50'>Cũ nhất</MenuItem>
                                <MenuItem {...({} as any)} className='text-md font-semibold hover:bg-primary-50'>Điểm cao nhất</MenuItem>
                                <MenuItem {...({} as any)} className='text-md font-semibold hover:bg-primary-50'>Điểm thấp nhất</MenuItem>
                            
                            </MenuList>
                        </Menu>
                    </div>
                </div>
                <ReviewContent/>
            </div>
          </div>
        </DialogBody>
       
      </Dialog>
      

       
        
    </div>
  )
}

export default ModelReview