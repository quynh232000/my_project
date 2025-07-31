
import Container from "./components/Container"
interface PageProps {
  params: {
    blog_slug: string;
  };
}
export default async function Page({ params }: PageProps) {
  return (
    <div className='mt-[148px]'>
      <Container blog_slug={params.blog_slug} />
    </div>
  );
}
