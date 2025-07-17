import React from 'react'
import Image from 'next/image';
import { AiOutlineLike } from "react-icons/ai";
import {
  Progress,
} from "@material-tailwind/react";
import {  FaBagShopping, FaBed, FaNoteSticky, FaPen} from 'react-icons/fa6';

const CircularProgress = ({ percent,text }: { percent: number,text:string }) => {
  const radius = 38;
  const circumference = 2 * Math.PI * radius;
  const offset = circumference - (percent / 100) * circumference;

  return (
    <svg
      className="w-[169px] h-auto relative"
      viewBox="0 0 100 100"
    >
      <circle
        r={radius}
        cx="50"
        cy="50"
        className="text-slate-200"
        strokeWidth="6"
        strokeLinecap="round"
        stroke="currentColor"
        fill="transparent"
        style={{
          strokeDasharray: circumference,
          strokeDashoffset: 0,
          transform: 'rotate(-90deg)',
          transformOrigin: '50% 50%',
        }}
      />
      <circle
        r={radius}
        cx="50"
        cy="50"
        className="text-primary-500"
        strokeWidth="6"
        strokeLinecap="round"
        stroke="currentColor"
        fill="transparent"
        style={{
          strokeDasharray: circumference,
          strokeDashoffset: offset,
          transform: 'rotate(-90deg)',
          transformOrigin: '50% 50%',
          transition: 'stroke-dashoffset 0.3s ease',
        }}
      />
      <text
            x="55"
            y="45" 
            textAnchor="middle"
            dominantBaseline="middle"
            className="fill-primary-500 text-[18px] font-semibold"
            >
            {Math.round(percent)}%
            </text>
            <text
            x="50"
            y="65"
            textAnchor="middle"
            dominantBaseline="middle"
            className="fill-black text-[8px]"
            >
            {text}
            </text>
    </svg>
  );
};
type props = {
    type ?:string
}
function ReviewContent({type}:props) {
  return (
    <div className={'flex gap-8 '+(type ? ' flex-col':'')}>
        <div className={' p-5 bg-gray-50 rounded-lg ' + (type ? 'w-full  flex items-center' :'w-[35%]')}>
            <div className={type ? 'px-5':''}>
                <div className='flex justify-center'>
                {CircularProgress({percent:60,text:'Tuyệt vời'})}
                </div>
                <div className='text-center text-[14px] text-gray-500'>
                    100% đánh giá từ đối tác và khách hàng đặt phòng trên Quin Booking
                </div>
            </div>
            <div className={'flex gap-2 flex-col mt-4 ' +(type ? 'w-[30%] border-r border-gray-300 px-5':'')}>
                <div className='flex items-center'>
                    <div className='flex-1' >Tuyệt vời</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='purple' {...({} as any)} value={50} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
                <div className='flex items-center'>
                    <div className='flex-1' >Xuất sắc</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='purple' {...({} as any)} value={80} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
                <div className='flex items-center'>
                    <div className='flex-1' >Tốt</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='purple' {...({} as any)} value={60} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
                <div className='flex items-center'>
                    <div className='flex-1' >Trung bình</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='purple' {...({} as any)} value={30} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
                <div className='flex items-center'>
                    <div className='flex-1' >Kém</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='purple' {...({} as any)} value={50} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
            </div>
            <div className={'flex gap-2 flex-col mt-4  border-gray-400  ' +(type ? 'w-[30%] px-5':'border-t pt-4')}>
                <div className='flex items-center'>
                    <div className='flex-1' >Vị trí</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='pink' {...({} as any)} value={50} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
                <div className='flex items-center'>
                    <div className='flex-1' >Phục vụ</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='pink' {...({} as any)} value={80} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
                <div className='flex items-center'>
                    <div className='flex-1' >Giá cả</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='pink' {...({} as any)} value={60} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
                <div className='flex items-center'>
                    <div className='flex-1' >Vệ sinh</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='pink' {...({} as any)} value={30} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
                <div className='flex items-center'>
                    <div className='flex-1' >Tiện nghi</div>
                    <div className='w-[55%]'>
                        <Progress className='h-[5px] bg-primary-100' color='pink' {...({} as any)} value={50} />
                    </div>
                    <div className='w-[15%] text-right font-semibold'>18</div>
                </div>
            </div>
        </div>
        {/* right */}
        <div className='flex-1 flex flex-col gap-3'>
            <div className='text-lg border-b w-full pb-2 '>
                Có 21 đánh giá
            </div>
            <div className='flex flex-wrap gap-2'>
                <div className='bg-primary-500 text-white font-semibold py-1 px-4 hover:shadow-lg cursor-pointer rounded-lg hover:bg-primary-600'>Tất cả (21)</div>
                <div className='bg-gray-300  font-semibold py-1 px-4 hover:shadow-lg cursor-pointer rounded-lg hover:bg-gray-400 transition-all'>Cặp đôi (21)</div>
                <div className='bg-gray-300  font-semibold py-1 px-4 hover:shadow-lg cursor-pointer rounded-lg hover:bg-gray-400 transition-all'>Bạn bè (11)</div>
                <div className='bg-gray-300  font-semibold py-1 px-4 hover:shadow-lg cursor-pointer rounded-lg hover:bg-gray-400 transition-all'>Đi một mình (21)</div>
                <div className='bg-gray-300  font-semibold py-1 px-4 hover:shadow-lg cursor-pointer rounded-lg hover:bg-gray-400 transition-all'>Cặp đôi (21)</div>
            </div>
            <div className='overflow-y-scroll scrollbar_custom scrollbar_custom_hidden flex-1 max-h-[600px]'>
                {/* item */}
                    {Array.from({length:5},(_,index)=>{
                    return <div key={index} className='flex gap-2 py-4 border-b'>
                    <div className='w-[25%]'>
                        <div>
                            <div className='w-[64px] h-[64px] bg-primary-200 rounded-full flex items-center justify-center font-bold text-2xl text-primary-500'>A</div>
                            <div className='font-semibold my-2'>Quynh Nguyen</div>
                            <div className='flex gap-1 flex-col'>
                                <div className='flex items-center gap-1 text-[14px] text-gray-600'>
                                    <FaPen className='text-[12px]'/> <span>27/07/2025</span>
                                </div>
                                <div className='flex items-center gap-1 text-[14px] text-gray-600'>
                                    <FaBed className='text-[12px]'/> <span className=' line-clamp-1'>Phòng đôi view biển</span>
                                </div>
                                <div className='flex items-center gap-1 text-[14px] text-gray-600'>
                                    <FaNoteSticky className='text-[12px]'/> <span>1 đên - thánh 7,2025</span>
                                </div>
                                <div className='flex items-center gap-1 text-[14px] text-gray-600'>
                                    <FaBagShopping className='text-[12px]'/> <span>Cặp đôi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className='flex-1 flex flex-col gap-2'>
                        <div className='font-semibold text-lg'>Kỳ nghỉ gia đình vui vẻ, thoải mái!</div>
                        <div className='flex gap-1 items-center '>
                            <span className='bg-primary-500 py-[1px] px-2 rounded-md text-white  text-[14px]'>10</span>
                            <span>Tuyệt vời</span>
                        </div>
                        <div>Mình đặt khách sạn Oyster Bay dựa vào điểm đánh giá cao của mọi người, mình đặt một căn hộ hai phòng ngủ hướng biển cho bốn người ở trong ba ngày hai đêm. Trải nghiệm thật tuyệt vời. Cảm ơn, nếu có dịp mình sẽ đặt lại.</div>
                        <div className='flex flex-wrap gap-2'>
                            <div className=' relative w-[96px] h-[96px] cursor-pointer'>
                                <Image
                                alt=''
                                fill
                                className='w-full h-full object-cover rounded-lg'
                                src={'/images/common/hotel_1.jpg'}
                                />
                            </div>
                            <div className=' relative w-[96px] h-[96px] cursor-pointer'>
                                <Image
                                alt=''
                                fill
                                className='w-full h-full object-cover rounded-lg'
                                src={'/images/common/hotel_1.jpg'}
                                />
                            </div>
                            <div className=' relative w-[96px] h-[96px] cursor-pointer'>
                                <Image
                                alt=''
                                fill
                                className='w-full h-full object-cover rounded-lg'
                                src={'/images/common/hotel_1.jpg'}
                                />
                            </div>
                        </div>
                        {/* /reply */}
                        <div className='bg-primary-50 p-4 rounded-lg mt-4 flex gap-4 relative'>
                            <div className=" absolute top-[-14px] w-0 h-0 border-l-[14px] border-r-[14px] border-b-[14px] border-l-transparent border-r-transparent border-primary-50"></div>
                                <div className=' relative w-[40px] h-[40px] cursor-pointer'>
                                    <Image
                                    alt=''
                                    fill
                                    className='w-full h-full object-cover rounded-full'
                                    src={'/images/common/hotel_1.jpg'}
                                    />
                                </div>
                                <div className='flex-1'>
                                    <div className='font-semibold'>Oyster Bay Hotel Vũng Tàu</div>
                                    <div className='text-gray-600 text-[14px]'>18 ngày trước</div>
                                    <div className='mt-2'>
                                        Cảm ơn quý khách đã tin chọn Oyster Bay Vũng Tàu và dành thời gian đánh giá dịch vụ của chúng tôi. Tôi sẽ chia sẻ ý kiến đóng góp với đội ngũ nhân viên của mình. Tôi chắc chắn rằng ý kiến phản hồi này sẽ là nguồn động viên khích lệ đối với toàn bộ tập thể nhân viên của chúng tôi bởi chúng tôi luôn nỗ lực không ngừng để nâng cấp chất lượng các dịch vụ của mình. Chúng tôi hy vọng được đón tiếp quý khách trong chuyến đi lần tới đến với thành phố biển Vũng Tàu xinh đẹp. Trân trọng,
                                    </div>
                                </div>
                        </div>
                        <div>
                            <div className='flex items-center gap-2 justify-end mt-2 text-[14px]'><AiOutlineLike /> Đánh giá này có hữu ích với bạn không?</div>
                        </div>
                    </div>
                </div>
                    })}
                
            </div>
        </div>
    </div>
  )
}

export default ReviewContent