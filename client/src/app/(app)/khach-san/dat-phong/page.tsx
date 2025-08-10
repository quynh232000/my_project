// app/[token]/page.tsx
import React, { Suspense } from 'react';
import Container from './compnents/Container'
import SkeLoading from '@/components/shared/Skeleton/SkeLoading';

async function Page({ searchParams  }: { searchParams : Promise< { token: string; }> }) {
  const { token } = await searchParams ;
  return (
    <div className="mt-[148px]">
      <Suspense fallback={<SkeLoading />}>
        <Container token={token} />
      </Suspense>
    </div>
  );
}

export default Page;
