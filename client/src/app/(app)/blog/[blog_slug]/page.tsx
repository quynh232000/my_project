import Container from "./components/Container";

export default async function Page({
  params,
}: {
  params: Promise<{ blog_slug: string };>
}) {
  const {blog_slug} = await params
  return (
    <div className="mt-[148px]">
      <Container blog_slug={blog_slug} />
    </div>
  );
}
