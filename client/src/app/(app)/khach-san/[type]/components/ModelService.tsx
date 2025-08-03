import React, { useState } from 'react'
import { FaAngleRight, FaCar} from 'react-icons/fa6';
import {
  Dialog,
   
  DialogBody,
} from "@material-tailwind/react";
import { IoMdClose } from "react-icons/io";


function ModelService() {
   const [open,setOpen] = useState(false)
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
                <div className='pl-4'>Tiện nghi khách sạn</div>
                <div onClick={()=>(setOpen(!open))} className='w-12 h-12 hover:bg-gray-100 rounded-full justify-center items-center flex text-gray-600 cursor-pointer'>
                    <IoMdClose/>
                </div>
            </div>
            <div className='px-4 mt-5 flex flex-col gap-4'>
                <div className='flex flex-col gap-1'>
                    <div className='font-semibold text-lg'>Phương tiện đi lại</div>
                    <div className='grid grid-cols-4 gap-2'>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                    </div>
                </div>
                <div className='flex flex-col gap-1'>
                    <div className='font-semibold text-lg'>Phương tiện đi lại</div>
                    <div className='grid grid-cols-4 gap-2'>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                             <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                             <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                    </div>
                </div>
                <div className='flex flex-col gap-1'>
                    <div className='font-semibold text-lg'>Phương tiện đi lại</div>
                    <div className='grid grid-cols-4 gap-2'>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                             <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                             <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                    </div>
                </div>
                <div className='flex flex-col gap-1'>
                    <div className='font-semibold text-lg'>Phương tiện đi lại</div>
                    <div className='grid grid-cols-4 gap-2'>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                    </div>
                </div>
                <div className='flex flex-col gap-1'>
                    <div className='font-semibold text-lg'>Phương tiện đi lại</div>
                    <div className='grid grid-cols-4 gap-2'>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                             <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                             <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                    </div>
                </div>
                <div className='flex flex-col gap-1'>
                    <div className='font-semibold text-lg'>Phương tiện đi lại</div>
                    <div className='grid grid-cols-4 gap-2'>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                             <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                             <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                            <div className='flex items-center gap-2 text-gray-600'>
                                <FaCar className='text-gray-400'/>
                                <span>Bãi đỗ xe</span>
                            </div>
                    </div>
                </div>
            </div>
          </div>
        </DialogBody>
       
      </Dialog>
      

       
        
    </div>
  )
}

export default ModelService