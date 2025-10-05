import { Button } from '@material-tailwind/react'
import React from 'react'

function Reset() {
  return (
    <div>
        <div className='my-5'>Để đặt lại mật khẩu của mình, hãy nhập email hoặc số điện thoại mà bạn sử dụng để đăng nhập vào hệ thống.</div>

        <div className='flex flex-col gap-5'>
            <div>
                <input type="text" placeholder='Nhập Email..' className='w-full bg-primary-50 p-2 rounded-lg px-4 outline-none border focus:shadow-md' />
                <span className='text-red-500 text-[14px]'>Vui lòng nhập số điện thoại</span>
            </div>
            
            <div>
                <Button {...({} as any)} className='w-full  bg-primary-500'>Tiếp tục</Button>
            </div>
                    
        </div>
    </div>
  )
}

export default Reset