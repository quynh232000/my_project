

import { Suspense } from "react";
import Container from "./components/Container";
import SkeLoading from "@/components/shared/Skeleton/SkeLoading";


export default async function Page({ params }: { params:Promise< { blog_slug: string; slug: string }> }) {
  const { blog_slug, slug } =await params;

  return (
    <div className='mt-[148px]'>
      <Suspense fallback={<SkeLoading/>}>
      <Container blog_slug={blog_slug} slug={slug} />
              {/* <Container/> */}
            </Suspense>
    </div>
  );
}
