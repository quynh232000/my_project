import Container from "./components/Container";

export default async function Page({
  params,
}: {
  params: { blog_slug: string };
}) {
  return (
    <div className="mt-[148px]">
      <Container blog_slug={params.blog_slug} />
    </div>
  );
}
