'use client'

import Pagination from "@/components/shared/Pagination/Pagination";
import SkeBlogList from "@/components/shared/Skeleton/SkeBlogList";
import { Category2, getPostList, IPostItem } from "@/services/app/blog/getBlogFeature";
import { FormatDate } from "@/utils/common";
import Image from "next/image";
import Link from "next/link";
import { useSearchParams } from "next/navigation";
import { useEffect, useState } from "react";
import { FaAngleRight } from "react-icons/fa6";

interface PageProps {
  blog_slug:string;
}
function Container({ blog_slug }: PageProps) {
   const searchParams = useSearchParams();
  const [data,setData] = useState<IPostItem[]>([])
  const [total,setTotal] = useState(0)
  const page = Number(searchParams.get('page')) || 1
  
 const limit = 8
  const [category,setCategory] = useState<Category2>()
    const [isLoading,setIsLoading] = useState(true)
     useEffect(()=>{
      setIsLoading(true)
        getPostList({limit,slug:blog_slug,page}).then(res=>{
          setIsLoading(false)
  
          if(res){
            setCategory(res.category)
            setData(res.list)
            setTotal(res.total_item)
          }
        })
     },[page])
  return (
    <div className="flex flex-col ">
        <div className="w-full relative bg-primary-500 ">
            <div className="w-content m-auto py-5 ">
                <div className="flex gap-2 items-center text-[14px] text-white font-semibold">
                    <Link href={'/'} className="">Trang chủ</Link>
                    <FaAngleRight className="text-gray-300"/>
                    <Link href={'/blog'}>Bài viết</Link>
                    <FaAngleRight className="text-gray-300"/>
                    <div >{category?.name}</div>
                </div>
                <div className="w-[80%] m-auto text-center text-white py-6">
                    <h2 className="   text-4xl font-semibold">{category?.name}</h2>
                    <div>{category?.description}</div>

                </div>
            </div>
        </div>
        <div className="w-content m-auto">
            {isLoading ? <div className="mt-8"><SkeBlogList/></div> : 
            <div className="w-100 grid grid-cols-4 gap-5 py-16">
                { data.map(post=>{
                    return <Link href={'/blog/'+category?.slug+'/'+post.slug} key={post.id} className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={post.image ??'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>{post.name}
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>{FormatDate(post.created_at)}</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>{post.author.full_name}</div>
                    </div>
                </Link>
                })}
            </div>}
            <div>
                    <Pagination total={total} limit={limit} />
            </div>
            <div className="mt-5 mb-16" dangerouslySetInnerHTML={{__html:category?.content ?? ''}}>
            </div>
        </div>
    </div>
  )
}

export default Container