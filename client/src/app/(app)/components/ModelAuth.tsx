import { Button } from "@material-tailwind/react"
import { useState } from "react"
import {
  Dialog,
  DialogBody,
} from "@material-tailwind/react";
import { IoClose } from "react-icons/io5";
import Login from "./modelauth/Login";
import Register from "./modelauth/Register";
import Link from "next/link";
import Reset from "./modelauth/Reset";
import LoginGoogle from "@/components/shared/Button/LoginGoogle";

function ModelAuth() {
  const [open,setOpen] = useState(false)
  const [type,setType] = useState<any>('login')

  const handleOpen = (type:any)=>{
      setOpen(true)
      setType(type)
  }
  return (
    <>
        <Button onClick={()=> handleOpen('login')} {...({} as any)} className="rounded-lg text-[14px] normal-case font-normal min-w-[106px] text-center bg-primary-500 px-3 py-2 text-white transition-all hover:bg-primary-600 hover:shadow-md">
            Đăng nhập
        </Button>
        <Button onClick={()=> handleOpen('register')} {...({} as any)} className="rounded-lg text-[14px] normal-case font-normal border min-w-[106px] text-center bg-white border-primary-500 px-3 py-2 text-primary-500 transition-all hover:bg-primary-50 hover:shadow-md">
							Đăng ký
				</Button>
        {/* model */}
        <Dialog
          {...({} as any)}
          open={open}
          size={'sm'}

          handler={()=>(setOpen(!open))}
        >
          
          <DialogBody {...({} as any)} className=' pb-8  overflow-y-scroll scrollbar_custom scrollbar_custom_hidden relative normal-case font-normal text-[16px]'>
                <div onClick={()=>setOpen(false)} className=" absolute top-4 right-4 text-2xl w-[36px] h-[36px] flex justify-center items-center hover:bg-primary-50 text-gray-600 cursor-pointer hover:text-primary-500 rounded-full"><IoClose /></div>
                <div className='font-semibold text-2xl text-center my-5'>
                  {type == 'login'  && 'Đăng nhập'}
                  {type == 'register'  && 'Đăng ký tài khoản'}
                  {type == 'reset'  && 'Khôi phục mật khẩu'}
                </div>
               
                <div className='px-8'>
                  <div className='w-full flex justify-center'>
                      <LoginGoogle setOpen={setOpen}/>
                  </div>
                  {type =='login'  && <Login setOpen={setOpen}/>}
                  {type =='register'  && <Register setOpen={setOpen}/>}
                  {type =='reset'  && <Reset/>}
                  

                  {type == 'login' && <div className="text-center py-5"><Link onClick={()=>setType('reset')} href={'#'} className='text-center my-3 text-secondary-500 font-semibold'>
                      Khôi phục mật khẩu
                    </Link></div>}
                  <div className="flex justify-center items-center gap-2 mt-3">
                    <div>
                      {type == 'login' ? 'Bạn chưa':'Bạn đã'} có tài khoản?
                    </div>
                    {type == 'login' && <Link href={'#'} onClick={()=>setType('register')} className="font-semibold text-secondary-500 "> Đăng ký</Link>}
                    {(type == 'register' || type == 'reset') && <Link href={'#'} onClick={()=>setType('login')} className="font-semibold text-secondary-500 "> Đăng nhập</Link>}
                   
                  </div>
                
                </div>
          </DialogBody>
        
        </Dialog>
        {/* model end */}
    </>
  )
}

export default ModelAuth