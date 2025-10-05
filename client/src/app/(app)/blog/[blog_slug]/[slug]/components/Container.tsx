'use client'
import SkeBlogList from '@/components/shared/Skeleton/SkeBlogList';
import { IPostItem, SGetPostDetail } from '@/services/app/blog/SGetPostDetail';
import { FormatDate } from '@/utils/common';
import Image from 'next/image';
import Link from 'next/link';
import { useEffect, useState } from 'react';

type props ={
    blog_slug:string,
    slug:string
   
}
function Container({blog_slug,slug}:props) {
    const [post,setPost] = useState<IPostItem|null>(null)
    const [isLoading,setIsLoading] = useState(true)
    useEffect(()=>{
       setIsLoading(true)
        SGetPostDetail({data_value:slug,related:true,category_slug:blog_slug}).then(res=>{
            setIsLoading(false)
            setPost(res)
        })
    },[slug,blog_slug])
    return (
     <div className="w-content m-auto py-14">
            <h1 className="text-5xl font-bold">{post?.name}</h1>
            <div className="flex gap-2 text-gray-600 my-5 mb-12">
                <div>{post?.author.full_name}</div> - <div>{post?.created_at && FormatDate(post?.created_at??'')}</div>
            </div>
            <div className='my-5' dangerouslySetInnerHTML={{__html:post?.description ??''}}>

            </div>

            <div className='mt-14'>
                <div className='font-semibold text-2xl'>Bài viết liên quan</div>
                    {isLoading ? <div className="mt-8"><SkeBlogList/></div> : 
            <div className="w-100 grid grid-cols-4 gap-5 py-16 pt-6">
                { post?.related.map(item=>{
                    return <Link href={'/blog/'+post?.category?.slug+'/'+item.slug} key={item.id} className='flex flex-col gap-2 cursor-pointer'>
                    <div className=' relative h-[198px] overflow-hidden rounded-xl'>
                        <Image
                        fill
                        alt=''
                        src={item.image ??'/images/common/hotel_1.jpg'}
                        className=' object-cover w-full h-full rounded-xl hover:scale-110 transition-all'
                        />
                    </div>
                    <h2 className='font-semibold line-clamp-2 hover:text-primary-500'>{item.name}
                    </h2>
                    <div className='flex gap-4 items-center text-[14px] text-gray-500'>
                      <div>{FormatDate(item.created_at)}</div>
                      <div className='w-[6px] h-[6px] rounded-full bg-gray-400'></div>
                      <div>{item.author.full_name}</div>
                    </div>
                </Link>
                })}
            </div>}
            </div>
        </div>
  )
}

export default Container