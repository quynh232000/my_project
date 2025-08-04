import Container from "./components/Container"


async function Page({ params }: { params:Promise< { type: string; }> }) {
  const { type } =await params;
  return (
    <div className="mt-[148px] bg-gray-50">
        <Container type={type}/>
    </div>
  )
}

export default Page