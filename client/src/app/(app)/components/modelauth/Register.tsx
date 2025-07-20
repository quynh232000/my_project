import { Button } from '@material-tailwind/react'

import React, { useState } from 'react'
import { FaRegEyeSlash } from 'react-icons/fa6'
import { IoEyeOutline } from 'react-icons/io5'
function Register() {
    const [showPass,setShowPass] = useState(false)
  return (
    <div className=' normal-case font-normal text-[16px]'>
        <div className='text-[14px] text-center py-5'>
            Hoặc đăng ký bằng email
        </div>
        <div className='flex flex-col gap-5'>
            <div>
                <input type="text" placeholder='Nhập Email..' className='w-full bg-primary-50 p-2 rounded-lg px-4 outline-none border focus:shadow-md' />
                <span className='text-red-500 text-[14px]'>Vui lòng nhập Email</span>
            </div>
            <div>
                <div className='relative'>
                    <input type={showPass ? "text": "password"} placeholder='*****' className='w-full bg-primary-50 p-2 rounded-lg px-4 outline-none border focus:shadow-md ' />
                    <span onClick={()=>setShowPass(!showPass)} className=" absolute top-[50%] translate-y-[-50%] text-xl cursor-pointer hover:text-primary-500 right-3">
                        {showPass ? <IoEyeOutline /> :<FaRegEyeSlash /> }
                    </span>
                </div>
                <span className='text-red-500 text-[14px]'>Vui lòng nhập mật khẩu</span>
            </div>
            <div>
                <Button {...({} as any)} className='w-full  bg-primary-500'>Đăng ký</Button>
            </div>
            
        </div>
    </div>
  )
}

export default Register