'use client';
import {
	Bell,
	BriefcaseBusiness,
	ChevronDown,
	Ellipsis,
	Gift,
	MoveRight,
	Newspaper,
	NotepadText,
  Trash,
} from 'lucide-react';
import Image from 'next/image';
import Link from 'next/link';

import DrawerSidebar from '@/components/shared/Drawer/DrawerSidebar';
import {  Menu, MenuHandler, MenuList } from '@material-tailwind/react';
import ModelAuth from '@/app/components/ModelAuth';
function Header() {
	return (
		<div className="w-full shadow-sm fixed top-0 right-0 left-0 z-10">
			<Link
				href={'#'}
				className="flex justify-center bg-primary-500 py-2 text-[14px] text-center text-white">
				🎉 Giới thiệu doanh nghiệp mới để nhận thưởng tới 35 triệu đồng.
				Chi tiết <MoveRight className="ml-2 text-sm" />
			</Link>
			<div className="px-[60px] pt-2 bg-white">
				<div className="flex items-center justify-between">
					<Link href={'/'}>
						<Image
							src="/images/logo/logo-new.png"
							alt="Ảnh logo"
							width={104}
							height={36}
						/>
						<div className="mt-1 text-[12px]">
							Yên tâm du lịch quốc tế
						</div>
					</Link>
					<div className="flex items-center gap-4">
            <Link
							href={'/blog'}
							className="flex items-center gap-2 rounded-full p-2 px-3 transition-all hover:bg-primary-50">
							<Newspaper className="text-primary-500" />
							<span className="text-[14px]">
								Tin tức
							</span>
						</Link>
						<Link
							href={'#'}
							className="flex items-center gap-2 rounded-full p-2 px-3 transition-all hover:bg-primary-50">
							<Gift className="text-primary-500" />
							<span className="text-[14px]">
								Mã giảm giá và ưu đãi
							</span>
						</Link>
						<Link
							href={'#'}
							className="flex items-center gap-3 rounded-lg bg-primary-50 p-1 px-3 transition-all hover:bg-primary-50">
							<BriefcaseBusiness className="text-2xl text-primary-500" />
							<div>
								<span className="text-[14px] font-bold">
									QuinBooking for Business
								</span>
								<div className="text-sm text-primary-500">
									Hoàn tiền tới 5%
								</div>
							</div>
						</Link>
						<Link
							href={'#'}
							className="flex items-center gap-2 rounded-full p-2 px-3 transition-all hover:bg-primary-50">
							<NotepadText className="text-sm text-gray-400" />
							<span className="text-[14px]">
								Tìm kiếm đơn hàng
							</span>
						</Link>
						<Link
							href={'#'}
							className="flex items-center gap-2 rounded-full p-2 px-3 transition-all hover:bg-primary-50">
							<Image
								src={'/images/language/icon_lang_vi.png'}
								alt="Ảnh logo"
								width={20}
								height={20}
							/>
							<span className="text-[14px]">VND</span>
							<ChevronDown className="text-gray-400" />
						</Link>
						
            {/* menu bell */}
            <Menu  placement="bottom-end" >
              <MenuHandler>
                <button
                  className="flex h-[42px] w-[42px] items-center justify-center gap-2 rounded-full bg-primary-50 transition-all">
                  <Bell className="text-sm text-gray-500" />
                </button>
              </MenuHandler>
              <MenuList  {...({} as any)} className='w-[390px] max-h-[80vh] z-[1] p-0 outline-none border-transparent  flex flex-col hover:border-none hover:outline-none hover:ring-0 focus:outline-none focus:ring-0 focus:border-none'>
                {/* <MenuItem {...({} as any)}>Menu Item 1</MenuItem>
                div */}
                <div className='text-primary-500 text-[14px] border-b p-3'>Đọc tất cả</div>
                <div className='flex-1 overflow-y-scroll scrollbar_custom'>
                  {/* item */}
                  <div className='flex gap-4 p-3 cursor-pointer transition-all hover:bg-primary-50'>
                    <div>
                      <Image 
                        src={'/images/defaults/default1.jpg'}
                        width={56}
                        height={56}
                        className="object-cover rounded-lg"
                        alt='BAMBOO AIRWAYS THÔNG BÁO'
                      />
                    </div>
                    <div className='flex-1'>
                      <h3 className=' text-md font-semibold'>BAMBOO AIRWAYS THÔNG BÁO</h3>
                      <span className='text-[14px] text-gray-700 line-clamp-3'>Đặt vé hôm nay để chọn chỗ mong muốn hoàn toàn miễn phí cùng Bamboo từ 11/07-17/07/2025!</span>
                      <div className='mt-3 flex justify-between group relative'>
                        <span className='text-[14px] text-gray-700'>11-07-2025 19:00:11</span>
                        <div className='bg-gray-100 border w-[32px] h-[32px] top-[-10px] shadow-lg rounded-full group-hover:flex justify-center items-center cursor-pointer hidden hover:text-primary-500 transition-all absolute right-0 '>
                          <Trash size={14} className='text-gray-600 '/>
                        </div>
                      </div>
                    </div>
                  </div>
                  {/* item */}
                  <div className='flex gap-4 p-3 cursor-pointer transition-all hover:bg-primary-50'>
                    <div>
                      <Image 
                        src={'/images/defaults/default1.jpg'}
                        width={56}
                        height={56}
                        className="object-cover rounded-lg"
                        alt='BAMBOO AIRWAYS THÔNG BÁO'
                      />
                    </div>
                    <div className='flex-1'>
                      <h3 className=' text-md font-semibold'>BAMBOO AIRWAYS THÔNG BÁO</h3>
                      <span className='text-[14px] text-gray-700 line-clamp-3'>Đặt vé hôm nay để chọn chỗ mong muốn hoàn toàn miễn phí cùng Bamboo từ 11/07-17/07/2025!</span>
                      <div className='mt-3 flex justify-between group relative'>
                        <span className='text-[14px] text-gray-700'>11-07-2025 19:00:11</span>
                        <div className='bg-gray-100 border w-[32px] h-[32px] top-[-10px] shadow-lg rounded-full group-hover:flex justify-center items-center cursor-pointer hidden hover:text-primary-500 transition-all absolute right-0 '>
                          <Trash size={14} className='text-gray-600 '/>
                        </div>
                      </div>
                    </div>
                  </div>
                  {/* item */}
                  <div className='flex gap-4 p-3 cursor-pointer transition-all hover:bg-primary-50'>
                    <div>
                      <Image 
                        src={'/images/defaults/default1.jpg'}
                        width={56}
                        height={56}
                        className="object-cover rounded-lg"
                        alt='BAMBOO AIRWAYS THÔNG BÁO'
                      />
                    </div>
                    <div className='flex-1'>
                      <h3 className=' text-md font-semibold'>BAMBOO AIRWAYS THÔNG BÁO</h3>
                      <span className='text-[14px] text-gray-700 line-clamp-3'>Đặt vé hôm nay để chọn chỗ mong muốn hoàn toàn miễn phí cùng Bamboo từ 11/07-17/07/2025!</span>
                      <div className='mt-3 flex justify-between group relative'>
                        <span className='text-[14px] text-gray-700'>11-07-2025 19:00:11</span>
                        <div className='bg-gray-100 border w-[32px] h-[32px] top-[-10px] shadow-lg rounded-full group-hover:flex justify-center items-center cursor-pointer hidden hover:text-primary-500 transition-all absolute right-0 '>
                          <Trash size={14} className='text-gray-600 '/>
                        </div>
                      </div>
                    </div>
                  </div>
                  {/* item */}
                  <div className='flex gap-4 p-3 cursor-pointer transition-all hover:bg-primary-50'>
                    <div>
                      <Image 
                        src={'/images/defaults/default1.jpg'}
                        width={56}
                        height={56}
                        className="object-cover rounded-lg"
                        alt='BAMBOO AIRWAYS THÔNG BÁO'
                      />
                    </div>
                    <div className='flex-1'>
                      <h3 className=' text-md font-semibold'>BAMBOO AIRWAYS THÔNG BÁO</h3>
                      <span className='text-[14px] text-gray-700 line-clamp-3'>Đặt vé hôm nay để chọn chỗ mong muốn hoàn toàn miễn phí cùng Bamboo từ 11/07-17/07/2025!</span>
                      <div className='mt-3 flex justify-between group relative'>
                        <span className='text-[14px] text-gray-700'>11-07-2025 19:00:11</span>
                        <div className='bg-gray-100 border w-[32px] h-[32px] top-[-10px] shadow-lg rounded-full group-hover:flex justify-center items-center cursor-pointer hidden hover:text-primary-500 transition-all absolute right-0 '>
                          <Trash size={14} className='text-gray-600 '/>
                        </div>
                      </div>
                    </div>
                  </div>
                  {/* item */}
                  <div className='flex gap-4 p-3 cursor-pointer transition-all hover:bg-primary-50'>
                    <div>
                      <Image 
                        src={'/images/defaults/default1.jpg'}
                        width={56}
                        height={56}
                        className="object-cover rounded-lg"
                        alt='BAMBOO AIRWAYS THÔNG BÁO'
                      />
                    </div>
                    <div className='flex-1'>
                      <h3 className=' text-md font-semibold'>BAMBOO AIRWAYS THÔNG BÁO</h3>
                      <span className='text-[14px] text-gray-700 line-clamp-3'>Đặt vé hôm nay để chọn chỗ mong muốn hoàn toàn miễn phí cùng Bamboo từ 11/07-17/07/2025!</span>
                      <div className='mt-3 flex justify-between group relative'>
                        <span className='text-[14px] text-gray-700'>11-07-2025 19:00:11</span>
                        <div className='bg-gray-100 border w-[32px] h-[32px] top-[-10px] shadow-lg rounded-full group-hover:flex justify-center items-center cursor-pointer hidden hover:text-primary-500 transition-all absolute right-0 '>
                          <Trash size={14} className='text-gray-600 '/>
                        </div>
                      </div>
                    </div>
                  </div>
                  {/* item */}
                  <div className='flex gap-4 p-3 cursor-pointer transition-all hover:bg-primary-50'>
                    <div>
                      <Image 
                        src={'/images/defaults/default1.jpg'}
                        width={56}
                        height={56}
                        className="object-cover rounded-lg"
                        alt='BAMBOO AIRWAYS THÔNG BÁO'
                      />
                    </div>
                    <div className='flex-1'>
                      <h3 className=' text-md font-semibold'>BAMBOO AIRWAYS THÔNG BÁO</h3>
                      <span className='text-[14px] text-gray-700 line-clamp-3'>Đặt vé hôm nay để chọn chỗ mong muốn hoàn toàn miễn phí cùng Bamboo từ 11/07-17/07/2025!</span>
                      <div className='mt-3 flex justify-between group relative'>
                        <span className='text-[14px] text-gray-700'>11-07-2025 19:00:11</span>
                        <div className='bg-gray-100 border w-[32px] h-[32px] top-[-10px] shadow-lg rounded-full group-hover:flex justify-center items-center cursor-pointer hidden hover:text-primary-500 transition-all absolute right-0 '>
                          <Trash size={14} className='text-gray-600 '/>
                        </div>
                      </div>
                    </div>
                  </div>
                  {/* item */}
                  <div className='flex gap-4 p-3 cursor-pointer transition-all hover:bg-primary-50'>
                    <div>
                      <Image 
                        src={'/images/defaults/default1.jpg'}
                        width={56}
                        height={56}
                        className="object-cover rounded-lg"
                        alt='BAMBOO AIRWAYS THÔNG BÁO'
                      />
                    </div>
                    <div className='flex-1'>
                      <h3 className=' text-md font-semibold'>BAMBOO AIRWAYS THÔNG BÁO</h3>
                      <span className='text-[14px] text-gray-700 line-clamp-3'>Đặt vé hôm nay để chọn chỗ mong muốn hoàn toàn miễn phí cùng Bamboo từ 11/07-17/07/2025!</span>
                      <div className='mt-3 flex justify-between group relative'>
                        <span className='text-[14px] text-gray-700'>11-07-2025 19:00:11</span>
                        <div className='bg-gray-100 border w-[32px] h-[32px] top-[-10px] shadow-lg rounded-full group-hover:flex justify-center items-center cursor-pointer hidden hover:text-primary-500 transition-all absolute right-0 '>
                          <Trash size={14} className='text-gray-600 '/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </MenuList>
            </Menu>


						<ModelAuth/>
						
						<DrawerSidebar />
					</div>
				</div>
        <div className='py-2 flex gap-5'>
          <Link className='font-semibold hover:text-primary-500 transition-all' href={'/khach-san'}>Khách sạn</Link>
          <Link className='font-semibold hover:text-primary-500 transition-all' href={'/khach-san'}>Vé máy bay</Link>
          <Link className='font-semibold hover:text-primary-500 transition-all' href={'/mall/thuong-hieu-khach-san-hang-dau'}>Top thương hiệu <span className='bg-purple-500 font-normal text-sm rounded-md text-white px-1 py-[1px]'>mall</span></Link>
          <Link className='font-semibold hover:text-primary-500 transition-all' href={'/home-stay'}>Biệt thự, Homestay <span className='bg-purple-500 font-normal text-sm rounded-md text-white px-1 py-[1px]'>plus</span></Link>
          <Link className='font-semibold hover:text-primary-500 transition-all' href={'/budgethotels'}>Khách sạn tiết kiệm <span className='bg-purple-500 font-normal text-sm rounded-md text-white px-1 py-[1px]'> -100k</span></Link>
          <Link className='font-semibold hover:text-primary-500 transition-all' href={'/tour'}>Tour nước ngoài <span className='bg-purple-500 font-normal text-sm rounded-md text-white px-1 py-[1px]'> -1tr</span></Link>
          <Link className='font-semibold hover:text-primary-500 transition-all' href={'/uu-dai/bao-hiem'}>Bảo hiểm <span className='bg-purple-500 font-normal text-sm rounded-md text-white px-1 py-[1px]'> -50%</span></Link>
          <div className='pl-12 cursor-pointer text-gray-600'>
            <Ellipsis className='text-gray-600'/>
          </div>
        </div>
			</div>
		</div>
	);
}

export default Header;
