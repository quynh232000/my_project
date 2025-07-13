import Image from "next/image"
import Link from "next/link"
import { motion } from 'framer-motion';
import { useState } from "react";
import { Hotel, LocateIcon, Search } from "lucide-react";
import {  Moon } from "lucide-react";

import { differenceInDays, format } from 'date-fns';
import { DateRange} from 'react-day-picker';
import { Button } from '@/components/ui/button';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover';
import CustomDateTimePicker from '@/containers/booking-orders/common/CustomDateTimePicker';
import { FaChildReaching, FaPerson, FaPlus } from "react-icons/fa6";
import { FiMinus } from "react-icons/fi";
import { LuHotel } from "react-icons/lu";
import { useRouter } from "next/navigation";
import { formatDate } from "@/utils/common";
function SearchHead({navActiveKey}:{navActiveKey:string}) {
  const tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);

  const dayAfterTomorrow = new Date();
  dayAfterTomorrow.setDate(dayAfterTomorrow.getDate() + 2);
  const [formData,setFormData] = useState({
    key:'',
    from:tomorrow,
    to:dayAfterTomorrow,
    adt:2,
    chd:0,
    quantity:1
  })
   const [formDataSelect,setFormDataSelect] = useState({
   ...formData
  })
  const router = useRouter();
  const [dropDownm,setDropDown] = useState(false)
    const handleForcusInput =()=>{
      setDropDown(true)
    }
      const handleBlurInput =()=>{
      setDropDown(false)
    }
  // date
  const [selectDate,selectDateTime] = useState<DateRange|undefined>({
        from:formData.from,
        to: formData.to
    })
  const [open, setOpen] = useState(false);
  const [openQuantity, setOpenQuantity] = useState(false);
  // submit number
  const handleSubmitSelectNumber =()=>{
    setFormData({...formData,...formDataSelect,...selectDate})
    setOpenQuantity(false)
  }
  const handleSubmit =()=>{
    const params = new URLSearchParams(
                    Object.fromEntries(
                      Object.entries(formData).map(([key, value]) => {
                        if(key == 'from' || key =='to'){
                          return [key, String(formatDate(value))]
                        }else{
                          return [key, String(value)]
                        }
                      })
                    )
                  );
    router.push('/'+navActiveKey+'/search?'+new URLSearchParams(params).toString())
  }
  return (
    <div className='  flex relative'>
        <div className='flex-1 flex items-center '>
          {/* location */}
          <div className='border-r p-2  px-5 w-[30%]'>
            <div className='text-[12px] text-gray-600 mb-1'>Địa điểm</div>
              <div>
                  <input onFocus={handleForcusInput} onBlur={handleBlurInput} type="text" className=' w-full text-[14px] font-semibold outline-none border-none' placeholder='Địa điểm, khách sạn trong nước hoặc quốc tế' />
              </div>
              {
                  dropDownm && 
                  <motion.div
                      initial={{ opacity: 0, y: -20 }}
                      animate={{ opacity: 1, y: 0 }}
                      transition={{ duration: 0.4, ease: 'easeOut' }}
                      className=" absolute z-[5] top-[110%] left-0 right-0 bg-white rounded-lg p-4 shadow-lg flex gap-8 max-h-[432px]" >
                      <div className="w-[30%] flex flex-col">
                          <div className="flex justify-between bg-primary-50 p-3 rounded-lg item-center">
                              <div className="font-semibold">Tìm kiếm gần đây</div>
                              <div className="text-red-500 text-sm">Xóa lịch sử tìm kiếm</div>
                          </div>
                          <div className=" overflow-y-scroll scrollbar_custom mt-2 flex-1">
                              {Array.from({ length: 3 }, (_, index) =>
                              <Link key={index} href="/khach-san/search?id=123" className="flex gap-4 p-2 py-3 rounded-lg hover:bg-primary-50 border-b transition-all cursor-pointer">
                                  <div className=" bg-primary-50 rounded-lg p-2">
                                      <LocateIcon className="text-gray-600"/>
                                  </div>
                                  <div className="flex justify-between flex-1">
                                      <div className="flex-1">
                                          <div className="text-[14px]">Bà rịa - <b className="text-primary-500">Vũng</b> Tàu</div>
                                          <div className="text-sm text-gray-600">Việt Nam</div>
                                      </div>
                                      <div className="flex items-center gap-1 text-md">
                                          <span className="text-[14px] text-gray-500">255</span>
                                          <div>
                                              <Hotel className="text-gray-500" size={16}/>
                                          </div>
                                      </div>
                                  </div>
                              </Link>
                              )}

                              {Array.from({ length: 3 }, (_, index) =>
                              <Link key={index} href="/khach-san/search?id=123" className="flex gap-4 p-2 py-3 rounded-lg hover:bg-primary-50 border-b transition-all cursor-pointer">
                                  <div className=" bg-primary-50 rounded-lg p-2 relative w-[40px] h-[40px] ">
                                      <Image 
                                          fill
                                          alt=""
                                          className=" object-cover rounded-lg"
                                          src={'/images/common/vt.webp'}
                                      />
                                  </div>
                                  <div className="flex justify-between flex-1">
                                      <div className="flex-1">
                                          <div className="text-[14px]">Khách sạn Vias <b className="text-primary-500">Vũng</b> Tàu</div>
                                          <div className="text-sm text-gray-600">Vũng Tàu, Bà Rịa - Vũng Tàu, Việt Nam</div>
                                          <div>
                                              <span className="text-sm border rounded-md border-gray-400 p-1 py-[1px]">Khách sạn</span>
                                          </div>
                                      </div>
                                      
                                  </div>
                              </Link>
                              )}
                              
                          </div>
                      </div>
                      <div className="flex-1">
                          <div className="text-[14px] font-semibold">Địa điểm nổi bật</div>
                          <div className=" grid grid-cols-6 mt-2 gap-1">
                              {/* item */}
                              {Array.from({ length: 18 }, (_, index) => <Link key={index} href={'/khach-san/search?id=23424'} className="rounded-lg p-2 hover:bg-primary-50 transition-all flex flex-col items-center">
                                  <div className="w-[80px] h-[80px] rounded-full shadow-sm relative">
                                      <Image
                                          alt=""
                                          fill
                                          priority
                                          className=" rounded-full object-cover h-[80px]"
                                          src={'/images/common/hochiminh.jpg'}
                                      />
                                  </div>
                                  <div className="text-[14px] text-gray-600 mt-1">Hồ chí minh</div>
                              </Link>)}
                              
                              

                          </div>
                      </div>
                  </motion.div>
              }

          </div>
          <div className='flex-1 flex items-center relative'>
          {/* date */}
            <div className='border-r '>
              <div className='col-span-12 grid gap-2 lg:col-span-1 w-[367px]'>
                  <Popover open={open} onOpenChange={setOpen}>
                      <PopoverTrigger
                          asChild
                          className="bg-white hover:bg-white text-black">
                          <Button
                              id="date"
                              className=" p-2 px-5 flex flex-1  justify-between items-center">
                              {selectDate?.from && selectDate?.to  ? (
                                  <>
                                      <div >
                                          <div className='text-[12px] text-gray-600 mb-1'>Ngày đến</div>
                                          <div className='font-semibold'>
                                              {format(selectDate.from, 'dd/MM/yyyy')}
                                          </div>
                                      </div>
                                      <div className='w-[40px] h-[40px] flex justify-center items-center border rounded-full gap-[2px]'>
                                          {differenceInDays(selectDate.to,selectDate.from)}
                                          <Moon size={12} className='text-gray-500'/>
                                      </div>
                                      <div >
                                          <div className='text-[12px] text-gray-600 mb-1'>Ngày về</div>
                                          <div className='font-semibold'>
                                              {selectDate.to &&format(selectDate.to, 'dd/MM/yyyy')}
                                          </div>
                                      </div>
                                  </>
                              ) : (
                                  <>
                                      <div >
                                          <div className='text-[12px] text-gray-600 mb-1'>Ngày đến</div>
                                          <div className='font-semibold'>
                                              Chọn ngày đi
                                          </div>
                                      </div>
                                      <div className='w-[40px] h-[40px] flex justify-center items-center border rounded-full'>
                                          <Moon size={14} className='text-gray-500'/>
                                      </div>
                                      <div >
                                          <div className='text-[12px] text-gray-600 mb-1'>Ngày về</div>
                                          <div className='font-semibold'>
                                              Chọn ngày về
                                          </div>
                                      </div>
                                  </>
                              )}
                          </Button>
                      </PopoverTrigger>
                      <PopoverContent
                          className="w-full p-4 mt-5"
                          align="start"
                          side={'bottom'}>
                          <CustomDateTimePicker
                              dateRange={selectDate}
                              onSelectDateRange={(filterDate) => {
                                  selectDateTime(filterDate);
                              }}
                              onClose={() => setOpen(false)}
                            
                          />
                      </PopoverContent>
                  </Popover>
              </div>
            
          </div>
          {/* quantity */}
            <div className=' p-2 px-5'>
              
                  <Popover open={openQuantity} onOpenChange={setOpenQuantity}>
                      <PopoverTrigger
                          asChild
                          className="bg-white hover:bg-white text-black">
                          <Button
                              id="date"
                              className="flex flex-col justify-start items-start gap-0">
                                <div className='text-[12px] text-gray-600 mb-1 text-left'>Số phòng, số khách</div>
                                <div className='font-semibold text-[14px]'>
                                  {`${formData.quantity} phòng, ${formData.adt} người lớn, ${formData.chd} trẻ em`}
                                </div>
                              
                          </Button>
                      </PopoverTrigger>
                      <PopoverContent
                          className=" p-4 mt-5 w-full text-[14px]"
                          align="start"
                          side={'bottom'}>
                          <div className="flex flex-col gap-1">
                            <div className="flex justify-between gap-12">
                              <div className="flex items-center gap-2">
                                <FaPerson className="text-primary-500 text-xl"/>
                                Người lớn
                              </div>
                              <div className="flex items-center gap-2">
                                <div onClick={()=>setFormDataSelect({...formDataSelect,adt: formDataSelect.adt >1 ? formDataSelect.adt -1 :formDataSelect.adt })} className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg"><FiMinus /></div>
                                <div className="w-12  text-center py-2 border-b-2">{formDataSelect.adt}</div>
                                <div onClick={()=>setFormDataSelect({...formDataSelect,adt:formDataSelect.adt+1})} className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg text-primary-500"><FaPlus /></div>
                              </div>
                            </div>
                            <div className="flex justify-between gap-12">
                              <div className="flex items-center gap-2">
                                <FaChildReaching className="text-primary-500 text-xl"/>
                                Trẻ em
                              </div>
                              <div className="flex items-center gap-2">
                                <div onClick={()=>setFormDataSelect({...formDataSelect,chd: formDataSelect.chd >0 ? formDataSelect.chd -1 :formDataSelect.chd })} className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg"><FiMinus /></div>
                                <div className="w-12  text-center py-2 border-b-2">{formDataSelect.chd}</div>
                                <div onClick={()=>setFormDataSelect({...formDataSelect,chd:formDataSelect.chd+1})}  className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg text-primary-500"><FaPlus /></div>
                              </div>
                            </div>
                            <div className="flex justify-between gap-12">
                              <div className="flex items-center gap-2">
                                <LuHotel  className="text-primary-500 text-xl"/>
                                Phòng
                              </div>
                              <div className="flex items-center gap-2">
                                <div onClick={()=>setFormDataSelect({...formDataSelect,quantity: formDataSelect.quantity >1 ? formDataSelect.quantity -1 :formDataSelect.quantity })} className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg"><FiMinus /></div>
                                <div className="w-12  text-center py-2 border-b-2">{formDataSelect.quantity}</div>
                                <div onClick={()=>setFormDataSelect({...formDataSelect,quantity:formDataSelect.quantity+1})}  className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg text-primary-500"><FaPlus /></div>
                              </div>
                            </div>
                            <div className="flex justify-end mt-4">
                              <div onClick={handleSubmitSelectNumber} className="bg-primary-500 text-white py-2 px-5 rounded-lg hover:bg-primary-600 cursor-pointer">Xong</div>
                            </div>
                          </div>
                      </PopoverContent>
                  </Popover>
              


            </div>
            <div className='px-5 ml-8'>
              <div onClick={handleSubmit} className='bg-primary-500 py-[10px] rounded-lg hover:bg-primary-600 cursor-pointer transition-all px-[36px] text-white'>
                <Search size={26}/>
              </div>
            </div>
          </div>
        </div>
      </div>
  )
}

export default SearchHead