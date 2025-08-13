import { SRegister } from '@/services/app/auth/SRegister'
import { useUserInformationStore } from '@/store/user-information/store'
import { Button } from '@material-tailwind/react'

import React, { FormEvent, useState } from 'react'
import { FaRegEyeSlash } from 'react-icons/fa6'
import { IoEyeOutline } from 'react-icons/io5'
import { toast } from 'sonner'
import Cookies from 'js-cookie';
import { DEFAULT_COOKIE_OPTIONS } from '@/utils/cookie'
import { addDays } from 'date-fns/esm'
import { useRouter } from 'next/navigation'
function Register({setOpen}:{setOpen:((a:boolean)=>void)}) {
    const [showPass,setShowPass] = useState(false)
    const [loading, setLoading] = useState<boolean>(false);
    const setUserInformationState = useUserInformationStore(
                (state) => state.setUserInformationState
            );
    const [data,setData] = useState({
                full_name:'',
                email:'',
                password:''
            })
    const [error,setError] = useState({
        full_name:[],
        email:[],
        password:[]
    })
    const router = useRouter()
    const handleSubmit = (e:FormEvent<HTMLFormElement>)=>{
        e.preventDefault();
        if(data.email && data.password){
            setLoading(true)
            SRegister(data).then(res=>{
                setLoading(false)
            
                if(res.status){
                    toast.success(res.message)
                    setUserInformationState(res.data);
                    setOpen(false)
                    Cookies.set('access_token',res.meta.access_token,{
                        ...DEFAULT_COOKIE_OPTIONS,
                        expires: addDays(new Date(), 7),
                    })
                    if(res.meta.refresh_token){
                        Cookies.set('refresh_token',res.meta.refresh_token,{
                        ...DEFAULT_COOKIE_OPTIONS,
                        expires: addDays(new Date(), 7),
                    })
                    }
                    router.push('/')
                }else{
                    toast.error(res.message)
                    setError(res.error.details)
                }
            })

        }
    }
  return (
    <div className=' normal-case font-normal text-[16px]'>
        <div className='text-[14px] text-center py-5'>
            Hoặc đăng ký bằng email
        </div>
        <form onSubmit={handleSubmit} className='flex flex-col gap-5'>
            <div>
                 <input value={data.full_name} id="full_name" onChange={(e)=>setData({...data,full_name: e.target.value})} type="text" placeholder='Nhập họ tên..' className='w-full bg-primary-50 p-2 rounded-lg px-4 outline-none border focus:shadow-md' />
                                
                {
                    !data.full_name && <span className='text-red-500 text-[14px]'>Vui lòng nhập họ tên</span>
                }
                    {error && error.full_name && error.full_name.length > 0 && error.full_name.map((item,index)=>{
                    return <span key={index} className='text-red-500 text-[14px]'>{item ?? ''}</span>
                })}
            </div>
            <div>
                <input type="text" value={data.email} id="email" onChange={(e)=>setData({...data,email: e.target.value})} placeholder='Nhập Email..' className='w-full bg-primary-50 p-2 rounded-lg px-4 outline-none border focus:shadow-md' />
                 {
                    !data.email && <span className='text-red-500 text-[14px]'>Vui lòng nhập email</span>
                }
                    {error && error.email && error.email.length > 0 && error.email.map((item,index)=>{
                    return <span key={index} className='text-red-500 text-[14px]'>{item ?? ''}</span>
                })}
            </div>
            <div>
                <div className='relative'>
                    <input type={showPass ? "text": "password"} value={data.password} id="password" onChange={(e)=>setData({...data,password: e.target.value})} placeholder='*****' className='w-full bg-primary-50 p-2 rounded-lg px-4 outline-none border focus:shadow-md ' />
                    <span onClick={()=>setShowPass(!showPass)} className=" absolute top-[50%] translate-y-[-50%] text-xl cursor-pointer hover:text-primary-500 right-3">
                        {showPass ? <IoEyeOutline /> :<FaRegEyeSlash /> }
                    </span>
                </div>
                {
                    !data.password && <span className='text-red-500 text-[14px]'>Vui lòng nhập mật khẩu</span>
                }
                    {error && error.password && error.password.length > 0 && error.password.map((item,index)=>{
                    return <span key={index} className='text-red-500 text-[14px]'>{item ?? ''}</span>
                })}
            </div>
            <div>
                {loading ? <Button disabled {...({} as any)} className='w-full  bg-primary-400'>Đăng ký</Button>:<Button type="submit" {...({} as any)} className='w-full  bg-primary-500'>Đăng ký</Button> }
                
            </div>
            
        </form>
    </div>
  )
}

export default Register