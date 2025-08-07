import Image from "next/image"
import { motion } from 'framer-motion';
import { useEffect, useState } from "react";
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
import { FaChildReaching, FaHotel, FaLocationDot, FaPerson, FaPlus } from "react-icons/fa6";
import { FiMinus } from "react-icons/fi";
import { LuHotel } from "react-icons/lu";
import { useRouter, useSearchParams } from "next/navigation";
import {  formatDate, getFeatureDate } from "@/utils/common";
import { IData, SGetHotelCategoryList } from "@/services/app/home/SGetHotelCategoryList";
import { ISearch, SGetSearch } from "@/services/app/home/SGetSearch";
import useDebounce from "@/hooks/use-debounce";
import { useHeadSearchStore } from "@/store/app/home/headsearch/store";


function highlightText(text: string, search: string) {
  if (!search) return text;

  // Escape các ký tự đặc biệt nếu cần
  const escapedSearch = search.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');

  const regex = new RegExp(`(${escapedSearch})`, 'gi');

  const highlighted = text.replace(regex, (match) => {
    return `<span class="text-primary-500 font-semibold">${match}</span>`;
  });

  return <span dangerouslySetInnerHTML={{ __html: highlighted }} />;
}
export type SearchSelect = {
  name:string,
  slug:string,
  type:string,
  page:string,
}

