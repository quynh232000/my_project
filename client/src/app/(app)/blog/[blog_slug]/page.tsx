import { Suspense } from "react";
import Container from "./components/Container";

export default async function Page({
  params,
}: {
  params: Promise<{ blog_slug: string }>
}) {
  const {blog_slug} = await params
  return (
    <div className="mt-[148px]">
      <Suspense fallback={<div>Đang tải...</div>}>
      <Container blog_slug={blog_slug} />
              {/* <Container/> */}
            </Suspense>
    </div>
  );
}
