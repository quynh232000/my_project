import { Suspense } from "react";
import Container from "./components/Container"


async function Page({ params }: { params:Promise< { type: string; }> }) {
  const { type } =await params;
  return (
    <div className="mt-[148px] bg-gray-50">
      <Suspense fallback={<div>Đang tải...</div>}>
          
        <Container type={type}/>
            </Suspense>
    </div>
  )
}

export default Page