function SearchHead({navActiveKey,className}:{navActiveKey:string,className?:string}) {
  const searchParams = useSearchParams();
      // const router = useRouter();
      // const pathname = usePathname();
  const date_start = searchParams.get('date_start')||getFeatureDate(1);
  const date_end = searchParams.get('date_end') || getFeatureDate(2);
  const adt = searchParams.get('adt') || 2;
  const chd = searchParams.get('chd') || 0;
  const quantity = searchParams.get('quantity') || 1;

  const { name,slug,type,page, setSearchSelected } = useHeadSearchStore();

  const [formData,setFormData] = useState({
    from:date_start,
    to:date_end,
    adt:adt,
    chd:chd,
    quantity:quantity
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
        setTimeout(() => {
          setDropDown(false)
        }, 500);
    }
  const [searchSelectedHead,setSearchSelectedHead] = useState<SearchSelect|null>({name,slug,type,page})

  // date
  const [selectDate,selectDateTime] = useState<DateRange|undefined>({
        from:new Date(formData.from),
        to: new Date(formData.to)
    })
  const [open, setOpen] = useState(false);
  const [openQuantity, setOpenQuantity] = useState(false);
  // submit number
  const handleSubmitSelectNumber =()=>{
    setFormData({...formData,...formDataSelect, from:String(selectDate?.from),to:String(selectDate?.to)})
    
    setOpenQuantity(false)
  }
  const handleSubmit =()=>{
    if(searchSelectedHead?.name){
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
      if(searchSelectedHead.page == 'filter'){
        router.push('/'+navActiveKey+`/${searchSelectedHead.type}/${searchSelectedHead.slug}?`+new URLSearchParams(params).toString())
      }else{
         router.push('/'+navActiveKey+`/${searchSelectedHead.slug}?`+new URLSearchParams(params).toString())
      }
    }else{
      setDropDown(true)
    }
    
    
    // router.push('/'+navActiveKey+'/search?'+new URLSearchParams(params).toString())
  }

  // category data
  const [hotelCategories,setHotelCategories]  = useState<IData|null>(null)
      useEffect(()=>{
          SGetHotelCategoryList().then(res=>{
              if(res) setHotelCategories(res)
          })
      },[])
  // get search 
  const [dataSearch,setDataSearch] = useState<ISearch|null>(null)
  const [valueSearch,setValueSearch] = useState('')
  const onSearchChange = useDebounce((keySearch: string) => {
		if(keySearch){
      SGetSearch(keySearch).then(res=>{
        if(res) setDataSearch(res)
      })

    }
	}, 1000);

const handleSearchInput = (value:string)=>{
  setValueSearch(value)
  onSearchChange(value)
  setSearchSelectedHead(null)
}
const handleSearchSelected = (selected:SearchSelect)=>{
  if(selected.name){
    setSearchSelected(selected)
    setSearchSelectedHead(selected)
    setValueSearch(selected.name)
    setDropDown(false)
  }
}

useEffect(()=>{
  if(name){
    setSearchSelectedHead({
      name,slug,type,page
    })
    setValueSearch(name)
    

  }
},[name])

  return (
    <div className={'  flex relative bg-white '+ (className && className)}>
        <div className='flex-1 flex items-center '>
          {/* location */}
          <div className='border-r p-2  px-5 w-[30%]'>
            <div className='text-[12px] text-gray-600 mb-1'>Địa điểm</div>
              <div>
                  <input value={valueSearch} onFocus={handleForcusInput} onChange={(e)=>handleSearchInput(e.target.value)} onBlur={handleBlurInput} type="text" className=' w-full text-[14px] font-semibold outline-none border-none' placeholder='Địa điểm, khách sạn trong nước hoặc quốc tế' />
              </div>
              {
                  dropDownm && 
                  <motion.div
                      initial={{ opacity: 0, y: -20 }}
                      animate={{ opacity: 1, y: 0 }}
                      transition={{ duration: 0.4, ease: 'easeOut' }}
                      className=" absolute z-[5] top-[110%] left-0 right-0 bg-white rounded-lg p-4 shadow-lg flex gap-8 max-h-[432px]" >
                      <div className="w-[35%] flex flex-col">
                          <div className="flex justify-between bg-primary-50 p-3 rounded-lg item-center">
                              <div className="font-semibold">Tìm kiếm gần đây</div>
                              <div className="text-red-500 text-sm">Xóa lịch sử tìm kiếm</div>
                          </div>
                          <div className=" overflow-y-scroll scrollbar_custom mt-2 flex-1">
                            {dataSearch?.categories && dataSearch.categories.length > 0 && dataSearch.categories.map(item=>{
                                return <div key={item.id} onClick={()=>handleSearchSelected({
                                  name:item.name,
                                  slug:item.slug,
                                  page:'filter',
                                  type:item.type_location
                                })} className="flex gap-4 p-2 py-3 rounded-lg hover:bg-primary-50 border-b transition-all cursor-pointer">
                                  <div className=" bg-primary-50 rounded-lg p-2">
                                      <FaLocationDot className="text-gray-600"/>
                                  </div>
                                  <div className="flex justify-between flex-1">
                                      <div className="flex-1">
                                          <div className="text-[14px]">{highlightText(item.name,valueSearch)}</div>
                                          <div className="text-sm text-gray-600">Điểm đến</div>
                                      </div>
                                      <div className="flex items-center gap-1 text-md">
                                          <span className="text-[14px] text-gray-500">{item.product_counts}</span>
                                          <div>
                                              <Hotel className="text-gray-500" size={16}/>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              })}
                              {dataSearch?.chains && dataSearch.chains.length > 0 && dataSearch.chains.map(item=>{
                                return <div key={item.id} onClick={()=>handleSearchSelected({
                                  name:item.name,
                                  slug:item.slug,
                                  page:'filter',
                                  type:'chain'
                                })} className="flex gap-4 p-2 py-3 rounded-lg hover:bg-primary-50 border-b transition-all cursor-pointer">
                                  <div className=" bg-primary-50 rounded-lg p-2">
                                      <FaHotel className="text-gray-600"/>
                                  </div>
                                  <div className="flex justify-between flex-1">
                                      <div className="flex-1">
                                          <div className="text-[14px]">{highlightText(item.name,valueSearch)}</div>
                                          <div className="text-sm text-gray-600">Chuỗi khách sạn</div>
                                      </div>
                                      {/* <div className="flex items-center gap-1 text-md">
                                          <span className="text-[14px] text-gray-500"></span>
                                          <div>
                                              <Hotel className="text-gray-500" size={16}/>
                                          </div>
                                      </div> */}
                                  </div>
                              </div>
                              })}
                              {dataSearch?.locations && dataSearch.locations.length > 0 && dataSearch.locations.map(item=>{
                                const nameKey = `${item.type}_name` as 'country_name' | 'province_name' | 'ward_name';
                                const nameSlug = `${item.type}_slug` as 'country_slug' | 'province_slug' | 'ward_slug';
                                return <div key={item.id} onClick={()=>handleSearchSelected({
                                  name:item[nameKey],
                                  slug:item[nameSlug],
                                  page:'filter',
                                  type:item.type
                                })} className="flex gap-4 p-2 py-3 rounded-lg hover:bg-primary-50 border-b transition-all cursor-pointer">
                                  <div className=" bg-primary-50 rounded-lg p-2">
                                      <LocateIcon className="text-gray-600"/>
                                  </div>
                                  <div className="flex justify-between flex-1">
                                      <div className="flex-1">
                                          <div className="text-[14px]">{highlightText(item[nameKey] ?? '',valueSearch)}</div>
                                          <div className="text-sm text-gray-600">{item.label}</div>
                                      </div>
                                      <div className="flex items-center gap-1 text-md">
                                          <span className="text-[14px] text-gray-500"></span>
                                          <div>
                                              <Hotel className="text-gray-500" size={16}/>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              })}
                               {dataSearch?.hotels && dataSearch.hotels.length > 0 && dataSearch.hotels.map(item=>{
                                return <div key={item.id} onClick={()=>handleSearchSelected({
                                  name:item.name,
                                  slug:item.slug,
                                  page:'detail',
                                  type:''
                                })} className="flex gap-4 p-2 py-3 rounded-lg hover:bg-primary-50 border-b transition-all cursor-pointer">
                                  <div className=" bg-primary-50 rounded-lg p-2 relative w-[40px] h-[40px] ">
                                      <Image 
                                          fill
                                          alt=""
                                          className=" object-cover rounded-lg"
                                          src={item.image??'/images/common/vt.webp'}
                                      />
                                  </div>
                                  <div className="flex justify-between flex-1">
                                      <div className="flex-1">
                                          <div className="text-[14px]">{highlightText(item.name ?? '',valueSearch)}</div>
                                          <div className="text-sm text-gray- line-clamp-1">{item.location.ward_name +', '+item.location.province_name+', '+item.location.country_name}</div>
                                          <div>
                                              <span className="text-sm border rounded-md border-gray-400 p-1 py-[1px]">Khách sạn</span>
                                          </div>
                                      </div>
                                      
                                  </div>
                              </div>
                              })}
{/* 
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
                              )} */}
                          </div>
                      </div>
                      <div className="flex-1">
                          <div className="text-[14px] font-semibold">Địa điểm nổi bật</div>
                          <div className=" grid grid-cols-6 mt-2 gap-1">
                              {/* item */}
                              {hotelCategories?.destination.map(item=>{
                                return <div key={item.id} onClick={()=>handleSearchSelected({
                                  name:item.name,
                                  slug:item.slug,
                                  page:'filter',
                                  type:item.type_location??''
                                })} className="rounded-lg p-2 hover:bg-primary-50 transition-all flex flex-col items-center">
                                  <div className="w-[80px] h-[80px] rounded-full shadow-sm relative">
                                      <Image
                                          alt=""
                                          fill
                                          priority
                                          className=" rounded-full object-cover h-[80px]"
                                          src={item.image??'/images/common/hochiminh.jpg'}
                                      />
                                  </div>
                                  <div className="text-[14px] text-gray-600 mt-1">{item.name}</div>
                              </div>
                              })}
                              
                              

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
                                <div onClick={()=>setFormDataSelect({...formDataSelect,adt: +formDataSelect.adt >1 ? +formDataSelect.adt -1 :formDataSelect.adt })} className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg"><FiMinus /></div>
                                <div className="w-12  text-center py-2 border-b-2">{formDataSelect.adt}</div>
                                <div onClick={()=>setFormDataSelect({...formDataSelect,adt:+formDataSelect.adt+1})} className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg text-primary-500"><FaPlus /></div>
                              </div>
                            </div>
                            <div className="flex justify-between gap-12">
                              <div className="flex items-center gap-2">
                                <FaChildReaching className="text-primary-500 text-xl"/>
                                Trẻ em
                              </div>
                              <div className="flex items-center gap-2">
                                <div onClick={()=>setFormDataSelect({...formDataSelect,chd: +formDataSelect.chd >0 ? +formDataSelect.chd -1 :formDataSelect.chd })} className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg"><FiMinus /></div>
                                <div className="w-12  text-center py-2 border-b-2">{formDataSelect.chd}</div>
                                <div onClick={()=>setFormDataSelect({...formDataSelect,chd:+formDataSelect.chd+1})}  className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg text-primary-500"><FaPlus /></div>
                              </div>
                            </div>
                            <div className="flex justify-between gap-12">
                              <div className="flex items-center gap-2">
                                <LuHotel  className="text-primary-500 text-xl"/>
                                Phòng
                              </div>
                              <div className="flex items-center gap-2">
                                <div onClick={()=>setFormDataSelect({...formDataSelect,quantity: +formDataSelect.quantity >1 ? +formDataSelect.quantity -1 :formDataSelect.quantity })} className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg"><FiMinus /></div>
                                <div className="w-12  text-center py-2 border-b-2">{formDataSelect.quantity}</div>
                                <div onClick={()=>setFormDataSelect({...formDataSelect,quantity:+formDataSelect.quantity+1})}  className="px-3 hover:bg-primary-100 cursor-pointer py-2 bg-primary-50 rounded-lg text-primary-500"><FaPlus /></div>
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
                <Search size={26} />
              </div>
            </div>
          </div>
        </div>
      </div>
  )
}

export default SearchHead