'use client';
import { Home, Hotel,  Navigation, Plane } from 'lucide-react';
import Link from 'next/link';
import { useState } from 'react';
type props = {
    setNavActiveKey:(key:string) => void
}
function NavHead({setNavActiveKey}:props) {
    const dataNavs = [
        {
            id:1,
            key:'hotel',
            icon:<Hotel className='hover:text-primary-500'/>,
            url:'khach-san',
            badge:<span className="absolute bottom-[115%] bg-primary-500 normal-case font-normal text-sm text-white px-1 rounded-lg rounded-bl-none">-400k</span>,
            name:'Khách sạn'
        },
        {
            id:2,
            key:'plane',
            icon:<Plane className='hover:text-primary-500'/>,
            url:'ve-may-bay',
            badge:<span className="absolute bottom-[115%] text-primary-500 normal-case  text-sm border-primary-500 border  bg-white font-bold px-1 rounded-lg rounded-bl-none">-300k</span>,
            name:'Vé máy bay'
        },
        {
            id:3,
            key:'tour',
            icon:<Navigation className='hover:text-primary-500'/>,
            url:'tour',
            badge:<span className="absolute bottom-[115%] bg-primary-500 normal-case font-normal text-sm text-white px-1 rounded-lg rounded-bl-none">-1tr</span>,
            name:'Tour nước ngoài'
        },
        {
            id:4,
            key:'homestay',
            icon:<Home className='hover:text-primary-500'/>,
            url:'homestay',
            badge:'',
            name:'Biệt thự, Homestay'
        },
	]
	const [navActive,setNavActive] = useState(dataNavs[0])
    const handleClickNav = (item:any)=>{
            setNavActive(item)
            setNavActiveKey(item.url)
        }
  return (
    <div className='flex gap-10 justify-center  w-full border-b'>
        {dataNavs.map(item=>{
            return <Link onClick={()=> handleClickNav(item)} key={item.id} href={'#'} className={'flex items-center gap-2 font-semibold border-b-2  hover:border-primary-500 py-3 hover:text-primary-500 ' 
                    +(item.id == navActive.id ? ' text-primary-500 border-primary-500': ' border-transparent')}>
                {item.icon}
                <div className="relative hover:text-primary-500">
                    {item.badge}
                    {item.name}
                </div>
        </Link>
        })}
    </div>
  )
}

export default NavHead