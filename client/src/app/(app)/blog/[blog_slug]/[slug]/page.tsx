

import Container from "./components/Container";


interface PageProps {
  params: {
    blog_slug: string;
    slug:string;
  };
}
export default async function page({params}:PageProps) {
   
  return (
    <div className='mt-[148px]'>
        <Container blog_slug={params.blog_slug} slug={params.slug}/>
       
    </div>
  )
}