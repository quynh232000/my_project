

import Container from "./components/Container";


export default async function Page({ params }: { params: { blog_slug: string; slug: string } }) {
  const { blog_slug, slug } = params;

  return (
    <div className='mt-[148px]'>
      <Container blog_slug={blog_slug} slug={slug} />
    </div>
  );
}
