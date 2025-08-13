'use client'
import Login from "@/app/(app)/components/modelauth/Login";
import Register from "@/app/(app)/components/modelauth/Register";
import Reset from "@/app/(app)/components/modelauth/Reset";
import LoginGoogle from "@/components/shared/Button/LoginGoogle";
import { useUserInformationStore } from "@/store/user-information/store";
import Link from "next/link";
import { useEffect, useState } from "react";


function Container() {
    const { showLogin } =
            useUserInformationStore();
      const [open,setOpen] = useState(false)
      const [type,setType] = useState<any>('login')
    
      useEffect(()=>{
        if(showLogin) {
            setOpen(true)
            setType('login')
            console.log('====================================');
            console.log(open);
            console.log('====================================');
        }
      },[showLogin])
  return (
    <div className="w-content m-auto py-16">
        <div  className='  overflow-y-scroll scrollbar_custom scrollbar_custom_hidden relative normal-case font-normal text-[16px] w-[50%] m-auto '>
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
        </div>


    </div>
  )
}

export default Container